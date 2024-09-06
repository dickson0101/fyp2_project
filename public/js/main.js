const APP_ID = "b3f0242982404e0d9ff3cd8a395f623f"
const TOKEN = "007eJxTYAh8Z1crefesm5pa2px1AmusSi63ruC5X7zp58ui2zlqrV8UGJKM0wyMTIwsLYxMDExSDVIs09KMk1MsEo0tTdPMjIzTYr5eS2sIZGSo6LrAwAiFID4LQ25iZh4DAwCesyE7"
const CHANNEL = "main"

const client = AgoraRTC.createClient({mode:'rtc', codec:'vp8'})

let localTracks = []
let remoteUsers = {}
let screenTrack

const switchToVideoView = () => {
    document.getElementById('homepage').classList.add('hidden');
    document.getElementById('video-container').classList.remove('hidden');
}

const switchToHomeView = () => {
    document.getElementById('video-container').classList.add('hidden');
    document.getElementById('homepage').classList.remove('hidden');
}

let joinAndDisplayLocalStream = async () => {
    switchToVideoView();

    client.on('user-published', handleUserJoined)
    client.on('user-left', handleUserLeft)
    
    let UID = await client.join(APP_ID, CHANNEL, TOKEN, null)
    
    localTracks = await AgoraRTC.createMicrophoneAndCameraTracks()

    let player = `<div class="video-container" id="user-container-${UID}">
                    <div class="video-player" id="user-${UID}"></div>
                  </div>`
    document.getElementById('video-streams').insertAdjacentHTML('beforeend', player)
    
    localTracks[1].play(`user-${UID}`)
    
    await client.publish([localTracks[0], localTracks[1]])
}

let handleUserJoined = async (user, mediaType) => {
    remoteUsers[user.uid] = user
    await client.subscribe(user, mediaType)

    if (mediaType === 'video'){
        let player = document.getElementById(`user-container-${user.uid}`)
        if (player != null){
            player.remove()
        }

        player = `<div class="video-container" id="user-container-${user.uid}">
                    <div class="video-player" id="user-${user.uid}"></div>
                  </div>`
        document.getElementById('video-streams').insertAdjacentHTML('beforeend', player)

        user.videoTrack.play(`user-${user.uid}`)
    }

    if (mediaType === 'audio'){
        user.audioTrack.play()
    }
}

let handleUserLeft = async (user) => {
    delete remoteUsers[user.uid]
    document.getElementById(`user-container-${user.uid}`).remove()
}

let leaveAndRemoveLocalStream = async () => {
    for(let i = 0; localTracks.length > i; i++){
        localTracks[i].stop()
        localTracks[i].close()
    }

    await client.leave()
    switchToHomeView()
    document.getElementById('video-streams').innerHTML = ''
}

let toggleMic = async (e) => {
    if (localTracks[0].muted){
        await localTracks[0].setMuted(false)
        e.target.innerText = 'Mic on'
        e.target.style.backgroundColor = 'cadetblue'
    }else{
        await localTracks[0].setMuted(true)
        e.target.innerText = 'Mic off'
        e.target.style.backgroundColor = '#EE4B2B'
    }
}

let toggleCamera = async (e) => {
    if(localTracks[1].muted){
        await localTracks[1].setMuted(false)
        e.target.innerText = 'Camera on'
        e.target.style.backgroundColor = 'cadetblue'
    }else{
        await localTracks[1].setMuted(true)
        e.target.innerText = 'Camera off'
        e.target.style.backgroundColor = '#EE4B2B'
    }
}

let toggleScreen = async (e) => {
    if(!screenTrack){
        screenTrack = await AgoraRTC.createScreenVideoTrack()
        await client.unpublish([localTracks[1]])
        await client.publish([screenTrack])
        
        screenTrack.on('track-ended', () => {
            toggleScreen(e)
        })
        
        e.target.innerText = 'Stop Sharing'
        e.target.style.backgroundColor = '#EE4B2B'
    }
    else {
        await client.unpublish([screenTrack])
        screenTrack.stop()
        screenTrack.close()
        screenTrack = null
        await client.publish([localTracks[1]])
        
        e.target.innerText = 'Share Screen'
        e.target.style.backgroundColor = 'cadetblue'
    }
}

document.getElementById('join-btn').addEventListener('click', joinAndDisplayLocalStream)
document.getElementById('create-btn').addEventListener('click', joinAndDisplayLocalStream)
document.getElementById('leave-btn').addEventListener('click', leaveAndRemoveLocalStream)
document.getElementById('mic-btn').addEventListener('click', toggleMic)
document.getElementById('camera-btn').addEventListener('click', toggleCamera)
document.getElementById('screen-btn').addEventListener('click', toggleScreen)