<form access="/controller/car" class="ajax" method="post" id="newRegisterCar">
    <div class="col-12 row m-0">
        <div class="col-12 mb-4">
            <div class="photo preview text-center">
                <img src="/assets/img/icon.placeholder.svg" id="carphoto"/>
            </div>
        </div>
    </div>
    <div class="col-12 row m-0">
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="button" dialog="#camera" onclick="CamCar()" style="margin-top:2em" class="btn btn-primary w-100" value="Tirar foto" />
            <input type="hidden" id="new_carphoto" name="new_carphoto">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" id="new_cpf" name="new_cpf" label="CPF motorista" data-mask="###.###.###-##">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" id="new_board" name="new_board" label="Placa" maxlength="8">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" id="new_brand" name="new_brand" label="Marca" maxlength="20">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" id="new_model" name="new_model" label="Modelo" maxlength="20">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" id="new_color" name="new_color" label="Cor" maxlength="10">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
                <input type="text" id="new_axes" name="new_axes" label="Nº de eixos" data-mask="#">
        </div>
        <div class="col-12 row m-0 mt-4 p-0">
            <div class="col-sm-6 col-md-4 col-lg-3 ml-auto">
                <div class="buttons">
                    <button class="submit btn btn-lg btn-primary btn-block">Registrar</button>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="REQUEST_METHOD" value="AJAX" fixed="fixed">
    <input type="hidden" name="PROVIDER" value="car" fixed="fixed">
    <input type="hidden" name="ROLE" value="carRegister" fixed="fixed">
</form>

<script>
    function CamCar(){
        Cam.requerCam().inputVal('new_carphoto').previewImg('carphoto');
    }
</script>

<?= $this->import('global/cam') ?>