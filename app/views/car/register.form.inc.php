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
                            <img src="/assets/img/icon.placeholder.svg" id="carphoto"/>
                        </div>
                    </div>
                </div>
                <div class="row" style="max-width:700px">
                    <div class="col-sm-6  col-md-4 align-bottom d-flex align-items-end">
                        <input type="button" dialog="#camera" onclick="CamCar()" class="btn btn-primary w-100" value="Tirar foto" />
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

<script>
    function CamCar(){
        Cam.requerCam().inputVal('new_carphoto').previewImg('carphoto');
    }
</script>