'use strict';

document.addEventListener('DOMContentLoaded',function(){
    
    /* JSmask */
    let JSmask = document.createElement('script');
    //JSmask.setAttribute('src','https://cdn.jsdelivr.net/gh/hnrazevedo/JSmask/JSmask.js');
    JSmask.setAttribute('src','http://localhost/assets/js/JSmask.js');
    JSmask.setAttribute('type','text/javascript');
    document.head.append(JSmask);

    let JSvalidator = document.createElement('script');
    JSvalidator.setAttribute('src','https://cdn.jsdelivr.net/gh/hnrazevedo/JSvalidator/JSvalidator.js');
    //JSvalidator.setAttribute('src','http://localhost/assets/js/JSvalidator.js');
    JSvalidator.setAttribute('type','text/javascript');
    document.head.append(JSvalidator);

    (async function(){
        await (await import("./Dialog.js")).default();
        await (await import("./Submitter.js")).default(); 
        await (await import("./Form.js")).default();
        await (await import("./DataTables.js")).default();
        //await (await import("./Validator.js")).default(); 
    
        window.Form.start();
        window.Dialog.start();
        window.DataTables.start();

        /* Validate */
        Validator.options({
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
                        });
    
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
    })();   
});