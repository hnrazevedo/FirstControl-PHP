<script>

    function popUp(){
        var $select = document.querySelector('form[provider="visitant"][role="statusVisitant"]').querySelector('select#dataselect');
        var $id = null;
        var $sel = 0;
        $select.childNodes.forEach((option, o) => {
            if(option.selected === true){
                $sel++;
                if($sel > 1){
                    Dialog.popUp('Selecione apenas um visitante.');
                    $id = null;
                    return false;
                }
                $id = option.value;
            }
        });

        if($id != null){
            var popup = window.open (
                '/visitant/details/'+$id,
                'pagina',
                "menubar=0,width="+screen.availWidth+", height="+screen.availHeight+",top=0, left=0");
            
            popup.moveTo(0, 0);
            popup.resizeTo(screen.width, screen.height);
        }else{
            Dialog.popUp('Seleção de registros é obrigatório.');
        }
        
    }

</script>
<div class="table">
    <form provider="visitant" role="statusVisitant" access="/controller/visitant" confirm="true">
        <input type="hidden" id="role" name="role" value="block">

        <div class="buttons">
            <button dialog="#register_visitant_form" class="btn btn-primary">
                Incluir
            </button>
            <button class="popUp btn btn-primary" onclick="popUp()">
                Detalhes
            </button>
        </div>

        <hr>

        <table class="datatable" id="table_list_visitants" title="Registro de visitantes">
            <thead>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>RG</th>
                <th>Nascimento</th>
                <th>Ult. Visita</th>
                <th>Registro</th>
                <th>Empresa</th>
                <th>Celular</th>
                <th>Email</th>
            </thead>
            <tbody></tbody>
        </table>
    </form>
</div>

<?= $this->include('/register.form') ?>

<script>

window.addEventListener('load',function(){
    setTimeout(function(){
        DataTables.importFromURL('table_list_visitants','/visitants/list');
    },500);
});

</script>