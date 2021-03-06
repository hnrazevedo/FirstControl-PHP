"use strict";

const DataTables = function(){
    return {
        tables:[],
        init(){
            DataTables.initTables();
            DataTables.setEvents();
        },
        initTables(){
            if(document.querySelector('.datatable') != null){
                document.querySelectorAll('.datatable').forEach((table, i) => {
                    DataTables.createDataTable(table);
                });
            }
        },
        setEvents(){
            DataTables.tables.forEach((dataTable, i) => {
                dataTable.on('datatable.init', function(){
                    DataTables.dataInit(dataTable);
                });
                dataTable.on('datatable.sort', function(){
                    DataTables.dataContent(dataTable);
                });
            });
            DataTables.documentEvents();
        },
        documentEvents(){
            window.addEventListener('resize',DataTables.ajustSize);
        },
        ajustSize(){
            DataTables.tables.forEach((dataTable) => {
                if(dataTable.table.closest('div.dataTable-container').clientWidth < dataTable.table.closest('div.dataTable-container').scrollWidth && !dataTable.table.closest('div.table').classList.contains('min')){
                    dataTable.table.setAttribute('min-width',dataTable.table.closest('div.dataTable-container').scrollWidth);
                    dataTable.table.closest('div.table').classList.add('min');
                }else{
                    if(dataTable.table.closest('div.dataTable-container').clientWidth >= dataTable.table.getAttribute('min-width')){
                        dataTable.table.closest('div.table').classList.remove('min');
                    }
                }
            });  
        },
        createDataTable(table){
            var select = document.createElement('select');
            select.setAttribute('multiple','multiple');
            select.setAttribute('name','dataselect');
            select.setAttribute('id','dataselect');
            select.setAttribute('label','Seleção de registros');
            select.classList.add('dataTable');
            table.before(select);
    
            var dataTable = new simpleDatatables.DataTable(table,{
                scrollY:true,
                perPageSelect: [1,2,10, 50, 100, 200],
                sortable: true,
                labels: {
                    placeholder: "Pesquisar",
                    perPage: "{select} Registros por página",
                    noRows: "Nenhum registro encontrado.",
                    info: "{start} - {end} de {rows}"
                },
                layout: {
                    top: "{search}{info}",
                    bottom: "{select}{pager}"
                }
            });
    
            DataTables.tables[DataTables.tables.length] = dataTable;
        },
        dataInit(dataTable){
            DataTables.tables.forEach((dataTable, i) => {
                dataTable.table.closest('.table').querySelector('.dataTable-top').prepend(
                    DataTables.createButtons({
                        buttons:[
                                {text:"<i class='bx bx-export' ></i>",role:"export", tooltip:'Exportar'},
                                {text:"<i class='bx bx-printer' ></i>",role:"print", tooltip:'Imprimir'},
                                {text:"<i class='bx bx-checkbox' ></i>",role:"select_all", tooltip:'Seleção'}
                        ]
                    })
                );
            });
    
            dataTable.table.closest('.table').querySelectorAll('.DataTables-buttons button').forEach((button, b) => {
                button.addEventListener('click',DataTables.clickButton);
            }); 
        },
        dataContent(dataTable){
            var select = dataTable.table.closest('.table').querySelector('select.dataTable');
    
            select.innerHTML = null;

            var button = dataTable.table.closest('.table').querySelector('.DataTables-buttons [data-role="desmarc"]'); 
            if(button != null){
                button.innerHTML = "<i class='bx bx-checkbox' ></i>";
                button.dataset.role = 'select_all';
            }
    
            dataTable.activeRows.forEach(function(tr,i){
                var option = document.createElement('option');
                var id = tr.querySelector('td:nth-child(1)').innerHTML;
                option.value = id;
                option.innerHTML = id;
                select.appendChild(option);

                tr.querySelectorAll('td')?.forEach(function(td,tdd){
                    let th = dataTable.table.querySelector('th:nth-child('+(tdd+1)+') a')?.innerHTML + ':' ?? '';
                    td.dataset.legend = th;
                });

                tr.addEventListener('click',DataTables.clickTr);
                tr.addEventListener('dblclick',DataTables.dblclickTr);
            });
        },
        createButtons(buttons){
            var div = document.createElement('div');
            div.classList.add('DataTables-buttons');
    
            buttons.buttons.forEach((button, i) => {
                var b = document.createElement('button');
                b.classList.add('btn','btn-primary');
                b.setAttribute('data-role',button.role);
                b.setAttribute('data-toggle','tooltip');
                b.setAttribute('title',button.tooltip);
                b.setAttribute('value',button.text);
                b.innerHTML = button.text;
                div.prepend(b);
            });
            return div;
        },
        dblclickTr(e){
            if(e.target.closest('table').getAttribute('href') != null){ 
                window.location.href = e.target.closest('table').getAttribute('href') + e.target.closest('tr').querySelector('td:first-child').innerHTML;
            }
        },
        clickTr(e){
            var tr = e.target.parentNode;
            if(null === tr.querySelector('td:nth-child(1)')){
                return;
            }
            var id = tr.querySelector('td:nth-child(1)').innerHTML;
            var select = tr.closest('.table').querySelector('select.datatable');
    
            if(tr.getAttribute('selected') == null){
                tr.setAttribute('selected',true);
                tr.classList.add('selected');
                select.querySelector('option[value="'+id+'"]').selected = 'selected';
            }else{
                tr.removeAttribute('selected');
                tr.classList.remove('selected');
                select.querySelector('option[value="'+id+'"]').selected = '';
            }
    
            var button = tr.closest('.table').querySelector('.DataTables-buttons [data-role="desmarc"]'); 
            if(button != null){
                button.innerHTML = "<i class='bx bx-checkbox' ></i>";
                button.dataset.role = 'select_all';
            }
        },
        getDataTable(id){
            var table = null;
            DataTables.tables.forEach((dataTable, i) => {
                if(dataTable.table.getAttribute('id') === id){
                    table = dataTable;
                }
            });
            return table;
        },
        async importFromURL(id,url){
            DataTables.dataAdd(id, await Submitter.setUrl(url).execute(true));
            loadToolTips();
        },
        getSelecteds(DataTables){
            var value = [];
            DataTables.table.closest('div.table').querySelector('select.dataTable').childNodes.forEach((option, o) => {
                if(option.selected === true){
                    value[value.length] = option.value;
                }
            });
            return value;
        },
        clickButton(e){
            e.preventDefault();
            DataTables.tables.forEach((dataTable, i) => {
                if(dataTable.table.getAttribute('id') === this.closest('.table').querySelector('table.datatable').getAttribute('id')){
                    switch (this.dataset.role) {
                        case 'export':
                            dataTable.export({
                                type: "csv",
                                download: true,
                                skipColumn: [],
                                lineDelimiter:  "\n",
                                columnDelimiter:  "|",
                                filename: dataTable.table.getAttribute('title')
                            });
                            break;
                        case 'print':
                            dataTable.print();
                            break;
                        case 'select_all':
                            dataTable.activeRows.forEach(function(tr, i){
                                tr.setAttribute('selected',true);
                                tr.classList.add('selected');
    
                                var select = dataTable.table.closest('.table').querySelector('select.datatable');
                                select.querySelectorAll('option').forEach(function(option, o){
                                    option.selected = 'selected';
                                });
                            });
                            this.innerHTML = "<i class='bx bx-checkbox-checked' ></i>";
                            this.dataset.role = 'desmarc';
                            break;
                        case 'desmarc':
                            dataTable.activeRows.forEach(function(tr, i){
                                tr.removeAttribute('selected');
                                tr.classList.remove('selected');
    
                                var select = dataTable.table.closest('.table').querySelector('select.datatable');
                                select.querySelectorAll('option').forEach(function(option, o){
                                    option.selected = '';
                                });
                            });
                            this.innerHTML = "<i class='bx bx-checkbox' ></i>";
                            this.dataset.role = 'select_all';
                            break;
                        
                        default:
                            console.log(this.dataset.role);
                            break;
                    }
                }
            });
        },
        dataAdd(id,data){
            DataTables.tables.forEach((dataTable, i) => {
                if(dataTable.table.getAttribute('id') === id){
                    dataTable.rows().add(data);
                    DataTables.dataContent(dataTable);
                }
            });
            DataTables.ajustSize();
        }
    }
}();
