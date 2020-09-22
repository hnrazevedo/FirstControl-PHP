"use strict";

const Submitter = function(){
	return {
        form:null,
        data:null,
        xhr:null,
        response:null,
        url:null,
        hearders:null,
		work(e){
			Submitter.hearders = {
				'Requested-Method': 'ajax'
            };
            
            if(e.target.length != 0){
                e.preventDefault();
                Submitter.setForm(e.target);
            }else{
    			Submitter.setForm(e);
            }

            var submit =  ( Submitter.form.getAttribute('confirm') == null);

            if(submit){
                Submitter.beforeRequest();
                Submitter.execute();
                return this;
            }

            Dialog.confirm(function(){
                Submitter.beforeRequest();
                Submitter.execute();
                return this;
            });
		},
		async execute(result = null){
			if(window.fetch) {
				await Submitter.fetchRequest();
			}else{
				Submitter.XMLHttpRequest();
            }
            
			return (result) ? Submitter.getResponse() : Submitter;
		},
		setUrl(u){
			Submitter.url = u;
			Submitter.hearders = {'Requested-Method': 'ajax'};
			return Submitter;
        },
        setForm(f){
            Submitter.form = f;
            Submitter.url = Submitter.form.getAttribute('access');
			Submitter.prepareData();
            return this;
        },
        setResponse(r){
            Submitter.response = r;
            return this;
        },
        getResponse(){
            return Submitter.response;
        },
        prepareData(){
            Submitter.data = new FormData(Submitter.form);

            Submitter.form.childNodes.forEach((input,i) => {
                if(input instanceof Element || input instanceof HTMLDocument){
                    if(input.getAttribute('multiple') != null){
                        var value = [];
                        input.childNodes.forEach((option, o) => {
                            if(option.selected === true){
                                value.push(option.value);
                            }
                        });
    
                        Submitter.data.append(input.getAttribute('name'),JSON.stringify(value));
                        
                    }
                }               
            });

            var data = JSON.stringify(Object.fromEntries(Submitter.data));
    
            Submitter.data = new FormData(Submitter.form);
            Submitter.data.append('data',data);
            Submitter.data.append('provider',Submitter.form.getAttribute('provider'));
            Submitter.data.append('role',Submitter.form.getAttribute('role'));
    
            return this;
        },
        beforeRequest(){
            
            if(Submitter.form.querySelector('.alert')!=null){
                Submitter.form.querySelector('.alert').classList.remove(['alert-primary','alert-secondary','alert-success','alert-danger','alert-warning','alert-info','alert-light','alert-dark']);
            }
    
            Submitter.form.classList.add('submitting');
    
            if(document.querySelector(':focus')!=undefined){
                document.querySelector(':focus').blur();
            }
    
            if(Submitter.form.querySelectorAll('.error')!=null){
                Submitter.form.querySelectorAll('.error').forEach(err => err.classList.remove('error'));
            }
    
            if(Submitter.form.querySelectorAll('[value]:not([disabled])')!=null){
                Submitter.form.querySelectorAll('[value]:not([disabled])').forEach(function(e,i){
                    e.removeAttribute('disabled');
                    e.classList.add('submitting');
                });
            }
    
            if(document.querySelector('dialog.loading') != null){
                document.querySelector('dialog.loading').classList.add('open');
            }
            
            return this;
        },
        async fetchRequest(){  
            await fetch(Submitter.url,
                {
                    method: 'POST',
                    headers: Submitter.hearders,
                    body: Submitter.data
                }).then(res => {
                    return res.json();
                })
                .then(post => {
                    Submitter.setResponse(post);
                    Submitter.responseWork();
                    Submitter.requestLoadEnd();
                })
                .catch(err => {
                    //console.log(err);
                });
        },
        XMLHttpRequest(){
            Submitter.xhr = new XMLHttpRequest();
            Submitter.xhr.open( "POST", Submitter.url , true );
            Submitter.xhr.setRequestHeader(Submitter.hearders);
            Submitter.xhr.addEventListener('load',Submitter.xhrLoad);
            Submitter.xhr.upload.addEventListener('progress',Submitter.xhrProgress,false);
            Submitter.xhr.addEventListener('loadend',Submitter.requestLoadEnd);
            Submitter.xhr.addEventListener('abort',Submitter.xhrAbort);
            Submitter.xhr.addEventListener('error',Submitter.xhrError);
            Submitter.xhr.send(Submitter.data);
            return this;
        },
        xhrError(e){
            console.log(e);
            return this;
        },
        xhrAbort(){
            console.log('Requisição cancelada pelo cliente.');
            return this;
        },
        xhrLoad(){
            try{
                Submitter.setResponse(Submitter.response);
                if(!Submitter.isJson(Submitter.response)){
                    throw ('O servidor não respondeu sua solicitação da forma esperada.');
                }
                var response = JSON.parse(Submitter.response);
                Submitter.setResponse(response);
                Submitter.responseWork();
            }catch(e){
                console.log(e);
                Submitter.onError(e);
            }
            Dialog.start();
            return this;
        },
        responseWork(){
            for(var r in Submitter.response){
                switch(r){
                    case 'success':
                        if(typeof Submitter.response[r]['message'] != 'undefined'){
                            window.Dialog.popUp(Submitter.response[r]['message'],'success');
                        }
                    break;
                    case 'error':
                        if(typeof Submitter.response[r] === "object"){
                            for(var er in Submitter.response[r]){

                                var input = (Submitter.form.querySelector("[name='"+Submitter.response[r][er]['input']+"']") != null) ? Submitter.form.querySelector("[name='"+Submitter.response[r][er]['input']+"']") : null;
                                var message = Submitter.response[r][er]['message'];
    
                                if(input != null && Submitter.form.querySelector('p[name="'+Submitter.response[r][er]['input']+'"]') != null){
                                    input.classList.add('error');
                                    Submitter.form.querySelector('p[name="'+Submitter.response[r][er]['input']+'"]').classList.add('error')
                                    Submitter.form.querySelector('p[name="'+Submitter.response[r][er]['input']+'"]').innerHTML = input.getAttribute('label')+" "+message;
                                    Submitter.form.querySelector('p[name="'+Submitter.response[r][er]['input']+'"]').style.display = 'block';
                                }else{
                                    var inputText = (input != null) ? input.getAttribute('label')+':' : '';
                                    window.Dialog.popUp(`${inputText} ${message}`,'error');
                                }
                            }
                        }
                        
                        if(typeof Submitter.response[r]['message'] != 'undefined') {
                            window.Dialog.popUp(Submitter.response[r]['message'],'error');
                        }
                    break;
                    case 'reset':
                        if(document.querySelector('form.submitting') != null){
                            document.querySelector('form.submitting').querySelectorAll('input').forEach(function(e,i){
                                if(e.getAttribute('fixed') == null || e.getAttribute('type') != 'submit'){
                                    e.value = '';
                                    e.setAttribute('value','');
                                }
                            });

                            if(document.querySelector('form.submitting').closest('dialog') != null){
                                document.querySelector('form.submitting').closest('dialog').querySelector('[close]').click();
                            }
                        }
                    break;
                    case 'close':
                        window.location.hash = '/';
                    break;
                    case 'script':
                        eval(Submitter.response[r]);
                    break;
                }
            }
            return this;
        },
        onError(e){
            console.log(e);
            window.Dialog.popUp(e,'error');
            return this;
        },
        isJson(json){
            var is = false;
            try{
                JSON.parse(json);
                is = true;
            }catch(e){
                is = false;
            }
            return is;
        },
        requestLoadEnd(){
            if(document.querySelector('form.submitting')!=undefined){
                document.querySelector('form.submitting').querySelectorAll('.submitting').forEach(function(input,im){
                    input.classList.remove('disabled');
                    input.removeAttribute('disabled');
                });
                document.querySelector('form.submitting').classList.remove('submitting');
                if(document.querySelector('dialog.loading') != null){
                    document.querySelector('dialog.loading').classList.remove('open');
                }
            }
            return this;
        }
	};
}();
