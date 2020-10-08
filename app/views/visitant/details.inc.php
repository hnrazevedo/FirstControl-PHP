
<form class="pb-4 mt-4 m-auto">  
    <br/>
    <input type="hidden" value="{{ $visitantView.id }}" id="edit_id" name="edit_id">
    <div class="row m-3">
        <div class="col-12">
            <div class="photo text-center mb-4">
                <a href="{{ $system.uri }}/assets/img/visitant/{{ $visitantView.photo }}">
                    <img src="{{ $system.uri }}/assets/img/visitant/{{ $visitantView.photo }}">
                </a>
            </div>
        </div>
        <div class="col-sm-6 col-md-4-6 col-md-4">
            <input type="text" value="{{ $visitantView.id }}" label="ID" disabled="disabled">
        </div>
        <div class="col-sm-6 col-md-4-6 col-md-4">
            <input type="text" value="{{ $visitantView.lastvisit }}" label="Última visita" disabled="disabled">
        </div>
        <div class="col-sm-6 col-md-4-6 col-md-4">
            <input type="text" value="{{ $visitantView.name }}" label="Nome Completo" disabled="disabled">
        </div>
        <div class="col-sm-6 col-md-4-6 col-md-4">
            <input type="text" value="{{ $visitantView.email }}" label="Email" disabled="disabled">
        </div>
        <div class="col-sm-6 col-md-4-6 col-md-4">
            <input type="text" value="{{ $visitantView.cpf }}" label="CPF" disabled="disabled">
        </div>
        <div class="col-sm-6 col-md-4-6 col-md-4">
            <input type="text" value="{{ $visitantView.rg }}" label="RG" disabled="disabled">
        </div>
        <div class="col-sm-6 col-md-4-6 col-md-4">
            <input type="text" value="{{ $visitantView.birth }}" label="Data de nascimento" disabled="disabled">
        </div>
        <div class="col-sm-6 col-md-4-6 col-md-4">
            <input type="text" value="{{ $visitantView.phone }}" label="Contato" disabled="disabled">
        </div>
        <div class="col-sm-6 col-md-4-6 col-md-4">
            <input type="text" value="{{ $visitantView.company }}" label="Empresa" disabled="disabled">
        </div>
            <div class="col-sm-6 col-md-4-6 col-md-4">
            <div class="buttons"></div>
        </div>
    </div>
</form>