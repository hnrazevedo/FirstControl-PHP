<dialog id="register_car_form">
    <div>    
        <div class="heading">
            <span>Cadastro de novo veículo</span>
        </div>
        <div class="content">
            <form provider="car" role="carRegister" access="/controller/car">
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="photo preview text-center">
                            <img src="/assets/img/select.svg" id="carphoto"/>
                        </div>
                    </div>
                </div>
                <div class="row" style="max-width:700px">
                    <div class="col-sm-6  col-md-4 align-bottom d-flex align-items-end">
                        <button dialog="#camera" class="btn btn-primary w-100">Tirar foto</button>
                        <input type="hidden" id="new_carphoto" name="new_carphoto">
                    </div>
                    <div class="col-sm-6  col-md-4">
                        <input type="text" id="new_cpf" name="new_cpf" label="CPF motorista" data-mask="###.###.###-##">
                    </div>
                    <div class="col-sm-6  col-md-4">
                        <input type="text" id="new_board" name="new_board" label="Placa" maxlength="8">
                    </div>
                    <div class="col-sm-6  col-md-4">
                        <input type="text" id="new_brand" name="new_brand" label="Marca" maxlength="20">
                    </div>
                    <div class="col-sm-6  col-md-4">
                        <input type="text" id="new_model" name="new_model" label="Modelo" maxlength="20">
                    </div>
                    <div class="col-sm-6  col-md-4">
                        <input type="text" id="new_color" name="new_color" label="Cor" maxlength="10">
                    </div>
                    <div class="col-sm-6  col-md-4">
                        <input type="text" id="new_axes" name="new_axes" label="Nº de eixos" data-mask="#">
                    </div>
                    <div class="col-12">
                        <div class="buttons">
                            <button class="submit  btn btn-primary">Registrar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</dialog>



<dialog id="camera">
    <div class="p-2" style="min-width:50vw">
        <form class="needCamera">
            <div class="row">
                <div class="col-sm-12 col-md-6 p-2">
                    <div class="photo preview text-center">
                        <video autoplay="true" id="webCamera" poster="/assets/img/select.svg"></video>
                        <label>Camera</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 p-2">
                    <div class="photo preview text-center">
                        <img id="webCameraPreview" src="/assets/img/select.svg" />
                        <label>Captura</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 pb-2 p-4">
                    <button class="btn btn-primary w-100" onclick="capture()">Capturar</button>
                </div>
                <div class="col-sm-12 col-md-6 pb-2 p-4">
                    <button class="btn btn-primary w-100" onclick="save()">Salvar</button>
                </div>
            </div>
        </form>
    </div>
</dialog>
<script>
    window.addEventListener('load',function(){
        loadCamera('webCamera','camera');
    });

    function capture(){
        var img = takeSnapShot('webCamera');
        document.querySelector('#webCameraPreview').setAttribute('src',img);
    }

    function save(){
        document.getElementById('new_carphoto').value = document.getElementById('webCameraPreview').getAttribute('src');
        document.getElementById('carphoto').setAttribute('src',document.getElementById('webCameraPreview').getAttribute('src'));
        document.querySelector('dialog#camera [close]').click();
    }
</script>