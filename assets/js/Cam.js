"use strict";

const Cam =  function(){
    return {
        input:null,
        preview:null,
        dataURI:null,
        video:document.getElementById('webCamera'),
        init(){
            Cam.video.setAttribute('autoplay', '');
            Cam.video.setAttribute('muted', '');
            Cam.video.setAttribute('playsinline', '');
            if (navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({audio: false, video: {facingMode: 'user'}})
                .then( function(stream) {
                    Cam.video.srcObject = stream;
                })
                .catch(function(error) {
                    alert(error);
                    if(document.querySelector('.needCamera') != null){
                        document.querySelectorAll('.needCamera').forEach(fail => {
                            fail.classList.add('disabled');
                            if(fail.querySelector('.alert') != null){
                                fail.querySelector('.alert').classList.remove('d-none');
                                fail.querySelector('.alert').innerHTML = 'Infelizmente não foi localizado nenhum dispositivo para captura de imagem.';
                            }
                        });
                    }
                });
            }
            return Cam;
        },
        inputVal(id){
            Cam.input = document.getElementById(id);
            return Cam;
        },
        previewImg(id){
            Cam.preview = document.getElementById(id);
            return Cam;
        },
        snapShot($return){
            var canvas = document.createElement('canvas');
            canvas.width = Cam.video.videoWidth;
            canvas.height = Cam.video.videoHeight;
            var ctx = canvas.getContext('2d');
            ctx.drawImage(Cam.video, 0, 0, canvas.width, canvas.height);
            Cam.dataURI = canvas.toDataURL('image/jpeg');

            if(Cam.preview !== null){
                Cam.preview.src = Cam.dataURI;
            }

            if($return){
                return Cam.dataURI;
            }

            return Cam;            
        },
        save(){
            if(Cam.input !== null){
                Cam.input.value = Cam.dataURI;
            }

            if(Cam.preview !== null){
                Cam.preview.src = Cam.dataURI;
            }

            document.querySelector('dialog#camera [close]').click();
            return Cam;
        },
        capture(){
            let img = Cam.snapShot('webCamera', true);
            document.querySelector('#webCameraPreview').setAttribute('src',img);
        }
    };
}();