
<form style="max-width:1000px" class="pb-4 mt-4 m-auto"> 
    <input type="hidden" value="{{ $carView.id }}" id="edit_id" name="edit_id">
    <div class="row  m-3">
        <div class="col-12 text-center">
            <div class="photo mb-4">
                <a href="{{ $system.uri }}/assets/img/car/{{ $carView.photo }}">
                    <img src="{{ $system.uri }}/assets/img/car/{{ $carView.photo }}">
                </a>
            </div>
        </div>   
        <div class="col-sm-6 col-md-4">
            <input type="text" value="{{ $carView.id }}" label="ID" disabled="disabled">
        </div>
        <div class="col-sm-6 col-md-4">
            <input type="text" value="{{ $carView.board }}" label="Placa" disabled="disabled">
        </div>
        <div class="col-sm-6 col-md-4">
            <input type="text" value="{{ $carView.brand }}" label="Marca" disabled="disabled">
        </div>
        <div class="col-sm-6 col-md-4">
            <input type="text" value="{{ $carView.model }}" label="Modelo" disabled="disabled">
        </div>
            <div class="col-sm-6 col-md-4">
        <input type="text" value="{{ $carView.color }}" label="Cor" disabled="disabled">
        </div>
        <div class="col-sm-6 col-md-4">
            <input type="text" value="{{ $carView.axes }}" label="Nº de eixos" disabled="disabled">
        </div>
        <div class="col-sm-6 col-md-4">
            <input type="text" value="{{ $carView.driver }}" label="Motorista" disabled="disabled">
        </div>
        <div class="col-sm-6 col-md-4">
            <input type="text" value="{{ $lastvisit.started }}" label="Última visita (Entrada)" disabled="disabled">
        </div>
        <div class="col-sm-6 col-md-4">
            <input type="text" value="{{ $lastvisit.finished }}" label="Última visita (Saida)" disabled="disabled">
        </div>
    </div>  
</form>