
<style>
    form#userRecover{margin: 0 auto;}
    @media (min-width: 540px){form#userRecover{width:60%;}}
    @media (min-width: 720px){form#userRecover{width:50%;}}
    @media (min-width: 960px){form#userRecover{width:40%;}}
    @media (min-width: 1140px){form#userRecover{width:30%;}}
    @media (min-width: 1320px){form#userRecover{width:20%;}}
    main{display: flex;
    -ms-flex-align: center;
    -ms-flex-pack: center;
    -webkit-box-align: center;
    align-items: center;
    -webkit-box-pack: center;
    justify-content: center;}
</style>
<form access="/recover" method="post" class="ajax" id="userRecover">
    <div class="row">
        <div class="col-sm">
            <input type="text" name="rec_email" id="rec_email" placeholder="Email" label="Email" maxlength="100">
        </div>
    </div>
    <div class="row">
        <div class="col-sm mt-4">
            <div class="buttons">
                <button class="submit btn btn-lg btn-primary btn-block">Avançar</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm mt-4 text-center">
            <a href="{{ $system.uri }}/">Voltar ao login</a>
        </div>
    </div>
    <input type="hidden" name="REQUEST_METHOD" value="AJAX" fixed="fixed">
    <input type="hidden" name="_PROVIDER" value="user" fixed="fixed">
    <input type="hidden" name="_ROLE" value="recover" fixed="fixed">
</form>
        