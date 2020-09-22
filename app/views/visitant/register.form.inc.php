<dialog id="register_visitant_form">
    <div>    
        <div class="heading">
            <span>Cadastro de novo visitante</span>
        </div>
        <div class="content">
            <form provider="visitant" role="visitantRegister" access="/controller/visitant">
                <div class="row">
                    <div class="col-12">
                        <div class="photo preview text-center">
                            <img src="/assets/img/icon.placeholder.svg" id="visitantphoto"/>
                        </div>
                    </div>
                </div>
                <div class="row" style="max-width:700px">
                    <div class="col-sm-6  col-md-6 align-bottom d-flex align-items-end">
                        <input type="button" dialog="#camera" onclick="CamVisitant()" class="btn btn-primary w-100" value="Tirar foto" />
                        <input type="hidden" id="new_photo" name="new_photo">
                    </div>
                    <div class="col-sm-6  col-md-6">
                        <input type="text" id="new_name" name="new_name" label="Nome Completo" maxlength="50">
                    </div>
                    <div class="col-sm-6  col-md-6">
                        <input type="text" id="new_email" name="new_email" label="Email" maxlength="100">
                    </div>
                    <div class="col-sm-6  col-md-6">
                        <input type="text" id="new_cpf" name="new_cpf" label="CPF" data-mask="###.###.###-##">
                    </div>
                    <div class="col-sm-6  col-md-6">
                        <input type="text" id="new_rg" name="new_rg" label="RG" data-mask="##.###.###-#">
                    </div>
                    <div class="col-sm-6  col-md-6">
                        <input type="text" id="new_birth" name="new_birth" label="Data de nascimento" data-mask="##/##/####" >
                    </div>
                    <div class="col-sm-6  col-md-6">
                        <input type="text" id="new_phone" name="new_phone" label="Celular" data-mask="(##) #####-####" >
                    </div>
                    <div class="col-sm-6  col-md-6">
                        <input type="text" id="new_company" name="new_company" label="Empresa" maxlength="50" >
                    </div>
                    <div class="col-12 text-right">
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
    function CamVisitant(){
        Cam.requerCam().inputVal('new_photo').previewImg('visitantphoto');
    }
</script>