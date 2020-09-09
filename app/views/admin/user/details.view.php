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

        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    
    </head>
    <body>
        <?= $this->include('../../global/background') ?>
        <main>
            <dialog id="edit_user_form" open="open" class="fixed">
                <div>    
                    <div class="heading">
                        <span>Detalhes de registro</span>
                    </div>
                    <div class="content">
                        <form provider="admin" role="edit_user" access="/admin/controller/admin">     
                            <input type="hidden" value="{{ $user.id }}" id="edit_id" name="edit_id">   
                            <ul>
                                <li>
                                    <input type="text" value="{{ $user.id }}" label="ID" disabled="disabled">
                                </li>
                                <li>
                                    <input type="text" value="{{ $user.lastaccess }}" label="Último acesso" disabled="disabled">
                                </li>
                                <li>
                                    <input type="text" value="{{ $user.name }}" label="Nome Completo" disabled="disabled">
                                </li>
                                <li>
                                    <input type="text" value="{{ $user.username }}" label="Usuário" disabled="disabled">
                                </li>
                                <li>
                                    <input type="text" value="{{ $user.email }}" label="Email" disabled="disabled">
                                </li>
                                <li>
                                    <input type="text" value="{{ $user.birth }}" label="Data de nascimento" disabled="disabled">
                                </li>
                                <li>
                                    <input type="password" id="edit_password" name="edit_password" label="Senha" maxlength="20" >
                                </li>
                                <li>
                                    <input type="password" id="edit_password2" name="edit_password2" label="Confirmar senha" maxlength="20" >
                                </li>
                                <li>
                                    <div class="buttons">
                                        <button class="submit btn btn-primary">Atualizar</button>
                                    </div>
                                </li>
                            </ul>   
                        </form>
                    </div>
                </div>
            </dialog>
            
        </main>
        <?= $this->include('../../global/dialog_loading') ?>
        <?= $this->include('../../global/dialog_message') ?>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    
    </body>
</html>