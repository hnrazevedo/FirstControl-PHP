<script>

    function workDataTable(role){
        document.querySelector('form[role="status_user"] [name="role"]').value = role;
    }

    function popUp(){
        var $select = document.querySelector('form[provider="admin"][role="status_user"]').querySelector('select#dataselect');
        var $id = null;
        var $sel = 0;
        $select.childNodes.forEach((option, o) => {
            if(option.selected === true){
                $sel++;
                if($sel > 1){
                    window.Dialog.popUp('Selecione apenas um usuário');
                    $id = null;
                    return false;
                }
                $id = option.value;
            }
        });

        if($id != null){
            window.open (
                '/admin/users/'+$id,
                'pagina',
                "menubar=0,resizable=0,width="+screen.width+", height="+screen.height+",scrollbars=no,top=0, left=0");
        }
        
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
            <button class="popUp icon" onclick="popUp()">
                Detalhes
                <img src="{{ $system.uri }}/assets/img/icon.details.svg">
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