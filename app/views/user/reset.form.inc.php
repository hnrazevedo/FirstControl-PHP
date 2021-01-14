
<style>
    form#userReset{margin: 0 auto;}
    @media (min-width: 540px){form#userReset{width:60%;}}
    @media (min-width: 720px){form#userReset{width:50%;}}
    @media (min-width: 960px){form#userReset{width:40%;}}
    @media (min-width: 1140px){form#userReset{width:30%;}}
    @media (min-width: 1320px){form#userReset{width:20%;}}
    main{display: flex;
    -ms-flex-align: center;
    -ms-flex-pack: center;
    -webkit-box-align: center;
    align-items: center;
    -webkit-box-pack: center;
    justify-content: center;}
</style>
<form access="/reset" method="post" class="ajax" id="userReset">
    <input type="hidden" name="res_code" id="res_code" value="{{ $code }}" >
    <div class="row">
        <div class="col-sm">
            <input type="password" name="res_password" id="res_password" placeholder="Nova senha" label="Nova senha" maxlength="20">
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <input type="password" name="res_password2" id="res_password2" placeholder="Confirmar nova senha" label="Confirmar nova senha" maxlength="20">
        </div>
    </div>
    <div class="row">
        <div class="col-sm mt-4">
            <div class="buttons">
                <button class="submit btn btn-lg btn-primary btn-block">Redefinir</button>
            </div>
        </div>
    </div>
    <input type="hidden" name="REQUEST_METHOD" value="AJAX" fixed="fixed">
    <input type="hidden" name="_PROVIDER" value="user" fixed="fixed">
    <input type="hidden" name="_ROLE" value="reset" fixed="fixed">
</form>
        