<dialog open="open" class="fixed">
    <div>
        <form provider="user" role="login" access="/controller/user" method="post">
            <h3> Acessar sistema </h3>
            <ul>
                <li>
                    <input type="text" name="log_username" id="log_username" placeholder="Usuário" label="Usuário" maxlength="20">
                </li>
                <li>
                    <input type="password" name="log_password" id="log_password" placeholder="Senha" label="Senha" maxlength="20">
                </li>
                <li>
                    <div class="list_buttons">
                        <button class="submit">Acessar</button>
                    </div>
                </li>
            </ul>
        </form>
    </div>
</dialog>