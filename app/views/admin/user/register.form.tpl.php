<dialog id="register_user_form">
    <a close="close" ></a>
    <div>    
        <form>
            <h3>Cadastro de novo usuário</h3>
        </form>
        <form provider="user" role="register">        
            <ul>
                <li>
                    <input type="text" id="new_name" name="new_name" label="Nome Completo" maxlength="50">
                </li>
                <li>
                    <input type="text" id="new_username" name="new_username" label="Usuário" maxlength="20">
                </li>
                <li>
                    <input type="text" id="mew_email" name="new_email" label="Email" maxlength="100">
                </li>
                <li>
                    <input type="text" id="new_birth" name="new_birth" label="Data de nascimento" data-mask="##/##/####" maxlength="10">
                </li>
                <li class="li-btn">
                    <button>Registar</button>
                </li>
            </ul>   
        </form>
    </div>
</dialog>
<script>
    PureMask.format("#new_birth", true);
</script>