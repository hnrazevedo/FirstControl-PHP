<script>

    function workDataTable(role){
        document.querySelector('form[role="status_user"] [name="role"]').value = role;
    }

</script>
<div class="table">
    <form provider="admin" role="status_user" access="/admin/controller/user" confirm="true">
        <input type="hidden" id="role" name="role" value="block">

        <div class="buttons">
            <button dialog="#register_user_form" class="icon">
                Incluir
                <img src="{{ $system.uri }}/assets/img/icon.add.svg">
            </button>
            <button class="submit icon" onclick="workDataTable('block')">
                Bloquear
                <img src="{{ $system.uri }}/assets/img/icon.lock.svg">
            </button>
            <button class="submit icon" onclick="workDataTable('live')">
                Desbloquear
                <img src="{{ $system.uri }}/assets/img/icon.unlock.svg">
            </button>
            <button class="submit icon" onclick="workDataTable('remove')">
                Deletar
                <img src="{{ $system.uri }}/assets/img/icon.delete.svg">
            </button>
        </div>

        <hr>

        <table class="datatable" id="table_list_user" title="Registro de usuários">
            <thead>
                <th>ID</th>
                <th>Nome</th>
                <th>Nome de usuário</th>
                <th>Email</th>
                <th>Nascimento</th>
                <th>Registro</th>
                <th>Ultimo acesso</th>
                <th>Status</th>
                <th>Tipo</th>
            </thead>
            <tbody></tbody>
        </table>
    </form>
</div>


<?= $this->include('user/register.form') ?>

<script type="module">
    setTimeout(function(){
        (async function(){
            await (await import("/assets/js/DataTables.js")).default();
            window.DataTables.importFromURL('table_list_user','/admin/result/list/users');
        })();
    },500);
    

</script>