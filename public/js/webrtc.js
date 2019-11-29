let localVideoEl = document.getElementById("local-video");
let remoteVideoEl = document.getElementById('remote-video');
let signalingChannel = null;
let localStream = null;
let remoteStream = null;
let peerConfig = {
    iceServers: [
        { urls: ["stun:stun.l.google.com:19302"] },
    ]
};

let peer = new RTCPeerConnection(peerConfig);

let logArea = document.getElementById("log-area");

function log(message) {
    let messageEl = document.createElement('p');
    messageEl.classList.add('mb-1');
    messageEl.appendChild(document.createTextNode(message));
    logArea.insertBefore(messageEl, logArea.firstChild);
    return messageEl;
}
function logError(message) {
    let messageEl = log(message);
    messageEl.classList.add('text-red-700');
}
function logSuccess(message) {
    let messageEl = log(message);
    messageEl.classList.add("text-green-700");
}


async function createAndSendOffer() {
    log('negotiation needed: sending offer...');
    const sdp = await peer.createOffer();
    await peer.setLocalDescription(sdp);
    sendSignal('offer', sdp);
    logSuccess('offer signal sent...');
}
async function onAnswerReceived({answer}) {
    log('answer received...')
    await peer.setRemoteDescription(answer);
}

async function onOfferReceived({offer}) {
    log('offer received...');
    await peer.setRemoteDescription(offer);
    createAndSendAnswer();
}
async function createAndSendAnswer() {
    log('offer received: sending answer...');
    const sdp = await peer.createAnswer();
    await peer.setLocalDescription(sdp);
    sendSignal('answer', sdp);
    logSuccess('answer signal sent..')
}

async function onIceCandidateFound(e) {
    if (e.candidate) {
        sendSignal('candidate', e.candidate);
    }
}
function onIceCandidateReceived({candidate}) {
    log('candidate candidate received...');
    peer.addIceCandidate(candidate);
}

function onLocalStreamReceived(stream) {
    logSuccess('local stream received...');
    localStream = stream;
    stream.getTracks().forEach(track => peer.addTrack(track, stream));
    localVideoEl.srcObject = stream;
    localVideoEl.play();
}
function handleLocalStreamError(error) {
    logError(error);
}

function onRemoteStreamReceived(stream) {
    logSuccess('remote stream received...');
    remoteStream = stream;
    if(! remoteVideoEl.srcObject && stream) {
        remoteVideoEl.srcObject = stream;
        remoteVideoEl.play();
    }
}

function getUserMedia(constraints) {
    log('retrieving local stream...');
    return window.navigator.mediaDevices
        .getUserMedia(constraints);
}

function sendSignal(type, message) {
    signalingChannel.whisper(type, {[type]: message})
}

function onSignal(type, callback) {
    signalingChannel.listenForWhisper(type, callback);
}

function startCall(isInitiator) {
    peer.ontrack = e => {
        onRemoteStreamReceived(e.streams[0]);
    }
    peer.onicecandidate = onIceCandidateFound;
    signalingChannel = window.Echo.private(window.Laravel.channelName)
    onSignal('candidate', onIceCandidateReceived)

    if(isInitiator) {
        peer.onnegotiationneeded = createAndSendOffer;
        onSignal('answer', onAnswerReceived);
    } else {
        onSignal('offer', onOfferReceived);
    }

    getUserMedia({audio: true, video: true}).then(onLocalStreamReceived);

}

startCall(window.Laravel.isInitiator);
