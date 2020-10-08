<form access="/administracao/controller/user" class="ajax" id="newRegisterUser">
    <div class="col-12 row m-0">
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" id="new_name" name="new_name" label="Nome Completo" maxlength="50">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" id="new_username" name="new_username" label="Usuário" maxlength="20">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" id="new_email" name="new_email" label="Email" maxlength="100">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" id="new_birth" name="new_birth" label="Data de nascimento" data-mask="##/##/####" >
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="password" id="new_password" name="new_password" label="Senha" maxlength="20" >
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="password" id="new_password2" name="new_password2" label="Confirmar senha" maxlength="20" >
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
    <input type="hidden" name="PROVIDER" value="user" fixed="fixed">
    <input type="hidden" name="ROLE" value="register" fixed="fixed">
</form>
        