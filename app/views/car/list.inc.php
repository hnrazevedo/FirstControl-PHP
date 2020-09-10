<script>

    function popUp(){
        var $select = document.querySelector('form[provider="car"][role="statusCar"]').querySelector('select#dataselect');
        var $id = null;
        var $sel = 0;
        $select.childNodes.forEach((option, o) => {
            if(option.selected === true){
                $sel++;
                if($sel > 1){
                    window.Dialog.popUp('Selecione apenas um veículo.');
                    $id = null;
                    return false;
                }
                $id = option.value;
            }
        });

        if($id != null){
            var popup = window.open (
                '/car/details/'+$id,
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
    <form provider="car" role="statusCar" access="/controller/car" confirm="true">
        <input type="hidden" id="role" name="role" value="block">

        <div class="buttons">
            <button dialog="#register_car_form" class="btn btn-primary">
                Incluir
            </button>
            <button class="popUp btn btn-primary" onclick="popUp()">
                Detalhes
            </button>
        </div>

        <hr>

        <table class="datatable" id="table_list_cars" title="Registro de veículos">
            <thead>
                <th>ID</th>
                <th>Placa</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Cor</th>
                <th>Nº eixos</th>
                <th>Motorista</th>
            </thead>
            <tbody></tbody>
        </table>
    </form>
</div>

<?= $this->include('/register.form') ?>

<script>

window.addEventListener('load',function(){
    setTimeout(function(){
        window.DataTables.importFromURL('table_list_cars','/car/list');
    },500);
});

</script>