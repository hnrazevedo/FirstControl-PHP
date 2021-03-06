'use strict';

window.addEventListener('load',function(){

    Form.init();
    Dialog.init();
    DataTables.init();
    Mask.init();
    Cam.init();
    
    requestValidateAll();

    setTimeout(function(){
        document.querySelector('body').classList.add('loaded');
    },500);
    
    loadToolTips();
    loadAlerts();

});

function loadAlerts(){
    if(document.querySelectorAll('.alert .alert-close') != null){
        document.querySelectorAll('.alert .alert-close').forEach(function(e, i){
            e.addEventListener('click', function(){
                var alert = e.closest('div.alert');
                alert.style.opacity = 0;
                setTimeout(function(){
                    alert.style.height = 0;
                    alert.style.padding = 0;
                    alert.style.marginBottom = 0;
                },400);
            })
        });
    }
}

function loadToolTips(){
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl, {
            container:'body',
            boundary: 'window'
        });
    });
}

function toggleFullScreen() {
    if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen();
    } else {
        if (document.exitFullscreen) {
            document.exitFullscreen(); 
        }
    }
}


function requestValidateAll(){

    Validator.options({
        alert : Dialog.popUp,
        submitter : Submitter.work,
        return: false
    });

    if(document.querySelectorAll('form[id].ajax')!=undefined){
        document.querySelectorAll('form[id].ajax').forEach(function(frm,i){
    
            var data = new FormData();
            data.processData = false;
            data.append('REQUEST_METHOD','AJAX');
            data.append('_PROVIDER', (null !== frm.querySelector('[name="_PROVIDER"]')) ? frm.querySelector('[name="_PROVIDER"]').value : null);
            data.append('_ROLE', (null !== frm.querySelector('[name="_ROLE"]')) ? frm.querySelector('[name="_ROLE"]').value : null);
            data.append('ID', frm.getAttribute('id'));
    
            if(self.fetch) {
                fetch('/validator',
                    {
                        method: 'POST',
                        headers: {'Request_Method': 'ajaxx'},
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
                            
                            frm.querySelector('.alert').classList.remove('d-none');
                            frm.querySelector('.alert').classList.add('alert-danger');
                            frm.querySelector('.alert').innerHTML = response[r]['message'];
                            break;
                    }
                }
            }
        });
    }
}
