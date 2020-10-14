<form access="/controller/user" class="ajax" id="newRegisterUser">
    <div class="col-12 row m-0">
        <div class="col-12 mb-4">
            <div class="photo preview text-center">
                <img src="/assets/img/icon.placeholder.svg" id="userphoto"/>
            </div>
        </div>
    </div>
    <div class="col-12 row m-0">
        <div class="col-sm-6 col-md-4 col-lg-2">
            <input type="button" dialog="#camera" style="margin-top:2em" class="btn btn-primary w-100" value="Tirar foto" onclick="Cam.requerCam().inputVal('new_userphoto').previewImg('userphoto')" />
            <input type="hidden" id="new_userphoto" name="new_userphoto">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-2">
            <input type="text" id="new_name" name="new_name" label="Nome Completo" maxlength="50">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-2">
            <input type="text" id="new_username" name="new_username" label="Usuário" maxlength="20">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-2">
            <input type="text" id="new_email" name="new_email" label="Email" maxlength="100">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-2">
            <input type="text" id="new_birth" name="new_birth" label="Data de nascimento" data-mask="##/##/####" >
        </div>
        <div class="col-sm-6 col-md-4 col-lg-2">
            <input type="password" id="new_password" name="new_password" label="Senha" maxlength="20" >
        </div>
        <div class="col-sm-6 col-md-4 col-lg-2">
            <input type="password" id="new_password2" name="new_password2" label="Confirmar senha" maxlength="20" >
        </div>
        <div class="col-12 row m-0 mt-4 p-0">
            <div class="col-sm-6 col-md-4 col-lg-2 ml-auto">
                <div class="buttons">
                   <button class="submit btn btn-lg btn-primary btn-block">Registrar</button>
                </div>
            </div>
        </div>
    </div>  
    <input type="hidden" name="REQUEST_METHOD" value="AJAX" fixed="fixed">
    <input type="hidden" name="PROVIDER" value="user" fixed="fixed">
    <input type="hidden" name="ROLE" value="register" fixed="fixed">
</form>
<?= $this->import('global/cam') ?>