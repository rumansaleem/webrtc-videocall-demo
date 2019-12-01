/**
 * +-------------------------------------------------------------+ 
 * | On Screen Log functions, to debug easily on mobile phone.   |
 * +-------------------------------------------------------------+
 */

let logArea = document.getElementById("log-area");

/**
 * Push a log Message to the log area.
 * 
 * @param  {String} message string
 * @return {HTMLElement} newly added message element
 */
function log(message) {
    let messageEl = document.createElement('p');
    messageEl.classList.add('mb-1');
    messageEl.appendChild(document.createTextNode(message));
    logArea.insertBefore(messageEl, logArea.firstChild);
    return messageEl;
}

/**
 * Push a log message with error context (red)
 * 
 * @param  {String} message string
 * @return {HTMLElement} newly added message element
 */
function logError(message) {
    let messageEl = log(message);
    messageEl.classList.add('text-red-700');
    return messageEl;
}

/**
 * Push a log message with success context (green)
 * 
 * @param  {String} message string
 * @return {HTMLElement} newly added message element
 */
function logSuccess(message) {
    let messageEl = log(message);
    messageEl.classList.add("text-green-700");
    return messageEl;
}



/**
 * +-------------------------------+ 
 * | Global Variables              |
 * +-------------------------------+
 */

// HTML Elements for remote and local video.
let localVideoEl = document.getElementById("local-video");
let remoteVideoEl = document.getElementById('remote-video');

// Channel to send and receive signals (laravel-echo)
let signalingChannel = null;

// MediaStream from local and remote peer.
let localStream = null;
let remoteStream = null;

// Configuration of peer connection 
let peerConfig = {
    iceServers: [
        // Google's public STUN server, should use own STUN server.
        { urls: ["stun:stun.l.google.com:19302"] }, 
    ]
};
// Create an new Peer Connection.
let peer = new RTCPeerConnection(peerConfig);



/**
 * +-------------------------------+ 
 * | Initiator's End of Functions  |
 * +-------------------------------+
 *
 * Only relevant if the client has initiated a video call.
 */

/**
 * creates an Offer SDP sets Local description 
 * and send through singaling channel.
 * 
 * @return {void}
 */
async function createAndSendOffer() {
    log('negotiation needed: sending offer...');
    const sdp = await peer.createOffer();
    await peer.setLocalDescription(sdp);
    sendSignal('offer', sdp);
    logSuccess('offer signal sent...');
}


/**
 * when answer is received through singaling channel, 
 * sets remote description.
 * 
 * @param  {Object} event
 * @param {RTCSessionDescription} event.answer 
 * @return {void}
 */
async function onAnswerReceived({answer}) {
    log('answer received...')
    await peer.setRemoteDescription(answer);
}



/**
 * +-------------------------------+ 
 * | Joinee's End of Functions     |
 * +-------------------------------+
 * 
 * Only relevant if the client side is joining a video call.
 */


/**
 * called on receiving offer, sets remote description, 
 * creates and sends the answer SDP.
 * 
 * @param  {Object} event
 * @param {RTCSessionDescription} event.offer
 * @return {void}
 */
async function onOfferReceived({offer}) {
    log('offer received...');
    await peer.setRemoteDescription(offer);
    createAndSendAnswer();
}


/**
 * creates an answer SDP, sets local description,
 * sends answer SDP through signaling channel.
 * 
 * @return {RTCSessionDescription} answer created and sent
 */
async function createAndSendAnswer() {
    log('offer received: sending answer...');
    const sdp = await peer.createAnswer();
    await peer.setLocalDescription(sdp);
    sendSignal('answer', sdp);
    logSuccess('answer signal sent..');
    return sdp;
}



/**
 * +---------------------------------+ 
 * | Ice Candidate Exhange Functions |
 * +---------------------------------+
 */


/**
 * called when ICE layer discovers new ICE candidate, sends the 
 * discovered ICE candidate through signaling channel.
 * 
 * @param  {Object} event
 * @param {RTCIceCandidate} event.candidate 
 * @return {void}
 */
async function onIceCandidateFound(event) {
    if (event.candidate) {
        sendSignal('candidate', event.candidate);
    }
}

/**
 * called when ICE candidate is received through singaling channel,
 * adds the received ICE candidate to the peer connection.
 * 
 * @param  {Object} event
 * @param {RTCIceCandidate} event.candidate 
 * @return {void}
 */
function onIceCandidateReceived({candidate}) {
    log('candidate candidate received...');
    peer.addIceCandidate(candidate);
}



/**
 * +----------------------------------------------+ 
 * | Media Stream Handling Functions.             |
 * +----------------------------------------------+
 */

/**
 * Called when local stream is received, sets the stream on 
 * video element, add the stream, to the peer connection.
 * 
 * @param  {MediaStream} stream
 * @return {void}
 */
function onLocalStreamReceived(stream) {
    logSuccess('local stream received...');

    // set global variable
    localStream = stream;

    // Add Tracks to peer connection
    stream.getTracks().forEach(track => peer.addTrack(track, stream));

    // Start playing the stream on video element.
    localVideoEl.srcObject = stream;
    localVideoEl.play();
}

/**
 * Called when some error occurs, retrieving the stream
 * due to user rejecting permission, etc.
 * 
 * @param  {Error}
 * @return {void}
 */
function handleLocalStreamError(error) {
    logError(error);
}

/**
 * Called when remote stream is received through remote offer.
 * 
 * @param  {MediaStream}
 * @return {void}
 */
function onRemoteStreamReceived(stream) {
    logSuccess('remote stream received...');

    // set global variable
    remoteStream = stream;

    // If stream has not started, already.
    if(! remoteVideoEl.srcObject && stream) {
        // Start playing the stream on video element.
        remoteVideoEl.srcObject = stream;
        remoteVideoEl.play();
    }
}

/**
 * retrive user's media with constraints provided.
 * 
 * @param  {Object} constraints.
 * @return {Promise} promise resolves to {MediaStream}.
 */
function getUserMedia(constraints) {
    log('retrieving local stream...');
    return window.navigator.mediaDevices
        .getUserMedia(constraints);
}

/**
 * Sends a Signal.
 * 
 * @param  {string} type - signal type
 * @param  {any} message 
 * @return {void}
 */
function sendSignal(type, message) {
    signalingChannel.whisper(type, {[type]: message})
}

/**
 * Registers a listener for signal.
 * 
 * @param  {string} type of singal to listen for
 * @param  {Function} callback - listener to registers
 * @return {void}
 */
function onSignal(type, callback) {
    signalingChannel.listenForWhisper(type, callback);
}

/**
 * Initialises event listeners for a call accordingly, 
 * weather the client is initiator or joinee.
 * 
 * @param  {Boolean} isInitiator 
 * @return {void} 
 */
function startCall(isInitiator) {
    // when peer receives remote stream.
    peer.ontrack = e => onRemoteStreamReceived(e.streams[0]);

    // when peer discovers ICE candidates.
    peer.onicecandidate = onIceCandidateFound;

    // Listen on Private channel,
    signalingChannel = window.Echo.private(window.Laravel.channelName)

    // Listen for `candidate` event on the signaling channel
    onSignal('candidate', onIceCandidateReceived)

    if(isInitiator) {
        // when the peer is ready for negotiation 
        // (addition/change of media stream or data channel)
        peer.onnegotiationneeded = createAndSendOffer;
        // Listen for answer signal from joinee's end on the same channel.
        onSignal('answer', onAnswerReceived);
    } else {
        // Listen for offer signal from initiator's end on the same channel.
        onSignal('offer', onOfferReceived);
    }

    // get user's media stream
    getUserMedia({audio: true, video: true}).then(onLocalStreamReceived);

}


// Start the Call.
startCall(window.Laravel.isInitiator); // window.Laravel is injected from blade.
