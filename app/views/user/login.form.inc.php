<dialog open="open" class="fixed">
    <div>
        <div class="heading">
            <span>Acessar sistema</span>
        </div>
        <div class="content">
            <form provider="user" role="login" access="/controller/user" method="post">
                <ul>
                    <li>
                        <input type="text" name="log_username" id="log_username" placeholder="Usuário" label="Usuário" maxlength="20">
                    </li>
                    <li>
                        <input type="password" name="log_password" id="log_password" placeholder="Senha" label="Senha" maxlength="20">
                    </li>
                    <li>
                        <div class="buttons">
                            <button class="submit btn btn-primary">Acessar</button>
                        </div>
                    </li>
                </ul>
            </form>
        </div>
    </div>
</dialog>