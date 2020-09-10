<html>
    <head>
        <title>{{ $system.appname }} - {{ $title }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="{{ $system.uri }}/assets/img/favicon.ico" type="image/x-icon">

        <link href="{{ $system.uri }}/assets/addons/Simple-DataTables/style.css" rel="stylesheet" type="text/css">

        <script src="{{ $system.uri }}/assets/js/main.js" type="module"></script>

        <link href="{{ $system.uri }}/assets/css/main.css" rel="stylesheet" type="text/css">
        <link href="{{ $system.uri }}/assets/css/dialog.css" rel="stylesheet" type="text/css">
        <link href="{{ $system.uri }}/assets/css/forms.css" rel="stylesheet" type="text/css">
        <link href="{{ $system.uri }}/assets/css/datatables.css" rel="stylesheet" type="text/css">

        <script src="{{ $system.uri }}/assets/addons/bootstrap/popper.min.js"></script>
    </head>
    <body>
        <main>
            <dialog id="edit_user_form" class="fixed open">
                <div>    
                    <div class="heading">
                        <span>Detalhes de registro</span>
                    </div>
                    <div class="content">
                        <form provider="admin" role="edit_user" access="/admin/controller/admin">     
                            <input type="hidden" value="{{ $user.id }}" id="edit_id" name="edit_id">   
                            <div class="row">
                                <div class="col-sm">
                                    <input type="text" value="{{ $user.id }}" label="ID" disabled="disabled">
                                </div>
                                <div class="col-sm">
                                    <input type="text" value="{{ $user.lastaccess }}" label="Último acesso" disabled="disabled">
                                </div>
                            </div>  
                            <div class="row">
                                <div class="col-sm">
                                    <input type="text" value="{{ $user.name }}" label="Nome Completo" disabled="disabled">
                                </div>
                                <div class="col-sm">
                                    <input type="text" value="{{ $user.username }}" label="Usuário" disabled="disabled">
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-sm">
                                    <input type="text" value="{{ $user.email }}" label="Email" disabled="disabled">
                                </div>
                                <div class="col-sm">
                                    <input type="text" value="{{ $user.birth }}" label="Data de nascimento" disabled="disabled">
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-sm">
                                    <input type="password" id="edit_password" name="edit_password" label="Senha" maxlength="20" >
                                </div>
                                <div class="col-sm">
                                    <input type="password" id="edit_password2" name="edit_password2" label="Confirmar senha" maxlength="20" >
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-sm">
                                    <div class="buttons">
                                        <button class="submit btn btn-primary">Atualizar</button>
                                    </div>
                                </div>
                            </div>    
                        </form>
                    </div>
                </div>
            </dialog>
            
        </main>
        <?= $this->include('../../global/dialog_loading') ?>
        <?= $this->include('../../global/dialog_message') ?>

        <link rel="stylesheet" href="{{ $system.uri }}/assets/addons/bootstrap/bootstrap.min.css">
        <script src="{{ $system.uri }}/assets/addons/bootstrap/bootstrap.min.js"></script>
    </body>
</html>