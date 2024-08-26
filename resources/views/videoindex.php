    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Video Call</title>
        <link rel="stylesheet" href="styles.css">
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                height: 100vh;
            }
            #video-container {
                display: flex;
                justify-content: center;
                align-items: center;
                margin-bottom: 20px;
            }
            video {
                width: 300px;
                height: auto;
                margin: 0 10px;
                border: 2px solid #ccc;
                border-radius: 8px;
            }
            #controls {
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            #controls button, #controls input, #controls textarea {
                margin: 5px;
                padding: 10px;
                border-radius: 4px;
                border: 1px solid #ccc;
            }
            #controls button {
                cursor: pointer;
                background-color: #007bff;
                color: white;
            }
            #controls button:hover {
                background-color: #0056b3;
            }
            #feedbackSection {
                margin-top: 20px;
            }
            #feedbackSection input {
                margin-right: 10px;
            }
            #statsContainer {
                margin-top: 20px;
                background-color: #fff;
                padding: 10px;
                border-radius: 4px;
                border: 1px solid #ccc;
            }
            #recordingsList a {
                display: block;
                margin-top: 10px;
                color: #007bff;
                text-decoration: none;
            }
            #recordingsList a:hover {
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
        <div id="video-container">
            <video id="localVideo" autoplay muted></video>
            <video id="remoteVideo" autoplay></video>
        </div>

        <div id="controls">
            <input type="text" id="roomCode" placeholder="Enter room code">
            <button id="joinRoomButton">Join Room</button>
            <button id="startButton">Start Video</button>
            <button id="stopButton">Stop Video</button>
            <button id="recordButton">Start Recording</button>
            <button id="stopRecordButton">Stop Recording</button>
            <a id="downloadLink" style="display:none;">Download recording</a>
            <button id="statsButton">Show Stats</button>
            <div id="statsContainer"></div>
            <div id="feedbackSection">
                <input type="radio" name="rating" value="1"> 1
                <input type="radio" name="rating" value="2"> 2
                <input type="radio" name="rating" value="3"> 3
                <input type="radio" name="rating" value="4"> 4
                <input type="radio" name="rating" value="5"> 5
                <textarea id="feedback" placeholder="Enter feedback"></textarea>
                <button id="submitFeedbackButton">Submit Feedback</button>
            </div>
            <div id="recordingsList"></div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.0.1/socket.io.js"></script>
        <script src="js/webrtc.js"></script>
    </body>
    </html>
