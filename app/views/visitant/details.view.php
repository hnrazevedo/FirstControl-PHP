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
        <link href="{{ $system.uri }}/assets/css/visitant.css" rel="stylesheet" type="text/css">

    </head>
    <body>
        <?= $this->include('../global/background') ?>
        <main>
            <dialog id="edit_visitant_form" open="open" class="fixed">
                <div>    
                    <div class="heading">
                        <span>Detalhes de {{ $visitant.name }}</span>
                    </div>
                    <div class="content">
                        <div class="photo">
                            <a href="{{ $system.uri }}/assets/img/visitant/{{ $visitant.photo }}">
                                <img src="{{ $system.uri }}/assets/img/visitant/{{ $visitant.photo }}">
                            </a>
                        </div>
                        <form>     
                            <input type="hidden" value="{{ $visitant.id }}" id="edit_id" name="edit_id">   
                            <ul>
                                <li>
                                    <input type="text" value="{{ $visitant.id }}" label="ID" disabled="disabled">
                                </li>
                                <li>
                                    <input type="text" value="{{ $visitant.lastvisit }}" label="Última visita" disabled="disabled">
                                </li>
                                <li>
                                    <input type="text" value="{{ $visitant.name }}" label="Nome Completo" disabled="disabled">
                                </li>
                                <li>
                                    <input type="text" value="{{ $visitant.cpf }}" label="CPF" disabled="disabled">
                                </li>
                                <li>
                                    <input type="text" value="{{ $visitant.rg }}" label="RG" disabled="disabled">
                                </li>
                                <li>
                                    <input type="text" value="{{ $visitant.email }}" label="Email" disabled="disabled">
                                </li>
                                <li>
                                    <input type="text" value="{{ $visitant.birth }}" label="Data de nascimento" disabled="disabled">
                                </li>
                                <li>
                                    <input type="text" value="{{ $visitant.phone }}" label="Contato" disabled="disabled">
                                </li>
                                <li>
                                    <input type="text" value="{{ $visitant.company }}" label="Empresa" disabled="disabled">
                                </li>
                                <li></li>
                            </ul>   
                        </form>
                    </div>
                </div>
            </dialog>
            
        </main>
        <?= $this->include('../global/dialog_loading') ?>
        <?= $this->include('../global/dialog_message') ?>
    </body>
</html>