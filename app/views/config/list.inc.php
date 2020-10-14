<div class="row mt-5">
<?php foreach ($configs as $config): ?>
    <!-- Tipo de impressora -->
    <?php switch($config[0]): 
        case 1: ?>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <form class="m-0">
                <select name="value" id="value" class="form-select unique" aria-label="Tipo de impressora" label="Tipo de impressora" value="<?= $config[2] ?>" onchange="updateConfig(1,this)">
                    <option value="LaserJet">LaserJet</option>
                    <option value="Matricial">Matricial</option>
                </select>
                <i class='bx select' ></i>
            </form>
        </div>
        <?php break; ?><!-- Tipo de impressora -->
    <?php endswitch; ?>
<?php endforeach; ?>
</div>

<script>
    async function updateConfig($id,$el){
        $el.setAttribute('disabled','disabled');
        $el.classList.remove('success','error');
        $el.parentNode.querySelector('i.bx').classList.remove('bx-check','bx-error-circle');
        $el.parentNode.querySelector('i.bx').classList.add('act','bx-loading');
        let $return = await Submitter.setUrl(`{{ $system.uri }}/config/update/${$id}/${$el.value}`).execute(true);
        $el.parentNode.querySelector('i.bx').classList.remove('bx-loading');
        

        $el.parentNode.querySelector('i.bx').classList.add( ($return.success !== undefined) ? 'bx-check' : 'bx-error-circle' );
        $el.classList.add( ($return.success !== undefined) ? 'success' : 'error' );
        $el.removeAttribute('disabled');
    }
</script>