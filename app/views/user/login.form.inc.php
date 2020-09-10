<dialog class="fixed open">
    <div>
        <div class="heading">
            <span>Acessar sistema</span>
        </div>
        <div class="content">
            <form provider="user" role="login" access="/controller/user" method="post">
                <div class="row">
                    <div class="col-sm">
                        <input type="text" name="log_username" id="log_username" placeholder="Usuário" label="Usuário" maxlength="20">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                    <input type="password" name="log_password" id="log_password" placeholder="Senha" label="Senha" maxlength="20">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <div class="buttons">
                            <button class="submit btn btn-primary">Acessar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</dialog>