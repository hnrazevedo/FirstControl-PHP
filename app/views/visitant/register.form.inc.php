
<form access="/controller/visitant" id="visitantRegister" class="ajax">
    <div class="col-12 row m-0">
        <div class="col-12">
            <div class="photo preview text-center">
                <img src="/assets/img/icon.placeholder.svg" id="visitantphoto"/>
            </div>
        </div>
    </div>
    <div class="col-12 row m-0" >
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="button" dialog="#camera" class="btn btn-primary w-100" style="margin-top:2em" value="Tirar foto" onclick="Cam.requerCam().inputVal('new_photo').previewImg('visitantphoto')" />
            <input type="hidden" id="new_photo" name="new_photo">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" id="new_name" name="new_name" label="Nome Completo" maxlength="50">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" id="new_email" name="new_email" label="Email" maxlength="100">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" id="new_cpf" name="new_cpf" label="CPF" data-mask="###.###.###-##">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" id="new_rg" name="new_rg" label="RG" data-mask="##.###.###-#">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" id="new_birth" name="new_birth" label="Data de nascimento" data-mask="##/##/####" >
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" id="new_phone" name="new_phone" label="Celular" data-mask="(##) #####-####" >
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" id="new_company" name="new_company" label="Empresa" maxlength="50" >
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
    <input type="hidden" name="PROVIDER" value="visitant" fixed="fixed">
    <input type="hidden" name="ROLE" value="register" fixed="fixed">
</form>

<?= $this->import('global/cam') ?>