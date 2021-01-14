
<form access="/controller/car" class="pb-4 mt-4 m-auto ajax" id="editionCar"> 
    <div class="row  m-3">
        <div class="col-sm-6 col-md-6 mb-4">
            <h3 class="text-center">Foto atual</h3>
            <div class="photo preview ">
                <img src="{{ $system.uri }}/assets/img/car/{{ $carView.photo }}" style="height:15rem" />
            </div>
        </div>
        <div class="col-sm-6 col-md-6 mb-4">
            <h3 class="text-center">Foto nova</h3>
            <div class="photo preview ">
                <img src="/assets/img/icon.placeholder.svg" id="carphoto" style="height:15rem" />
            </div>
        </div>
    </div>
    <input type="hidden" value="{{ $carView.id }}" id="edit_id" name="edit_id" fixed="fixed">
    <div class="row  m-3"> 
        <div class="col-sm-6 col-md-4">
            <input type="text" value="{{ $carView.id }}" label="ID"  disabled="disabled" fixed="fixed">
        </div>
        <div class="col-sm-6 col-md-4">
            <input type="button" dialog="#camera" style="margin-top:2em" class="btn btn-primary w-100" value="Tirar foto" onclick="Cam.requerCam().inputVal('edit_carphoto').previewImg('carphoto')" />
            <input type="hidden" id="edit_carphoto" name="edit_carphoto">
        </div>
        <div class="col-sm-6 col-md-4">
            <input type="text" value="{{ $carView.board }}" label="Placa" id="edit_board" name="edit_board">
        </div>
        <div class="col-sm-6 col-md-4">
            <input type="text" value="{{ $carView.brand }}" label="Marca" id="edit_brand" name="edit_brand">
        </div>
        <div class="col-sm-6 col-md-4">
            <input type="text" value="{{ $carView.model }}" label="Modelo" id="edit_model" name="edit_model">
        </div>
            <div class="col-sm-6 col-md-4">
        <input type="text" value="{{ $carView.color }}" label="Cor" id="edit_color" name="edit_color">
        </div>
        <div class="col-sm-6 col-md-4">
            <input type="text" value="{{ $carView.axes }}" label="Nº de eixos" id="edit_axes" name="edit_axes">
        </div>
        <div class="col-sm-6 col-md-4">
            <input type="text" value="{{ $cpf }}" label="CPF Motorista"  data-mask="###.###.###-##" id="edit_cpf" name="edit_cpf">
        </div>
        <div class="col-12 row m-0 mt-4 p-0">
            <div class="col-sm-6 col-md-4 col-lg-2 ml-auto">
                <div class="buttons">
                    <button class="submit btn btn-lg btn-primary btn-block">Editar</button>
                </div>
            </div>
        </div>
    </div>  
    <input type="hidden" name="REQUEST_METHOD" value="AJAX" fixed="fixed">
    <input type="hidden" name="_PROVIDER" value="car" fixed="fixed">
    <input type="hidden" name="_ROLE" value="edition" fixed="fixed">
</form>
<?= $this->import('global/cam') ?>