
<link href="{{ $system.uri }}/assets/css/print.css" rel="stylesheet" type="text/css">
<?= $this->import($page) ?>
<script>
    window.addEventListener('load', function(){
        window.print();
        setTimeout(function(){
            window.close();
        },3000);
    });
</script>