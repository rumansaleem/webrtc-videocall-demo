let localVideoEl = document.getElementById("local-video");
let remoteVideoEl = document.getElementById('remote-video');
let localStream = null;

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

function onLocalStreamReceived(stream) {
    logSuccess('local stream received...');
    localStream = stream;
    localVideoEl.srcObject = stream;
    localVideoEl.play();
}
function handleLocalStreamError(error) {
    logError(error);
}

function getUserMedia(constraints) {
    log('retriveing local stream...')
    return window.navigator.mediaDevices
        .getUserMedia(constraints);
}

// getUserMedia({ audio: true, video: true })
//     .then(onLocalStreamReceived)
//     .catch(handleLocalStreamError);

let channel = window.Echo.private('test')
    .listenForWhisper('ping', e => {
        log('Someone: ' + e.message);
        log('sending PONG...!');
        channel.whisper('pong', {message: 'PONG'});
    }).listenForWhisper('pong', e => {
        log('Someone: ' + e.message);
    });

let pingbtn = document.getElementById('ping-btn');
pingbtn.addEventListener('click', () => log('sending PING..!') && channel.whisper('ping', {message: 'PING'}));
