<div class="table">

    <div class="buttons">
        <button dialog="#register_user_form">
            Incluir
        </button>
        <button>
            Bloquear
        </button>
        <button>
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
</div>

<?= $this->include('user/register.form') ?>

<script type="module">
    import DataTables from "/assets/js/DataTables.js";
    DataTables.importFromURL('table_list_user','/admin/result/list/users');
</script>