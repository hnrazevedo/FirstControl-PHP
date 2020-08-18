/*
 * © 2020 Henri Azevedo All Rights Reserved.
 */

import Submitter from "../Submitter.js";

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
        //window.dataTables.dataAdd(id, await window.submitter.setUrl(url).execute(true));
        window.dataTables.dataAdd(id, await Submitter.setUrl(url).execute(true));
    },
    getDataTable(id){
        if(window.dataTables.debug) console.log('[log] > getDataTable');
        var t = window.dataTables;
        var table = null;
        t.tables.forEach((table, i) => {
            if(table[0].getAttribute('id') === id){
                table = table[1];
            }
        });
        return table;
    },
    addData(table){
        if(window.dataTables.debug) console.log('[log] > addData');
        var t = window.dataTables;
        var dataTable = new DataTable(table,{
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

        t.tables[t.tables.length] = [table,dataTable];
    },
    evtTr(){
        if(window.dataTables.debug) console.log('[log] > evtTr');
        var t = window.dataTables;
        t.tables.forEach((table, i) => {
            if(table[0].querySelector('tr[href]') != null){
                table[0].querySelectorAll('tr[href]').forEach((tr, r) => {
                    tr.removeEventListener('dblclick',t.dblclickTr);
                    tr.addEventListener('dblclick',t.dblclickTr);
                });
            }
        });
    },
    evtButtons(){
        if(window.dataTables.debug) console.log('[log] > evtButtons');
        var t = window.dataTables;
        t.tables.forEach((table, i) => {
            if(table[0].closest('.table').querySelector('.dataTables-buttons button') != null){
                table[0].closest('.table').querySelectorAll('.dataTables-buttons button').forEach((button, b) => {
                    button.removeEventListener('click',t.clickButton);
                    button.addEventListener('click',t.clickButton);
                });
            }
        });
    },
    dblclickTr(){
        if(window.dataTables.debug) console.log('[log] > dblclickTr');
        var t = window.dataTables;

        window.location.href = this.getAttribute('href');
    },
    clickButton(){
        if(window.dataTables.debug) console.log('[log] > clickButton');
        var t = window.dataTables;

        t.tables.forEach((table, i) => {
            if(table[0].getAttribute('id') === this.closest('.table').querySelector('.datatable').getAttribute('id')){
                switch (this.dataset.role) {
                    case 'export':
                        table[1].export({
                            type: "csv",
                            download: true,
                            skipColumn: [],
                            lineDelimiter:  "\n",
                            columnDelimiter:  "|",
                            filename: table[0].getAttribute('title')
                        });
                        break;
                    default:
                        break;
                }
            }
        });
    },
    dataEvents(){
        if(window.dataTables.debug) console.log('[log] > dataEvents');
        var t = window.dataTables;
        t.tables.forEach((table, i) => {
            table[1].on('datatable.init',t.dataInit);
            table[1].on('datatable.update',t.dataUpdate);
        });
    },
    dataInit(){
        if(window.dataTables.debug) console.log('[log] > dataInit');
        var t = window.dataTables;
        t.tables.forEach((table, i) => {
            table[0].closest('.table').querySelector('.dataTable-top').prepend(t.createButtons({
                buttons:[
                        {text:"Exportar",role:"export"}
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

        t.tables.forEach((table, i) => {
            if(table[0].getAttribute('id') === id){
                table[1].rows().add(data);
            }
        });
    }
}
