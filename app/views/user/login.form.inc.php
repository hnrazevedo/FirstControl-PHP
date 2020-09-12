
<form provider="user" role="login" access="/controller/user" method="post" class="form-signin signin">
    <img class="mb-4" src="{{ $system.uri }}/assets/img/logo.png" alt="" width="72" height="72">
    <h4>FirstControl</h4>
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
                <button class="submit btn btn-lg btn-primary btn-block">Acessar</button>
            </div>
        </div>
    </div>
</form>
        