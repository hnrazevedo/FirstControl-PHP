
<style>
    form#userLogin{margin: 0 auto;}
    @media (min-width: 540px){form#userLogin{width:60%;}}
    @media (min-width: 720px){form#userLogin{width:50%;}}
    @media (min-width: 960px){form#userLogin{width:40%;}}
    @media (min-width: 1140px){form#userLogin{width:30%;}}
    @media (min-width: 1320px){form#userLogin{width:20%;}}
    main{display: flex;
    -ms-flex-align: center;
    -ms-flex-pack: center;
    -webkit-box-align: center;
    align-items: center;
    -webkit-box-pack: center;
    justify-content: center;}
</style>
<form access="/login" method="post" class="ajax" id="userLogin">
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
        <div class="col-sm mt-4">
            <div class="buttons">
                <button class="submit btn btn-lg btn-primary btn-block">Acessar</button>
            </div>
        </div>
    </div>
    <input type="hidden" name="REQUEST_METHOD" value="AJAX" fixed="fixed">
    <input type="hidden" name="PROVIDER" value="user" fixed="fixed">
    <input type="hidden" name="ROLE" value="login" fixed="fixed">
</form>
        