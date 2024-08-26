const socket = io('http://127.0.0.1:8000'); // 确保地址和端口号正确
let peerConnection;
let localStream;
let remoteStream;
let mediaRecorder;
let recordedChunks = [];
let roomCode = '';

// 连接到服务器
socket.on('connect', () => {
    console.log('Connected to server');
    roomCode = document.getElementById('roomCode').value;
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

function generateRandomRoomCode() {
    return Math.floor(10000 + Math.random() * 90000).toString(); // 生成5位随机数
}

async function joinRoom(roomCodeInput) {
    if (!roomCodeInput) {
        roomCode = generateRandomRoomCode();
        document.getElementById('roomCode').value = roomCode; // 显示生成的房间号
    } else {
        roomCode = roomCodeInput;
    }

    socket.emit('joinRoom', roomCode);
    console.log(`Joining room: ${roomCode}`);
    document.getElementById('joinRoomButton').disabled = true;
    document.getElementById('roomCode').disabled = true;
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

async function showStats() {
    if (peerConnection) {
        const stats = await peerConnection.getStats();
        let statsOutput = '';

        stats.forEach(report => {
            statsOutput += `<h2>Report: ${report.type}</h2>\n<strong>ID:</strong> ${report.id}<br>\n` +
                           `<strong>Timestamp:</strong> ${report.timestamp}<br>\n`;

            Object.keys(report).forEach(statName => {
                if (statName !== 'id' && statName !== 'timestamp' && statName !== 'type') {
                    statsOutput += `<strong>${statName}:</strong> ${report[statName]}<br>\n`;
                }
            });
        });

        document.getElementById('statsContainer').innerHTML = statsOutput;
    } else {
        alert('No active peer connection to show stats for.');
    }
}

document.getElementById('joinRoomButton').addEventListener('click', () => joinRoom(document.getElementById('roomCode').value));
document.getElementById('startButton').addEventListener('click', startVideo);
document.getElementById('stopButton').addEventListener('click', stopVideo);
document.getElementById('recordButton').addEventListener('click', startRecording);
document.getElementById('stopRecordButton').addEventListener('click', stopRecording);
document.getElementById('showStatsButton').addEventListener('click', showStats);
