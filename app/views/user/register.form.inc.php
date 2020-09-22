<dialog id="register_user_form">
    <div>    
        <div class="heading">
            <span>Cadastro de novo usuário</span>
        </div>
        <div class="content">
            <form provider="user" role="user_register" access="/admin/controller/user">
                <div class="row">
                    <div class="col-sm-6">
                        <input type="text" id="new_name" name="new_name" label="Nome Completo" maxlength="50">
                    </div>
                    <div class="col-sm-6">
                        <input type="text" id="new_username" name="new_username" label="Usuário" maxlength="20">
                    </div>
                    <div class="col-sm-6">
                        <input type="text" id="new_email" name="new_email" label="Email" maxlength="100">
                    </div>
                    <div class="col-sm-6">
                        <input type="text" id="new_birth" name="new_birth" label="Data de nascimento" data-mask="##/##/####" >
                    </div>
                    <div class="col-sm-6">
                        <input type="password" id="new_password" name="new_password" label="Senha" maxlength="20" >
                    </div>
                    <div class="col-sm-6">
                        <input type="password" id="new_password2" name="new_password2" label="Confirmar senha" maxlength="20" >
                    </div>
                    <div class="col-12 text-right">
                        <div class="buttons">
                            <button class="submit btn btn-primary">Registrar</button>
                        </div>
                    </div>
                </div>  
            </form>
        </div>
    </div>
</dialog>