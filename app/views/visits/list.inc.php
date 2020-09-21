<script>

    function popUp(){
        var $select = document.querySelector('form[provider="visit"][role="statusVisit"]').querySelector('select#dataselect');
        var $id = null;
        var $sel = 0;
        $select.childNodes.forEach((option, o) => {
            if(option.selected === true){
                $sel++;
                if($sel > 1){
                    window.Dialog.popUp('Selecione apenas um visita.');
                    $id = null;
                    return false;
                }
                $id = option.value;
            }
        });

        if($id != null){
            var popup = window.open (
                '/visit/details/'+$id,
                'pagina',
                "menubar=0,width="+screen.availWidth+", height="+screen.availHeight+",top=0, left=0");
            
            popup.moveTo(0, 0);
            popup.resizeTo(screen.width, screen.height);
        }else{
            window.Dialog.popUp('Seleção de registros é obrigatório.');
        }
        
    }

</script>
<div class="table">
    <form provider="visit" role="statusVisit" access="/controller/visit" confirm="true">
        <input type="hidden" id="role" name="role" value="block">

        <div class="buttons">
            <button dialog="#register_visit_form" class="btn btn-primary">
                Incluir
            </button>
            <button class="popUp btn btn-primary" onclick="popUp()">
                Detalhes
            </button>
        </div>

        <hr>

        <table class="datatable" id="table_list_visits" title="Registro de visites">
            <thead>
                <th>ID</th>
                <th>Visitante</th>
                <th>CPF</th>
                <th>Entrada</th>
                <th>Saída</th>
                <th>Status</th>
                <th>Razão/Motivo</th>
                <th>Responsável</th>
                <th>Veículo</th>
            </thead>
            <tbody></tbody>
        </table>
    </form>
</div>

<?= $this->include('/register.form') ?>

<script>

window.addEventListener('load',function(){
    setTimeout(function(){
        DataTables.importFromURL('table_list_visits','/visit/list');
    },500);
});

</script>