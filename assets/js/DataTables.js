import Submitter from "./Submitter.js";
import {DataTable} from "/../assets/addons/Simple-DataTables/datatable.js";

"use strict";

const DataTables = function(){
    return {
        tables:[],
        start(){
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
    
            var dataTable = new DataTable(table,{
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
                                {text:"Exportar",role:"export"},
                                {text:"Imprimir",role:"print"},
                                {text:"Marcar todos",role:"select_all"}
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
    
            dataTable.activeRows.forEach(function(tr,i){
                var option = document.createElement('option');
                var id = tr.querySelector('td:nth-child(1)').innerHTML;
                option.value = id;
                option.innerHTML = id;
                select.appendChild(option);

                tr.addEventListener('click',DataTables.clickTr);
            });
        },
        createButtons(buttons){
            var div = document.createElement('div');
            div.classList.add('DataTables-buttons');
    
            buttons.buttons.forEach((button, i) => {
                var b = document.createElement('button');
                b.setAttribute('data-role',button.role);
                b.setAttribute('value',button.text);
                b.innerHTML = button.text;
                div.prepend(b);
            });
            return div;
        },
        dblclickTr(){
            if(this.getAttribute('href') != null){ 
                window.location.href = this.getAttribute('href');
            }
        },
        clickTr(e){
            var tr = e.target.parentNode;
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
                button.innerHTML = 'Marcar todos';
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
                            this.innerHTML = 'Desmarcar';
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
                            this.innerHTML = 'Marcar todos';
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
        }
    }
}();

export default DataTables;