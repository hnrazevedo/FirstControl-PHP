<html>
    <head>
        <title>{{ $system.appname }} - {{ $title }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="{{ $system.uri }}/assets/addons/Simple-DataTables/style.css" rel="stylesheet" type="text/css">

        <script src="{{ $system.uri }}/assets/js/main.js" type="module"></script>

        <link href="{{ $system.uri }}/assets/css/main.css" rel="stylesheet" type="text/css">
        <link href="{{ $system.uri }}/assets/css/dialog.css" rel="stylesheet" type="text/css">
        <link href="{{ $system.uri }}/assets/css/forms.css" rel="stylesheet" type="text/css">
        <link href="{{ $system.uri }}/assets/css/datatables.css" rel="stylesheet" type="text/css">
        <link href="{{ $system.uri }}/assets/css/visitant.css" rel="stylesheet" type="text/css">

        <script src="{{ $system.uri }}/assets/addons/bootstrap/popper.min.js"></script>

        <style>
            main{
                max-width:1500px
            }
            form{
                width:100%
            }
            main .row{
                margin-left:0;
                margin-right: 0;;
            }
        </style>
    </head>
    <body class="center">
        <main>            
            <form>  
                <input type="hidden" value="{{ $visit.id }}" id="edit_id" name="edit_id">
                <div class="row" style="width:inherit">
                    <div class="col-12">
                        <h4 class="text-center">Visita ID {{ $visit.id }}</h4>
                    </div>

                    <br />

                    <div class="col-12">
                        <div class="row">
                            <div class="col-sm-4 col-md-3 preview">
                                <div class="photo text-center center" >
                                    <a href="{{ $system.uri }}/assets/img/visitant/{{ $visitant.photo }}">
                                        <img  src="{{ $system.uri }}/assets/img/visitant/{{ $visitant.photo }}">
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-8 col-md-9 row " >
                                <div class="col-12">
                                    <h6>Visitante</h6>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <input type="text" label="CPF" value="{{ $visitant.cpf }}" disabled="disabled">
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <input type="text" label="RG" value="{{ $visitant.rg }}" disabled="disabled">
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <input type="text" label="Empresa" value="{{ $visitant.company }}" disabled="disabled">
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <input type="text" label="Nome completo" value="{{ $visitant.name }}" disabled="disabled">
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <input type="text" label="Data de nascimento" value="{{ $visitant.birth }}" disabled="disabled">
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <input type="text" label="Telefone" value="{{ $visitant.phone }}" disabled="disabled">
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <input type="text" label="Email" value="{{ $visitant.email }}" disabled="disabled">
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 

                <br/>

                <div class="row" style="width:inherit">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-sm-4 col-md-3 preview">
                                <div class="photo text-center center" >
                                    <a href="{{ $system.uri }}/assets/img/car/{{ $car.photo }}">
                                        <img  src="{{ $system.uri }}/assets/img/car/{{ $car.photo }}">
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-8 col-md-9 row " >
                                <div class="col-12">
                                    <h6>Veiculo</h6>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <input type="text" label="Placa" value="{{ $car.board }}" disabled="disabled">
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <input type="text" label="Marca" value="{{ $car.brand }}" disabled="disabled">
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <input type="text" label="Modelo" value="{{ $car.model }}" disabled="disabled">
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <input type="text" label="Cor" value="{{ $car.color }}" disabled="disabled">
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <input type="text" label="Nº eixos" value="{{ $car.axes }}" disabled="disabled">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <br/>

                <div class="row" style="width:inherit">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-sm-0 col-md-3"></div>
                            
                            <div class="col-sm-12 col-md-9 row " >
                                <div class="col-12">
                                    <h6>Detalhes</h6>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <input type="text" label="Razão/Motivo" value="{{ $visit.reason }}" disabled="disabled">
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <input type="text" label="Responsável" value="{{ $visit.responsible }}" disabled="disabled">
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <input type="text" label="Status" value="{{ $status }}" disabled="disabled">
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <input type="text" label="Data" value="{{ $date.day }}" disabled="disabled">
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <input type="text" label="Hora inicial" value="{{ $date.started }}" disabled="disabled">
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <input type="text" label="Hora final" value="{{ $date.finished }}" disabled="disabled">
                                </div>
                                
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <input type="text" label="Peso entrada">
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <input type="text" label="Peso saida">
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <input type="text" label="Nota fiscal">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <br/>

                <div class="row" style="width:inherit">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-sm-0 col-md-3"></div>
                            
                            <div class="col-sm-12 col-md-9 row " >
                                <div class="col-12">
                                    <h6>Usuário</h6>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <input type="text" label="Nome" value="{{ $user.name }}" disabled="disabled">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <br/>
                <br/>

            </form>
        </main>
        
        <?= $this->include('../global/dialog_loading') ?>
        <?= $this->include('../global/dialog_message') ?>

        <link rel="stylesheet" href="{{ $system.uri }}/assets/addons/bootstrap/bootstrap.min.css">
        <script src="{{ $system.uri }}/assets/addons/bootstrap/bootstrap.min.js"></script>
    </body>
</html>