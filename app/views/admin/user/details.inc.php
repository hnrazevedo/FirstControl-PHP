<?= $this->include('../admin/user/list') ?>

<dialog id="edit_user_form" open="open">
    <div>    
        <div class="heading">
            <span>Detalhes de registro</span>
        </div>
        <div class="content">
            <form provider="user" role="user_register" access="/admin/controller/user">        
                <ul>
                    <li>
                        <input type="text" id="edit_name" name="edit_name" label="Nome Completo" maxlength="50">
                    </li>
                    <li>
                        <input type="text" id="edit_username" name="edit_username" label="Usuário" maxlength="20">
                    </li>
                    <li>
                        <input type="text" id="edit_email" name="edit_email" label="Email" maxlength="100">
                    </li>
                    <li>
                        <input type="text" id="edit_birth" name="edit_birth" label="Data de nascimento" data-mask="##/##/####" >
                    </li>
                    <li>
                        <input type="password" id="edit_password" name="edit_password" label="Senha" maxlength="20" >
                    </li>
                    <li>
                        <input type="password" id="edit_password2" name="edit_password2" label="Confirmar senha" maxlength="20" >
                    </li>
                    <li>
                        <div class="buttons">
                            <button class="submit">Registrar</button>
                        </div>
                    </li>
                </ul>   
            </form>
        </div>
    </div>
</dialog>