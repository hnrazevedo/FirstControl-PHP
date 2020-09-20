<html>
    <head>
        <title>{{ $system.appname }} - {{ $title }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <<?= $this->include('../global/styles') ?>
    </head>
    <body class="text-center center">
        <main style="max-width:1000px">
            <form provider="admin" role="edit_user" access="/admin/controller/admin">     
                <h4>Detalhes de registro</h4>
                <input type="hidden" value="{{ $user.id }}" id="edit_id" name="edit_id">   
                <div class="row container">
                    <div class="col-sm-6 col-md-4">
                        <input type="text" value="{{ $user.id }}" label="ID" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <input type="text" value="{{ $user.lastaccess }}" label="Último acesso" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <input type="text" value="{{ $user.name }}" label="Nome Completo" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <input type="text" value="{{ $user.username }}" label="Usuário" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <input type="text" value="{{ $user.email }}" label="Email" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <input type="text" value="{{ $user.birth }}" label="Data de nascimento" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <input type="password" id="edit_password" name="edit_password" label="Senha" maxlength="20" >
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <input type="password" id="edit_password2" name="edit_password2" label="Confirmar senha" maxlength="20" >
                    </div>
                    <div class="col-12">
                        <div class="buttons">
                            <button class="submit btn btn-primary">Atualizar</button>
                        </div>
                    </div>
                </div>    
            </form>
        </main>

        <?= $this->include('../global/dialog_loading') ?>
        <?= $this->include('../global/dialog_message') ?>

        <?= $this->include('../global/scripts') ?>
    </body>
</html>