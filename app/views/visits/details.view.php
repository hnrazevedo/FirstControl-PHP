<html>
    <head>
        <title>{{ $system.appname }} - {{ $title }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <?= $this->import('../global/styles') ?>

        <style>
            main .row{
                margin-left:0;
                margin-right: 0;;
            }
        </style>
    </head>
    <body>
        <main>
            <form style="max-width:1500px" class="pb-4 mt-4 m-auto">  
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
        
        <?= $this->import('../global/dialog_loading') ?>
        <?= $this->import('../global/dialog_message') ?>

        <?= $this->import('../global/scripts') ?>
    </body>
</html>