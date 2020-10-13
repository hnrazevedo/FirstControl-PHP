<form class="pb-4 mt-4 m-auto"> 
    <div class="col-12 row m-0">
        <div class="col-12 mb-4">
            <div class="photo preview ">
                <img src="{{ $system.uri }}/assets/img/user/{{ $userView.photo }}" style="height:15rem" />
            </div>
        </div>
    </div>
    <input type="hidden" value="{{ $userView.id }}" id="edit_id" name="edit_id">   
    <div class="row  m-3">
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" value="{{ $userView.id }}" label="ID" disabled="disabled">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" value="{{ $userView.lastaccess }}" label="Último acesso" disabled="disabled">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" value="{{ $userView.name }}" label="Nome Completo" disabled="disabled">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" value="{{ $userView.username }}" label="Usuário" disabled="disabled">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" value="{{ $userView.email }}" label="Email" disabled="disabled">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" value="{{ $userView.birth }}" label="Data de nascimento" disabled="disabled">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" value="{{ $userView.register }}" label="Data de cadastro" disabled="disabled">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <select name="edit_status" id="edit_status" label="Acesso" value="{{ $userView.status }}"  disabled="disabled">
                <option value="1">Liberado</option>
                <option value="0">Bloqueado</option>
            </select>
        </div>
    </div>    
</form>
        