
<form  access="/controller/visitant" class="pb-4 mt-4 m-auto ajax" id="editionVisitant">  
    <div class="row  m-3">
        <div class="col-sm-6 col-md-6 mb-4">
            <h3 class="text-center">Foto atual</h3>
            <div class="photo preview ">
                <img src="{{ $system.uri }}/assets/img/visitant/{{ $visitantView.photo }}" style="height:15rem" />
            </div>
        </div>

        <div class="col-sm-6 col-md-6 mb-4">
            <h3 class="text-center">Foto nova</h3>
            <div class="photo preview ">
                <img src="/assets/img/icon.placeholder.svg" id="visitantphoto" style="height:15rem" />
            </div>
        </div>
    </div>
    <br/>
    <input type="hidden" value="{{ $visitantView.id }}" id="edit_id" name="edit_id" fixed="fixed">
    <div class="row m-3">
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" value="{{ $visitantView.id }}" label="ID" disabled="disabled" fixed="fixed">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" value="{{ $visitantView.register }}" label="Data de cadastro" disabled="disabled" fixed="fixed">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" value="{{ $visitantView.lastvisit }}" label="Última visita" disabled="disabled" fixed="fixed">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="button" dialog="#camera" style="margin-top:2em" class="btn btn-primary w-100" value="Tirar foto" onclick="Cam.requerCam().inputVal('edit_photo').previewImg('visitantphoto')" />
            <input type="hidden" id="edit_photo" name="edit_photo">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" value="{{ $visitantView.name }}" id="edit_name" name="edit_name" label="Nome Completo" maxlength="50">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" value="{{ $visitantView.email }}" id="edit_email" name="edit_email" label="Email" maxlength="100">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" value="{{ $visitantView.cpf }}" id="edit_cpf" name="edit_cpf" label="CPF" data-mask="###.###.###-##">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" value="{{ $visitantView.rg }}" id="edit_rg" name="edit_rg" label="RG" data-mask="##.###.###-#">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" value="{{ $visitantView.transport }}" id="edit_transport" name="edit_transport" label="Transportadora" maxlength="50">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" value="{{ $visitantView.phone }}" id="edit_phone" name="edit_phone" label="Contato" data-mask="(##) #####-####">
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <input type="text" value="{{ $visitantView.company }}" id="edit_company" name="edit_company" label="Empresa" maxlength="50">
        </div>
        <div class="col-12 row m-0 mt-4 p-0">
            <div class="col-sm-6 col-md-4 col-lg-3 ml-auto">
                <div class="buttons">
                   <button class="submit btn btn-lg btn-primary btn-block">Editar</button>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="REQUEST_METHOD" value="AJAX">
    <input type="hidden" name="PROVIDER" value="visitant">
    <input type="hidden" name="ROLE" value="edition">
</form>

<?= $this->import('global/cam') ?>