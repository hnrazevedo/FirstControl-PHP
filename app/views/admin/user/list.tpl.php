<script>

    function workDataTable(role){
        document.querySelector('form[role="status_user"] [name="role"]').value = role;
    }

</script>
<div class="table">
    <form provider="admin" role="status_user" access="/admin/controller/user">
        <input type="hidden" id="role" name="role" value="block">

        <div class="buttons">
            <button dialog="#register_user_form">
                Incluir
            </button>
            <button class="submit" onclick="workDataTable('block')">
                Bloquear
            </button>
            <button class="submit" onclick="workDataTable('live')">
                Liberar
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
    import DataTables from "/assets/js/DataTables.js";
    
    DataTables.importFromURL('table_list_user','/admin/result/list/users');

    
</script>