<form access="/controller/user" class="pb-4 mt-4 m-auto ajax" id="editionUser"> 
    <div class="row  m-3">
        <div class="col-sm-6 col-md-6 mb-4">
            <h3 class="text-center">Foto atual</h3>
            <div class="photo preview ">
                <img src="{{ $system.uri }}/assets/img/user/{{ $userView.photo }}" style="height:15rem" />
            </div>
        </div>

        <div class="col-sm-6 col-md-6 mb-4">
            <h3 class="text-center">Foto nova</h3>
            <div class="photo preview ">
                <img src="/assets/img/icon.placeholder.svg" id="userphoto" style="height:15rem" />
            </div>
        </div>
    </div>
    <input type="hidden" value="{{ $userView.id }}" id="edit_id" name="edit_id" fixed="fixed">   
    <div class="row  m-3">
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" value="{{ $userView.id }}" label="ID" disabled="disabled" fixed="fixed">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" value="{{ $userView.lastaccess }}" label="Último acesso" disabled="disabled" fixed="fixed">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" value="{{ $userView.register }}" label="Data de cadastro" disabled="disabled" fixed="fixed">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="button" dialog="#camera" style="margin-top:2em" class="btn btn-primary w-100" value="Tirar foto" onclick="Cam.requerCam().inputVal('edit_userphoto').previewImg('userphoto')" />
            <input type="hidden" id="edit_userphoto" name="edit_userphoto">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" value="{{ $userView.name }}" label="Nome Completo" name="edit_name" id="edit_name" maxlength="50">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" value="{{ $userView.username }}" label="Usuário" name="edit_username" id="edit_username" maxlength="20">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" value="{{ $userView.email }}" label="Email" name="edit_email" id="edit_email" maxlength="100">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" value="{{ $userView.birth }}" label="Data de nascimento"  name="edit_birth" id="edit_birth" data-mask="##/##/####">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <select name="edit_status" id="edit_status" label="Acesso" value="{{ $userView.status }}">
                <option value="1">Liberado</option>
                <option value="0">Bloqueado</option>
            </select>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="password" id="edit_password" name="edit_password" label="Senha" maxlength="20" >
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="password" id="edit_password2" name="edit_password2" label="Confirmar senha" maxlength="20" >
        </div>
        <div class="col-12 row m-0 mt-4 p-0">
            <div class="col-sm-6 col-md-4 col-lg-3 ml-auto">
                <div class="buttons">
                   <button class="submit btn btn-lg btn-primary btn-block">Editar</button>
                </div>
            </div>
        </div>
    </div>    
    <input type="hidden" name="REQUEST_METHOD" value="AJAX">
    <input type="hidden" name="PROVIDER" value="user">
    <input type="hidden" name="ROLE" value="edition">
</form>
<?= $this->import('global/cam') ?>