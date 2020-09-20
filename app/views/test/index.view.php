<html>
    <style>
        dy{
	font-family: sans-serif;
	margin: 0;
}

.area{
	margin: 10px auto;
	box-shadow: 0 10px 100px #ccc;
	padding: 20px;
	box-sizing: border-box;
	max-width: 500px;
}

.area video{
	width: 100%;
	height: auto;
	background-color: whitesmoke;
}

.area textarea{
	width: 100%;
	margin-top: 10px;
	height: 80px;
	box-sizing: border-box;
}

.area button{
	-webkit-appearance: none;
	width: 100%;
	box-sizing: border-box;
	padding: 10px;
	text-align: center;
	background-color: #068c84;
	color: white;
	text-transform: uppercase;
	border: 1px solid white;
	box-shadow: 0 1px 5px #666;
}

.area button:focus{
	outline: none;
	background-color: #0989b0;
}

.area img{
	max-width: 100%;
	height: auto;
}

.area .caminho-imagem{
	padding: 5px 10px;
	border-radius: 3px;
	background-color: #068c84;
	text-align: center;
}

.area .caminho-imagem a{
	color: white;
	text-decoration: none;
}

.area .caminho-imagem a:hover{
	color: yellow;
}
    </style>
    <body>
    <iv class="area">
			<video autoplay="true" id="webCamera">
			</video>
	
			<input  type="text" id="base_img" name="base_img"/>
			<button type="button" onclick="takeSnapShot()">Tirar foto e salvar</button>
	
			<img id="imagemConvertida"/>
			<p id="caminhoImagem" class="caminho-imagem"><a href="" target="_blank"></a></p>
			<script >


function loadCamera(){
	var video = document.querySelector("#webCamera");
		video.setAttribute('autoplay', '');
	    video.setAttribute('muted', '');
	    video.setAttribute('playsinline', '');
	if (navigator.mediaDevices.getUserMedia) {
		navigator.mediaDevices.getUserMedia({audio: false, video: {facingMode: 'user'}})
		.then( function(stream) {
			video.srcObject = stream;
		})
		.catch(function(error) {
			alert("Oooopps... Falhou :'(");
		});
	}
}
loadCamera();



                function takeSnapShot(){
	var video = document.querySelector("#webCamera");
	
	var canvas = document.createElement('canvas');
	canvas.width = video.videoWidth;
	canvas.height = video.videoHeight;
	var ctx = canvas.getContext('2d');
	
	ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

	var dataURI = canvas.toDataURL('image/jpeg'); 
	document.querySelector("#base_img").value = dataURI;
	
	
}
            </script>
</div>
    </body>
</html>