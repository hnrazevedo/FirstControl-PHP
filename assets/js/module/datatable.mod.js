/*
 * © 2020 Henri Azevedo All Rights Reserved.
 */

import Submitter from "../Submitter.js";
import {DataTable} from "/../../assets/addons/Simple-DataTables/datatable.js";

"use strict";

window.dataTables = {
    tables:[],
    debug:false,
    started:false,
    start(options = null){
        var t = window.dataTables;
        t.setOptions(options);
        t.findTables();
        t.dataEvents();
        t.started = true;
    },
    setOptions(opt){
        if(opt != null){
            if(opt.hasOwnProperty('debug') ? opt.debug : false) console.log('[log] > setOptions');
            var t = window.dataTables;
            t.debug = opt.hasOwnProperty('debug') ? opt.debug : false;
        }
    },
    findTables(){
        if(window.dataTables.debug) console.log('[log] > findTables');
        var t = window.dataTables;
        if(document.querySelector('.datatable') != null){
            document.querySelectorAll('.datatable').forEach((table, i) => {
                t.addData(table);
            });
        }
    },
    async importFromURL(id,url){
        window.dataTables.dataAdd(id, await Submitter.setUrl(url).execute(true));
    },
    getDataTable(id){
        if(window.dataTables.debug) console.log('[log] > getDataTable');
        var t = window.dataTables;
        var table = null;
        t.tables.forEach((dataTable, i) => {
            if(dataTable.table.getAttribute('id') === id){
                table = dataTable.table;
            }
        });
        return table;
    },
    addData(table){
        if(window.dataTables.debug) console.log('[log] > addData');
        var t = window.dataTables;

        var select = document.createElement('select');
        select.setAttribute('multiple','multiple');
        select.setAttribute('id',table.getAttribute('id'));
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

        t.tables[t.tables.length] = dataTable;
        t.evtDataTable(dataTable);
    },
    evtDataTable(dataTable){
        dataTable.on('datatable.update', teste);
        

        function teste(){
            var select = dataTable.table.closest('.table').querySelector('select.dataTable');

            dataTable.data.forEach(function(tr,i){
                var option = document.createElement('option');
                    var id = tr.querySelector('td:nth-child(1)').innerHTML;
                    option.value = id;
                    option.innerHTML = id;
                    select.appendChild(option);
                
            });
        }
    },
    evtTr(){
        if(window.dataTables.debug) console.log('[log] > evtTr');
        var t = window.dataTables;
      
        t.tables.forEach((dataTable, i) => {
            if(dataTable.table.querySelector('tr') != null){
                dataTable.table.querySelectorAll('tr').forEach((tr, i) => {
                    tr.removeEventListener('click',t.clickTr);
                    tr.addEventListener('click',t.clickTr);
                });
            }
        });
    },
    evtButtons(){
        if(window.dataTables.debug) console.log('[log] > evtButtons');
        var t = window.dataTables;
        t.tables.forEach((dataTable, i) => {
            if(dataTable.table.closest('.table').querySelector('.dataTables-buttons button') != null){
                dataTable.table.closest('.table').querySelectorAll('.dataTables-buttons button').forEach((button, b) => {
                    button.removeEventListener('click',t.clickButton);
                    button.addEventListener('click',t.clickButton);
                });
            }
        });
    },
    clickTr(e){
        var t = window.dataTables;
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

        var button = tr.closest('.table').querySelector('.dataTables-buttons [data-role="desmarc"]'); 
        if(button != null){
            button.innerHTML = 'Marcar todos';
            button.dataset.role = 'select_all';
        }
    },
    dblclickTr(){
        if(window.dataTables.debug) console.log('[log] > dblclickTr');
        var t = window.dataTables;

        window.location.href = this.getAttribute('href');
    },
    clickButton(){
        if(window.dataTables.debug) console.log('[log] > clickButton');
        var t = window.dataTables;

        t.tables.forEach((dataTable, i) => {
            if(dataTable.table.getAttribute('id') === this.closest('.table').querySelector('.datatable').getAttribute('id')){
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
                        dataTable.table.querySelectorAll('tr').forEach(function(tr, i){
                            tr.setAttribute('selected',true);
                            tr.classList.add('selected');
                            var select = tr.closest('.table').querySelector('select.datatable');
                            select.querySelectorAll('option').forEach(function(option, o){
                                option.selected = 'selected';
                            });
                        });
                        this.innerHTML = 'Desmarcar';
                        this.dataset.role = 'desmarc';
                        break;
                    case 'desmarc':
                        dataTable.table.querySelectorAll('tr').forEach(function(tr, i){
                            tr.removeAttribute('selected');
                            tr.classList.remove('selected');
                            var select = tr.closest('.table').querySelector('select.datatable');
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
    dataEvents(){
        if(window.dataTables.debug) console.log('[log] > dataEvents');
        var t = window.dataTables;
        t.tables.forEach((dataTable, i) => {
            dataTable.on('datatable.init',t.dataInit);
            dataTable.on('datatable.update',t.dataUpdate);
            dataTable.on('datatable.page', t.dataUpdate);
        });
    },
    dataInit(){
        if(window.dataTables.debug) console.log('[log] > dataInit');
        var t = window.dataTables;
        t.tables.forEach((dataTable, i) => {
            dataTable.table.closest('.table').querySelector('.dataTable-top').prepend(t.createButtons({
                buttons:[
                        {text:"Exportar",role:"export"},
                        {text:"Imprimir",role:"print"},
                        {text:"Marcar todos",role:"select_all"}
                ]
            }));
        });
        t.evtButtons();
        t.evtTr();
    },
    dataUpdate(){
        if(window.dataTables.debug) console.log('[log] > dataUpdate');
        var t = window.dataTables;
        t.evtTr();
    },
    createButtons(buttons){
        if(window.dataTables.debug) console.log('[log] > createButtons');
        var t = window.dataTables;

        var div = document.createElement('div');
        div.classList.add('dataTables-buttons');

        buttons.buttons.forEach((button, i) => {
            var b = document.createElement('button');
            b.setAttribute('data-role',button.role);
            b.setAttribute('value',button.text);
            b.innerHTML = button.text;
            div.prepend(b);
        });
        return div;
    },
    dataAdd(id,data){
        if(window.dataTables.debug) console.log('[log] > dataAdd');
        var t = window.dataTables;

        if(!t.started){
            t.start();
        }

        t.tables.forEach((dataTable, i) => {
            if(dataTable.table.getAttribute('id') === id){
                dataTable.rows().add(data);
            }
        });
    }
}
