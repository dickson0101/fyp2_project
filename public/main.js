let Peer = require('simple-peer');
let socket = io();
const video = document.querySelector('video');
const filter = document.querySelector('#filter');
const checkboxTheme = document.querySelector('#theme');
let client = {};
let currentFilter;

navigator.mediaDevices.getUserMedia({ video: true, audio: true })
    .then(stream => {
        socket.emit('NewClient');
        video.srcObject = stream;
        video.play();

        filter.addEventListener('change', (event) => {
            currentFilter = event.target.value;
            video.style.filter = currentFilter;
            SendFilter(currentFilter);
            event.preventDefault();
        });

        // Function to initialize the peer connection
        function InitPeer(type) {
            let peer = new Peer({
                initiator: (type === 'init'),
                stream: stream,
                trickle: false
            });

            peer.on('stream', function (peerStream) {
                console.log('Receiving peer stream');
                CreateVideo(peerStream);
            });

            peer.on('data', function (data) {
                let decodedData = new TextDecoder('utf-8').decode(data);
                let peerVideo = document.querySelector('#peerVideo');
                if (peerVideo) {
                    peerVideo.style.filter = decodedData;
                }
            });

            return peer;
        }

        // Create a new peer (the initiator)
        function MakePeer() {
            client.gotAnswer = false;
            let peer = InitPeer('init');
            peer.on('signal', function (data) {
                if (!client.gotAnswer) {
                    socket.emit('Offer', data);
                }
            });
            client.peer = peer;
        }

        // When an offer is received, respond with an answer
        function FrontAnswer(offer) {
            let peer = InitPeer('notInit');
            peer.on('signal', (data) => {
                socket.emit('Answer', data);
            });
            peer.signal(offer);
            client.peer = peer;
        }

        function SignalAnswer(answer) {
            client.gotAnswer = true;
            let peer = client.peer;
            peer.signal(answer);
        }

        function CreateVideo(peerStream) {
            const videoContainer = document.querySelector('#peerDiv');
            let videoElement = document.createElement('video');
            videoElement.id = 'peerVideo';
            videoElement.srcObject = peerStream;
            videoElement.className = 'embed-responsive-item';
            videoElement.autoplay = true;
            videoContainer.appendChild(videoElement);

            setTimeout(() => SendFilter(currentFilter), 1000);
        }

        function SendFilter(filter) {
            if (client.peer) {
                client.peer.send(filter);
            }
        }

        function RemovePeer() {
            let peerVideo = document.getElementById("peerVideo");
            if (peerVideo) peerVideo.remove();

            let muteText = document.getElementById("muteText");
            if (muteText) muteText.remove();

            if (client.peer) {
                client.peer.destroy();
            }
        }

        socket.on('BackOffer', FrontAnswer);
        socket.on('BackAnswer', SignalAnswer);
        socket.on('SessionActive', () => document.write('Session Active. Please come back later'));
        socket.on('CreatePeer', MakePeer);
        socket.on('Disconnect', RemovePeer);
    })
    .catch(err => document.write(err));

checkboxTheme.addEventListener('click', () => {
    document.body.style.backgroundColor = checkboxTheme.checked ? '#212529' : '#fff';
    let muteText = document.querySelector('#muteText');
    if (muteText) {
        muteText.style.color = checkboxTheme.checked ? "#fff" : "#212529";
    }
});

function CreateDiv() {
    let div = document.createElement('div');
    div.setAttribute('class', "centered");
    div.id = "muteText";
    div.innerHTML = "Click to Mute/Unmute";
    document.querySelector('#peerDiv').appendChild(div);
    if (checkboxTheme.checked) {
        document.querySelector('#muteText').style.color = "#fff";
    }
}
