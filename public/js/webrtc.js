const socket = io('http://127.0.0.1:8000'); // Ensure the address and port are correct
let peerConnection;
let localStream;
let remoteStream;
let mediaRecorder;
let recordedChunks = [];
let roomCode = '12345'; // Default room code, can be changed by user input

// Connection to the server
socket.on('connect', () => {
    console.log('Connected to server');
});

socket.on('disconnect', () => {
    console.log('Disconnected from server');
});

socket.on('offer', async (offer) => {
    console.log('Received offer:', offer);
    if (!peerConnection) createPeerConnection();
    await peerConnection.setRemoteDescription(new RTCSessionDescription(offer));
    const answer = await peerConnection.createAnswer();
    await peerConnection.setLocalDescription(answer);
    socket.emit('answer', answer, roomCode);
});

socket.on('answer', async (answer) => {
    console.log('Received answer:', answer);
    if (peerConnection) {
        await peerConnection.setRemoteDescription(new RTCSessionDescription(answer));
    }
});

socket.on('candidate', async (candidate) => {
    console.log('Received candidate:', candidate);
    if (peerConnection) {
        await peerConnection.addIceCandidate(new RTCIceCandidate(candidate));
    }
});

function joinRoom() {
    roomCode = document.getElementById('roomCode').value.trim();
    if (roomCode === '') {
        alert('Please enter a room code.');
        return;
    }
    socket.emit('joinRoom', roomCode);
    console.log(Joining);
    document.getElementById('joinRoomButton').disabled = true;
    document.getElementById('roomCode').disabled = true;
}

function clearRoomCode() {
    document.getElementById('roomCode').value = '';
    document.getElementById('joinRoomButton').disabled = false;
    document.getElementById('roomCode').disabled = false;
}

function createPeerConnection() {
    const configuration = {
        iceServers: [
            { urls: 'stun:stun.l.google.com:19302' },
            { urls: 'turn:your.turn.server', username: 'user', credential: 'pass' }
        ]
    };

    peerConnection = new RTCPeerConnection(configuration);
    peerConnection.ontrack = event => {
        remoteStream = event.streams[0];
        document.getElementById('remoteVideo').srcObject = remoteStream;
    };

    peerConnection.onicecandidate = event => {
        if (event.candidate) {
            console.log('New ICE candidate:', event.candidate);
            socket.emit('candidate', event.candidate, roomCode);
        }
    };
}

async function startVideo() {
    try {
        localStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
        console.log('Got MediaStream:', localStream);
        document.getElementById('localVideo').srcObject = localStream;

        if (!peerConnection) createPeerConnection();

        localStream.getTracks().forEach(track => peerConnection.addTrack(track, localStream));

        const offer = await peerConnection.createOffer();
        await peerConnection.setLocalDescription(offer);
        socket.emit('offer', offer, roomCode);

    } catch (error) {
        console.error('Error starting video:', error);
    }
}

async function stopVideo() {
    if (localStream) {
        localStream.getTracks().forEach(track => track.stop());
        document.getElementById('localVideo').srcObject = null;
    }
    if (remoteStream) {
        document.getElementById('remoteVideo').srcObject = null;
    }
    if (peerConnection) {
        peerConnection.close();
        peerConnection = null;
    }
    console.log('Video stopped');
}


async function startScreenShare() {
    try {
        const screenStream = await navigator.mediaDevices.getDisplayMedia({ video: true });
        const videoTrack = screenStream.getVideoTracks()[0];
        const sender = peerConnection.getSenders().find(s => s.track.kind === 'video');

        if (sender) {
            await sender.replaceTrack(videoTrack);

            // Trigger renegotiation after screen sharing starts
            const offer = await peerConnection.createOffer();
            await peerConnection.setLocalDescription(offer);
            socket.emit('offer', offer, roomCode);
        }

        videoTrack.onended = async () => {
            // Switch back to the camera video track after screen sharing ends
            const cameraTrack = localStream.getVideoTracks()[0];
            await sender.replaceTrack(cameraTrack);

            // Renegotiate to go back to the camera video stream
            const offer = await peerConnection.createOffer();
            await peerConnection.setLocalDescription(offer);
            socket.emit('offer', offer, roomCode);
            console.log('Screen sharing stopped.');
        };
    } catch (error) {
        console.error('Error starting screen share:', error);
    }
}


function startRecording() {
    if (localStream) {
        recordedChunks = [];
        mediaRecorder = new MediaRecorder(localStream);
        mediaRecorder.ondataavailable = function(event) {
            if (event.data.size > 0) {
                recordedChunks.push(event.data);
            }
        };
        mediaRecorder.onstart = function() {
            alert('Recording has started. Please ensure confidentiality.');
        };
        mediaRecorder.onstop = function() {
            const blob = new Blob(recordedChunks, { type: 'video/webm' });
            const url = URL.createObjectURL(blob);
            const downloadLink = document.getElementById('downloadLink');
            downloadLink.href = url;
            downloadLink.style.display = 'block';
            downloadLink.download = 'recording.webm';
        };
        mediaRecorder.start();
    } else {
        alert('No media stream available for recording.');
    }
}

function stopRecording() {
    if (mediaRecorder) {
        mediaRecorder.stop();
    } else {
        alert('No recording in progress.');
    }
}

// Event Listeners
document.getElementById('startButton').addEventListener('click', startVideo);
document.getElementById('stopButton').addEventListener('click', stopVideo);
document.getElementById('screenShareButton').addEventListener('click', startScreenShare);
document.getElementById('recordButton').addEventListener('click', startRecording);
document.getElementById('stopRecordButton').addEventListener('click', stopRecording);
document.getElementById('joinRoomButton').addEventListener('click', joinRoom);
document.getElementById('clearRoomCodeButton').addEventListener('click', clearRoomCode);