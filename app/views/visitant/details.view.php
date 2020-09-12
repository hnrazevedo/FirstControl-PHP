<html>
    <head>
        <title>{{ $system.appname }} - {{ $title }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <link href="{{ $system.uri }}/assets/addons/Simple-DataTables/style.css" rel="stylesheet" type="text/css">

        <script src="{{ $system.uri }}/assets/js/main.js" type="module"></script>

        <link href="{{ $system.uri }}/assets/css/main.css" rel="stylesheet" type="text/css">
        <link href="{{ $system.uri }}/assets/css/dialog.css" rel="stylesheet" type="text/css">
        <link href="{{ $system.uri }}/assets/css/forms.css" rel="stylesheet" type="text/css">
        <link href="{{ $system.uri }}/assets/css/datatables.css" rel="stylesheet" type="text/css">
        <link href="{{ $system.uri }}/assets/css/visitant.css" rel="stylesheet" type="text/css">

        <script src="{{ $system.uri }}/assets/addons/bootstrap/popper.min.js"></script>

    </head>
    <body class="text-center center">
        <main style="max-width:1000px">            
            <form>   
                <h4>{{ $visitant.name }}</h4>  
                <br/>
                <input type="hidden" value="{{ $visitant.id }}" id="edit_id" name="edit_id">
                <div class="row container">
                    <div class="col-12">
                        <div class="photo">
                            <a href="{{ $system.uri }}/assets/img/visitant/{{ $visitant.photo }}">
                                <img src="{{ $system.uri }}/assets/img/visitant/{{ $visitant.photo }}">
                            </a>
                        </div>
                    </div>    
                    <div class="col-sm-6 col-md-4-6 col-md-4">
                        <input type="text" value="{{ $visitant.id }}" label="ID" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4-6 col-md-4">
                        <input type="text" value="{{ $visitant.lastvisit }}" label="Última visita" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4-6 col-md-4">
                        <input type="text" value="{{ $visitant.name }}" label="Nome Completo" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4-6 col-md-4">
                        <input type="text" value="{{ $visitant.email }}" label="Email" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4-6 col-md-4">
                        <input type="text" value="{{ $visitant.cpf }}" label="CPF" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4-6 col-md-4">
                        <input type="text" value="{{ $visitant.rg }}" label="RG" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4-6 col-md-4">
                        <input type="text" value="{{ $visitant.birth }}" label="Data de nascimento" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4-6 col-md-4">
                        <input type="text" value="{{ $visitant.phone }}" label="Contato" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4-6 col-md-4">
                        <input type="text" value="{{ $visitant.company }}" label="Empresa" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4-6 col-md-4">
                        <div class="buttons"></div>
                    </div>
                </div>      
            </form>
        </main>
        
        <?= $this->include('../global/dialog_loading') ?>
        <?= $this->include('../global/dialog_message') ?>

        <link rel="stylesheet" href="{{ $system.uri }}/assets/addons/bootstrap/bootstrap.min.css">
        <script src="{{ $system.uri }}/assets/addons/bootstrap/bootstrap.min.js"></script>
    </body>
</html>