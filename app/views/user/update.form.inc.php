
<form access="/controller/user" class="pb-4 mt-4 m-auto ajax" id="updateUser">   
    <div class="row  m-3">
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" value="{{ $user.id }}" label="ID" disabled="disabled">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" value="{{ $user.lastaccess }}" label="Último acesso" disabled="disabled">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" value="{{ $user.name }}" label="Nome Completo" disabled="disabled">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" value="{{ $user.username }}" label="Usuário" disabled="disabled">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" value="{{ $user.birth }}" label="Data de nascimento" disabled="disabled">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" value="{{ $user.email }}" label="Email" id="edit_email" name="edit_email" maxlength="100">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="password" id="edit_oldpassword" name="edit_oldpassword" label="Senha atual" maxlength="20" >
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="password" id="edit_password" name="edit_password" label="Nova senha" maxlength="20" >
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="password" id="edit_password2" name="edit_password2" label="Confirmar senha" maxlength="20" >
        </div>
        <div class="col-12 row m-0 mt-4 p-0">
            <div class="col-sm-6 col-md-4 col-lg-3 ml-auto">
                <div class="buttons">
                   <button class="submit btn btn-lg btn-primary btn-block">Atualizar</button>
                </div>
            </div>
        </div>
    </div>    

    <input type="hidden" name="REQUEST_METHOD" value="AJAX">
    <input type="hidden" name="PROVIDER" value="user">
    <input type="hidden" name="ROLE" value="update">
</form>
        