
<form class="pb-4 mt-4 m-auto ajax" access="/controller/visit" id="visitFinish">  
    <input type="hidden" value="{{ $visitView.id }}" id="upt_id" name="upt_id">
    <div class="row" style="width:inherit">
        <div class="col-12">
            <h4 class="text-center">Visita ID {{ $visitView.id }}</h4>
        </div>

        <div class="row mt-4" style="width:inherit">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-0 col-md-3"></div>
                    <div class="col-sm-12 col-md-9 row">
                        <div class="col-sm-12 col-md-6 col-lg-3 ml-auto">
                            <div class="buttons">
                                <button class="submit btn btn-lg btn-primary btn-block">Finalizar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4" style="width:inherit">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-0 col-md-3"></div>
                    <div class="col-sm-12 col-md-9 row ">
                        <div class="col-12">
                            <h6>Pesagem</h6>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-3">
                            <input type="text" label="Peso inicial" value="{{ $balanceView.input }}" disabled="disabled" id="weight">
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-3">
                            <input type="text" label="Peso saída" value="{{ $balanceView.ending }}" class="disabled" name="upt_weight" id="upt_weight">
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-3">
                            <input type="text" label="Peso transportado" value="{{ $balanceView.difference }}" disabled="disabled" id="difference">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 mt-4">
            <div class="row">
                <div class="col-sm-4 col-md-3 preview">
                    <div class="photo text-center center" >
                        <a href="{{ $system.uri }}/assets/img/visitant/{{ $visitant.photo }}">
                            <img  src="{{ $system.uri }}/assets/img/visitant/{{ $visitant.photo }}">
                        </a>
                    </div>
                </div>
                <div class="col-sm-8 col-md-9 h-100 row" >
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
                        <input type="text" label="Transportadora" value="{{ $visitant.transport }}" disabled="disabled">
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
    
    <div class="row mt-4" style="width:inherit">
        <div class="col-12">
            <div class="row">
                <div class="col-sm-4 col-md-3 preview">
                    <div class="photo text-center center" >
                        <a href="{{ $system.uri }}/assets/img/car/{{ $car.photo }}">
                            <img  src="{{ $system.uri }}/assets/img/car/{{ $car.photo }}">
                        </a>
                    </div>
                </div>
                <div class="col-sm-8 col-md-9 h-100 row " >
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

    <div class="row mt-4" style="width:inherit">
        <div class="col-12">
            <div class="row">
                <div class="col-sm-0 col-md-3"></div>
                <div class="col-sm-12 col-md-9 row ">
                    <div class="col-12">
                        <h6>Detalhes</h6>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-3">
                        <input type="text" label="Razão/Motivo" value="{{ $visitView.reason }}" disabled="disabled">
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-3">
                        <input type="text" label="Responsável" value="{{ $visitView.responsible }}" disabled="disabled">
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
                        <textarea label="Observações" value="{{ $visitView.note }}" disabled="disabled">{{ $visitView.note }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4" style="width:inherit">
        <div class="col-12">
            <div class="row">
                <div class="col-sm-0 col-md-3"></div>
                <div class="col-sm-12 col-md-9 row">
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
    <input type="hidden" name="REQUEST_METHOD" value="AJAX" fixed="fixed">
    <input type="hidden" name="PROVIDER" value="visit" fixed="fixed">
    <input type="hidden" name="ROLE" value="finish" fixed="fixed">
</form>

<script>
    window.addEventListener('load',function(){
        document.getElementById('upt_weight').addEventListener('input',function(){
            let difference = parseFloat(document.getElementById('weight').value) - parseFloat(this.value);
            document.getElementById('difference').value = difference;
        });


        var writeSerial=function(str) {
            chrome.serial.send(connectionId, convertStringToArrayBuffer(str), onSend);
        };
        // Convert string to ArrayBuffer
        var convertStringToArrayBuffer=function(str) {
            var buf=new ArrayBuffer(str.length);
            var bufView=new Uint8Array(buf);
            for (var i=0; i<str.length; i++) {
                bufView[i]=str.charCodeAt(i);
            }
            return buf;
        };
    });
</script>