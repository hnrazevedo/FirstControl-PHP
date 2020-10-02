<html>
    <head>
        <title>{{ $system.appname }} - {{ $title }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <?= $this->import('../global/styles') ?>
    </head>
    <body class="text-center">
        <main>
            <form provider="admin" role="edit_user" access="/admin/controller/admin" style="max-width:1000px" class="pb-4 mt-4 m-auto">     
                <h4>Detalhes de registro</h4>
                <input type="hidden" value="{{ $userView.id }}" id="edit_id" name="edit_id">   
                <div class="row  m-3">
                    <div class="col-sm-6 col-md-4">
                        <input type="text" value="{{ $userView.id }}" label="ID" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <input type="text" value="{{ $userView.lastaccess }}" label="Último acesso" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <input type="text" value="{{ $userView.name }}" label="Nome Completo" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <input type="text" value="{{ $userView.username }}" label="Usuário" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <input type="text" value="{{ $userView.email }}" label="Email" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <input type="text" value="{{ $userView.birth }}" label="Data de nascimento" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <input type="password" id="edit_password" name="edit_password" label="Senha" maxlength="20" >
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <input type="password" id="edit_password2" name="edit_password2" label="Confirmar senha" maxlength="20" >
                    </div>
                    <div class="col-12">
                        <div class="buttons  text-right mt-3">
                            <button class="submit btn btn-primary">Atualizar</button>
                        </div>
                    </div>
                </div>    
            </form>
        </main>

        <?= $this->import('../global/dialog_loading') ?>
        <?= $this->import('../global/dialog_message') ?>

        <?= $this->import('../global/scripts') ?>
    </body>
</html>