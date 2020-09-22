<dialog id="camera">
    <div style="min-width:50vw">
        <div class="heading">
            <span>Captura de imagem</span>
        </div>
        <div class="content p-4 pt-0">
            <form class="needCamera">
                <div class="alert alert-danger p-2 d-none" role="alert"></div>
                <div class="row">
                    <div class="col-sm-12 col-md-6 p-2 pt-4">
                        <div class="photo preview text-center">
                            <video autoplay="true" id="webCamera" poster="/assets/img/icon.cam.svg"></video>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 p-2 pt-4">
                        <div class="photo preview text-center">
                            <img id="webCameraPreview" src="/assets/img/icon.placeholder.svg" />
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 p-4 pb-1">
                        <button class="btn btn-primary w-100" onclick="Cam.capture()">Capturar</button>
                    </div>
                    <div class="col-sm-12 col-md-6 p-4 pb-1">
                        <button class="btn btn-primary w-100" onclick="Cam.save()">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</dialog>