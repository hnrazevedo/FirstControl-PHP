<br />
<div class="row d-flex align-items-start" id="authorizations">
    <div class="col-12 mb-2">
        <h5>Visualização de páginas</h5>
    </div>

    <hr class="mb-4 mt-2" />

    <div class="col-12 col-lg-2 col-md-3 col-sm-4 row m-0 p-0">
        <div class="col-12 mb-2">
            <h5>Cadastro</h5>
        </div>
        <div class="btn-group btn-group-vertical mb-4" role="group" aria-label="Basic checkbox toggle button group">
            <input type="checkbox" class="btn-check" id="userViewRegister" <?= (isset($permissions['userViewRegister'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="userViewRegister">Usuário</label>

            <input type="checkbox" class="btn-check" id="carViewRegister" <?= (isset($permissions['carViewRegister'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="carViewRegister">Veículo</label>

            <input type="checkbox" class="btn-check" id="visitantViewRegister" <?= (isset($permissions['visitantViewRegister'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="visitantViewRegister">Visitante</label>

            <input type="checkbox" class="btn-check" id="visitViewRegister" <?= (isset($permissions['visitViewRegister'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="visitViewRegister">Visita</label>
        </div>
    </div>

    <div class="col-12 col-lg-2 col-md-3 col-sm-4 row m-0 p-0">
        <div class="col-12 mb-2">
            <h5>Edição</h5>
        </div>
        <div class="btn-group btn-group-vertical mb-4" role="group" aria-label="Basic checkbox toggle button group">
            <input type="checkbox" class="btn-check" id="userViewEdition" <?= (isset($permissions['userViewEdition'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="userViewEdition">Usuário</label>

            <input type="checkbox" class="btn-check" id="carViewEdition" <?= (isset($permissions['carViewEdition'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="carViewEdition">Veículo</label>

            <input type="checkbox" class="btn-check" id="visitantViewEdition" <?= (isset($permissions['visitantViewEdition'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="visitantViewEdition">Visitante</label>

            <input type="checkbox" class="btn-check" id="visitViewEdition" <?= (isset($permissions['visitViewEdition'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="visitViewEdition">Visita</label>

            <input type="checkbox" class="btn-check" id="visitViewFinish" <?= (isset($permissions['visitViewFinish'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="visitViewFinish">Finalização de visita</label>
        </div>
    </div>

    <div class="col-12 col-lg-2 col-md-3 col-sm-4 row m-0 p-0">
        <div class="col-12 mb-2">
            <h5>Menu</h5>
        </div>
        <div class="btn-group btn-group-vertical mb-4" role="group" aria-label="Basic checkbox toggle button group">
            <input type="checkbox" class="btn-check" id="userViewMenu" <?= (isset($permissions['userViewMenu'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="userViewMenu">Usuário</label>

            <input type="checkbox" class="btn-check" id="carViewMenu" <?= (isset($permissions['carViewMenu'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="carViewMenu">Veículo</label>

            <input type="checkbox" class="btn-check" id="visitantViewMenu" <?= (isset($permissions['visitantViewMenu'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="visitantViewMenu">Visitante</label>

            <input type="checkbox" class="btn-check" id="visitViewMenu" <?= (isset($permissions['visitViewMenu'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="visitViewMenu">Visita</label>
        </div>
    </div>

    <div class="col-12 col-lg-2 col-md-3 col-sm-4 row m-0 p-0">
        <div class="col-12 mb-2">
            <h5>Listagem</h5>
        </div>
        <div class="btn-group btn-group-vertical mb-4" role="group" aria-label="Basic checkbox toggle button group">
            <input type="checkbox" class="btn-check" id="userViewList" <?= (isset($permissions['userViewList'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="userViewList">Usuário</label>

            <input type="checkbox" class="btn-check" id="carViewList" <?= (isset($permissions['carViewList'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="carViewList">Veículo</label>

            <input type="checkbox" class="btn-check" id="visitantViewList" <?= (isset($permissions['visitantViewList'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="visitantViewList">Visitante</label>

            <input type="checkbox" class="btn-check" id="visitViewList" <?= (isset($permissions['visitViewList'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="visitViewList">Visita</label>
        </div>
    </div>

    <div class="col-12 col-lg-2 col-md-3 col-sm-4 row m-0 p-0">
        <div class="col-12 mb-2">
            <h5>Detalhes</h5>
        </div>
        <div class="btn-group btn-group-vertical mb-4" role="group" aria-label="Basic checkbox toggle button group">
            <input type="checkbox" class="btn-check" id="userViewDetails" <?= (isset($permissions['userViewDetails'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="userViewDetails">Usuário</label>

            <input type="checkbox" class="btn-check" id="carViewDetails" <?= (isset($permissions['carViewDetails'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="carViewDetails">Veículo</label>

            <input type="checkbox" class="btn-check" id="visitantViewDetails" <?= (isset($permissions['visitantViewDetails'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="visitantViewDetails">Visitante</label>

            <input type="checkbox" class="btn-check" id="visitViewDetails" <?= (isset($permissions['visitViewDetails'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="visitViewDetails">Visita</label>
        </div>
    </div>

    <div class="col-12 col-lg-2 col-md-3 col-sm-4 row m-0 p-0">
        <div class="col-12 mb-2">
            <h5>Administração</h5>
        </div>
        <div class="btn-group btn-group-vertical mb-4" role="group" aria-label="Basic checkbox toggle button group">
            <input type="checkbox" class="btn-check" id="configViewDetails" <?= (isset($permissions['configViewDetails'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="configViewDetails">Configurações</label>

            <input type="checkbox" class="btn-check" id="userViewAuthorizations" <?= (isset($permissions['userViewAuthorizations'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="userViewAuthorizations">Permissões</label>
        </div>
    </div>

    <div class="col-12 mb-2">
        <h5>Formulário</h5>
    </div>

    <hr class="mb-4 mt-2" />

    <div class="col-12 col-lg-2 col-md-3 col-sm-4 row m-0 p-0">
        <div class="col-12 mb-2">
            <h5>Cadastro</h5>
        </div>
        <div class="btn-group btn-group-vertical mb-4" role="group" aria-label="Basic checkbox toggle button group">
            <input type="checkbox" class="btn-check" id="user|register" <?= (isset($permissions['user|register'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="user|register">Usuário</label>

            <input type="checkbox" class="btn-check" id="car|register" <?= (isset($permissions['car|register'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="car|register">Veículo</label>

            <input type="checkbox" class="btn-check" id="visitant|register" <?= (isset($permissions['visitant|register'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="visitant|register">Visitante</label>

            <input type="checkbox" class="btn-check" id="visit|register" <?= (isset($permissions['visit|register'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="visit|register">Visita</label>
        </div>
    </div>

    <div class="col-12 col-lg-2 col-md-3 col-sm-4 row m-0 p-0">
        <div class="col-12 mb-2">
            <h5>Edição</h5>
        </div>
        <div class="btn-group btn-group-vertical mb-4" role="group" aria-label="Basic checkbox toggle button group">
            <input type="checkbox" class="btn-check" id="user|edition" <?= (isset($permissions['user|edition'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="user|edition">Usuário</label>

            <input type="checkbox" class="btn-check" id="car|edition" <?= (isset($permissions['car|edition'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="car|edition">Veículo</label>

            <input type="checkbox" class="btn-check" id="visitant|edition" <?= (isset($permissions['visitant|edition'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="visitant|edition">Visitante</label>

            <input type="checkbox" class="btn-check" id="visit|edition" <?= (isset($permissions['visit|edition'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="visit|edition">Visita</label>

            <input type="checkbox" class="btn-check" id="visit|finish" <?= (isset($permissions['visit|finish'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="visit|finish">Finalização de visita</label>
        </div>
    </div>

    <div class="col-12 col-lg-2 col-md-3 col-sm-4 row m-0 p-0">
        <div class="col-12 mb-2">
            <h5>Administração</h5>
        </div>
        <div class="btn-group btn-group-vertical mb-4" role="group" aria-label="Basic checkbox toggle button group">
            <input type="checkbox" class="btn-check" id="configUpdate" <?= (isset($permissions['configUpdate'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="configUpdate">Configurações</label>

            <input type="checkbox" class="btn-check" id="userAuthorizationUpdate" <?= (isset($permissions['userAuthorizationUpdate'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="userAuthorizationUpdate">Permissões</label>
        </div>
    </div>

    <div class="col-12 mb-2">
        <h5>Consultas Ajax</h5>
    </div>

    <hr class="mb-4 mt-2" />

    <div class="col-12 col-lg-2 col-md-3 col-sm-4 row m-0 p-0">
        <div class="col-12 mb-2">
            <h5>Retorno para listagem</h5>
        </div>
        <div class="btn-group btn-group-vertical mb-4" role="group" aria-label="Basic checkbox toggle button group">
            <input type="checkbox" class="btn-check" id="userResultList" <?= (isset($permissions['userResultList'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="userResultList">Usuário</label>

            <input type="checkbox" class="btn-check" id="carResultList" <?= (isset($permissions['carResultList'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="carResultList">Veículo</label>

            <input type="checkbox" class="btn-check" id="visitantResultList" <?= (isset($permissions['visitantResultList'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="visitantResultList">Visitante</label>

            <input type="checkbox" class="btn-check" id="visitResultList" <?= (isset($permissions['visitResultList'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="visitResultList">Visita</label>
        </div>
    </div>

    <hr class="mb-4 mt-2" />

    <div class="col-12 col-lg-2 col-md-3 col-sm-4 row m-0 p-0">
        <div class="col-12 mb-2">
            <h5>Impressão</h5>
        </div>
        <div class="btn-group btn-group-vertical mb-4" role="group" aria-label="Basic checkbox toggle button group">
            <input type="checkbox" class="btn-check" id="visitViewPrint" <?= (isset($permissions['visitViewPrint'])) ? 'checked' : '' ?>>
            <label class="btn btn-outline-primary" for="visitViewPrint">Resumo de visita</label>
        </div>
    </div>

    <hr class="mb-4 mt-2" />
</div>

<script>
    window.addEventListener('load', function(){
        document.querySelectorAll('div#authorizations input[type="checkbox"]').forEach(function(e,i){
            e.addEventListener('click', async function(){
                $status = await Submitter.setUrl('{{ $system.uri }}/usuario/{{ $id }}/permissoes/'+e.getAttribute('id')).execute(true);
                if($status.error !== undefined){
                    e.checked = !e.checked;
                }
            });
        });
    });
</script>