function loadCamera(id){
    var video = document.getElementById(id);
        video.setAttribute('autoplay', '');
        video.setAttribute('muted', '');
        video.setAttribute('playsinline', '');

    if (navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({audio: false, video: {facingMode: 'user'}})
        .then( function(stream) {
            video.srcObject = stream;
        })
        .catch(function(error) {
            if(document.querySelector('.needCamera') != null){
                document.querySelectorAll('.needCamera').forEach(fail => {
                    fail.classList.add('disabled');
                });
            }
        });
    }
}

function takeSnapShot(id){
    var videoo = document.getElementById(id);
    var canvas = document.createElement('canvas');
    canvas.width = videoo.videoWidth;
    canvas.height = videoo.videoHeight;
    var ctx = canvas.getContext('2d');
    ctx.drawImage(videoo, 0, 0, canvas.width, canvas.height);
    var dataURI = canvas.toDataURL('image/jpeg'); 
    return dataURI;
}