<div class="table">
    <form>
        <table class="datatable" id="{{ $tab.id }}" title="{{ $tab.title }}" href="{{ $tab.href }}">
            <thead>
                {{!! $tab.thead !!}}
            </thead>
            <tbody></tbody>
        </table>
    </form>
</div>
<script>
window.addEventListener('load',function(){
    setTimeout(function(){
        DataTables.importFromURL('{{ $tab.id }}','{{ $tab.uri }}');
    },500);
});
</script>