<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Medical Streams</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>
<body>
    <div id="main-container">
        <div id="video-container" class="hidden">
            <div id="video-streams"></div>
            <div id="stream-controls">
                <button id="leave-btn">Leave Stream</button>
                <button id="mic-btn">Mic On</button>
                <button id="camera-btn">Camera on</button>
                <button id="screen-btn">Share Screen</button>
            </div>
        </div>
        
        <div id="homepage">
            <header>
                <h1>Medical Streams</h1>
                
            </header>
            <main>
                <section id="features">
                    
                </section>
                <section id="get-started">
                    <h2>Get Started</h2>
                    <button id="join-btn">Join Stream</button>
                    <button id="create-btn">Create Stream</button>
                </section>
            </main>
            <footer>
                <p>&copy; 2024 Ivy Streams. All rights reserved.</p>
            </footer>
        </div>
    </div>
    
    <script src="{{ asset('js/AgoraRTC_N-4.22.0.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>