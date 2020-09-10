'use strict';

import Dialog from "./Dialog.js";
import Submitter from "./Submitter.js"; 
import Form from "./Form.js";
import DataTables from "./DataTables.js";

/* JSmask */
let JSmask = document.createElement('script');
JSmask.setAttribute('src','http://localhost/assets/js/JSmask.js');
JSmask.setAttribute('type','text/javascript');
document.head.append(JSmask);

/* JSvalidator */    
let JSvalidator = document.createElement('script');
JSvalidator.setAttribute('src','http://localhost/assets/js/JSvalidator.js');
JSvalidator.setAttribute('type','text/javascript');
document.head.append(JSvalidator);

/* AOS */    
let JSaos = document.createElement('script');
JSaos.setAttribute('src','http://localhost/assets/addons/aos/aos.js');
JSaos.setAttribute('type','text/javascript');
document.head.append(JSaos);

let CSSaos = document.createElement('script');
CSSaos.setAttribute('src','http://localhost/assets/addons/aos/aos.css');
CSSaos.setAttribute('rel','stylesheet');
CSSaos.setAttribute('type','text/css');
document.head.append(CSSaos);



window.addEventListener('load',function(){

    window.Form = Form;
    window.Dialog = Dialog;
    window.DataTables = DataTables;
    window.Submitter = Submitter;

    Form.start();
    Dialog.start();
    DataTables.start();
    AOS.init();
    
    requestValidateAll();

    setTimeout(function(){
        document.querySelector('body').classList.add('loaded');
    },500)
    
});


function requestValidateAll(){

    window.Validator.options({
        alert : window.Dialog.popUp,
        submitter : window.Submitter.work,
        return: false
    });

    if(document.querySelectorAll('form[provider]')!=undefined){
        document.querySelectorAll('form[provider]').forEach(function(frm,i){
    
            var data = new FormData();
            data.processData = false;
            data.append('provider',frm.getAttribute('provider'));
            data.append('role',frm.getAttribute('role'));
    
            if(self.fetch) {
                 
                fetch('/validator',
                    {
                        method: 'POST',
                        headers: {'Requested-Method': 'ajax'},
                        body: data
                    })
                    .then(res => {
                        return res.json();
                    })
                    .then(post => {
                        formWork(post);
                    })
                    .catch(err => {
                        console.log(err);
                    }
                );
            } else {
                var xhr = new XMLHttpRequest();
                xhr.open( "POST", '/validator' , true );
                xhr.setRequestHeader("Requested-Method", "ajax");
    
                xhr.addEventListener('load',function(e){
                    if(isJson(xhr.response)){
                        response = JSON.parse(String(xhr.response));
                        formWork(response);
                    }else{
                        console.log(xhr.response);
                    }
                });
    
                xhr.addEventListener('error',function(XMLHttpRequest,textStatus,errorThrown){
                    xhrError(XMLHttpRequest,textStatus,errorThrown);
                });
            }
    
            function formWork(response){
                for(var r in response) {
                    switch(r){
                        case 'success':
                            eval(response[r]);
                            break;
                        case 'error':
                            frm.classList.add('disabled');
                            frm.querySelector('.panel-message').classList.add('error');
                            frm.querySelector('.panel-message').innerHTML = response[r]['message'];
                            break;
                    }
                }
            }
        });
    }
}
