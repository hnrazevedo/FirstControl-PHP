<dialog id="register_user_form">
    <div>    
        <div class="heading">
            <span>Cadastro de novo usuário</span>
        </div>
        <div class="content">
            <form provider="user" role="user_register" access="/admin/controller/user">        
                <ul>
                    <li>
                        <input type="text" id="new_name" name="new_name" label="Nome Completo" maxlength="50">
                    </li>
                    <li>
                        <input type="text" id="new_username" name="new_username" label="Usuário" maxlength="20">
                    </li>
                    <li>
                        <input type="text" id="new_email" name="new_email" label="Email" maxlength="100">
                    </li>
                    <li>
                        <input type="text" id="new_birth" name="new_birth" label="Data de nascimento" data-mask="##/##/####" >
                    </li>
                    <li>
                        <input type="password" id="new_password" name="new_password" label="Senha" maxlength="20" >
                    </li>
                    <li>
                        <input type="password" id="new_password2" name="new_password2" label="Confirmar senha" maxlength="20" >
                    </li>
                    <li>
                        <div class="buttons">
                            <button class="submit btn btn-primary">Registrar</button>
                        </div>
                    </li>
                </ul>   
            </form>
        </div>
    </div>
</dialog>