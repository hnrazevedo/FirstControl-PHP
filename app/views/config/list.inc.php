<div class="row mt-5">
<?php foreach ($configs as $config): ?>
    <!-- Tipo de impressora -->
    <?php switch($config[0]): 
        case 1: ?>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <form class="m-0">
                <select name="value" id="value" class="form-select" aria-label="Tipo de impressora" label="Tipo de impressora" value="<?= $config[2] ?>" onchange="updateConfig(1,this)">
                    <option value="LaserJet">LaserJet</option>
                    <option value="Matricial">Matricial</option>
                </select>
            </form>
        </div>
        <?php break; ?><!-- Tipo de impressora -->
    <?php endswitch; ?>
<?php endforeach; ?>
</div>

<script>
    async function updateConfig($id,$el){
        $el.setAttribute('disabled','disabled');
        let $return = await Submitter.setUrl(`{{ $system.uri }}/config/update/${$id}/${$el.value}`).execute(true);
        $el.removeAttribute('disabled');
    }
</script>