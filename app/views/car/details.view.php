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
                <h4>Detalhes de {{ $car.board }}</h4>
                <input type="hidden" value="{{ $car.id }}" id="edit_id" name="edit_id">
                <div class="row container">
                    <div class="col-sm-6 col-md-4">
                        <input type="text" value="{{ $car.id }}" label="ID" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <input type="text" value="{{ $car.board }}" label="Placa" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <input type="text" value="{{ $car.brand }}" label="Marca" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <input type="text" value="{{ $car.model }}" label="Modelo" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <input type="text" value="{{ $car.color }}" label="Cor" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <input type="text" value="{{ $car.axes }}" label="Nº de eixos" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <input type="text" value="{{ $car.driver }}" label="Motorista" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <input type="text" value="{{ $lastvisit.started }}" label="Última visita (Entrada)" disabled="disabled">
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <input type="text" value="{{ $lastvisit.finished }}" label="Última visita (Saida)" disabled="disabled">
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