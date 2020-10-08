
<form access="/administracao/controller/admin" class="pb-4 mt-4 m-auto ajax" id="adminUpdateUser">   
    <input type="hidden" value="{{ $userView.id }}" id="edit_id" name="edit_id">   
    <div class="row  m-3">
        <div class="col-sm-6 col-md-4">
            <input type="text" value="{{ $userView.id }}" label="ID" disabled="disabled">
        </div>
        <div class="col-sm-6 col-md-4">
            <input type="text" value="{{ $userView.lastaccess }}" label="Último acesso" disabled="disabled">
        </div>
        <div class="col-sm-6 col-md-4">
            <input type="text" value="{{ $userView.name }}" label="Nome Completo" disabled="disabled">
        </div>
        <div class="col-sm-6 col-md-4">
            <input type="text" value="{{ $userView.username }}" label="Usuário" disabled="disabled">
        </div>
        <div class="col-sm-6 col-md-4">
            <input type="text" value="{{ $userView.email }}" label="Email" disabled="disabled">
        </div>
        <div class="col-sm-6 col-md-4">
            <input type="text" value="{{ $userView.birth }}" label="Data de nascimento" disabled="disabled">
        </div>
        <div class="col-sm-6 col-md-4">
            <select name="edit_status" id="edit_status" label="Acesso" value="{{ $userView.status }}">
                <option value="1">Liberado</option>
                <option value="0">Bloqueado</option>
            </select>
        </div>
        <div class="col-sm-6 col-md-4">
            <select name="edit_type" id="edit_type" label="Tipo" value="{{ $userView.type }}">
                <option value="1">Administrador</option>
                <option value="0">Comum</option>
            </select>
        </div>
        <div class="col-sm-6 col-md-4">
            <input type="password" id="edit_password" name="edit_password" label="Senha" maxlength="20" >
        </div>
        <div class="col-sm-6 col-md-4">
            <input type="password" id="edit_password2" name="edit_password2" label="Confirmar senha" maxlength="20" >
        </div>
        <div class="col-12">
            <div class="buttons  text-right mt-3">
                <button class="submit btn btn-primary">Atualizar</button>
            </div>
        </div>
    </div>    

    <input type="hidden" name="REQUEST_METHOD" value="AJAX">
    <input type="hidden" name="PROVIDER" value="admin">
    <input type="hidden" name="ROLE" value="updateUser">
</form>
        