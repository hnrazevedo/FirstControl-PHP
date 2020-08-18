/* ========================================================================
 * Submitter JS: v0.0.1
 * 
 * Copyright (c) 2020 Henri Azevedo
 * ========================================================================
 */

import Dialog from "./Dialog.js";

"use strict";

var Submitter = function(){
	var form, data, xhr, response, url;
	return {
		work(e){
			this.hearders = {
				'Requested-Method': 'ajax'
			  };
			e.preventDefault();
			this.setForm(e.target);
			this.prepareData();
			this.beforeRequest();
			this.execute();
			return this;
		},
		async execute(result = null){
			if(window.fetch) {
				await this.fetchRequest();
			}else{
				this.XMLHttpRequest();
			}
	
			return (result) ? this.getResponse() : this;
		},
		setUrl(u){
			this.url = u;
			this.hearders = {'Requested-Method': 'ajax'};
			return this;
        },
        setForm(f){
            this.form = f;
            this.url = this.form.getAttribute('access');
            return this;
        },
        setResponse(r){
            this.response = r;
            return this;
        },
        getResponse(){
            return this.response;
        },
        prepareData(){
            this.data = new FormData(this.form);

            for(var at = 0; at< this.form.attributes.length; at++){
                if(this.form.attributes[at].name.substring(0,1)=='_'){
                    this.data.append(this.form.attributes[at].name,this.form.attributes[at].value);
                }
            }
    
            var data = JSON.stringify(Object.fromEntries(this.data));
    
            this.data = new FormData();
            this.data.append('data',data);
            this.data.append('provider',this.form.getAttribute('provider'));
            this.data.append('role',this.form.getAttribute('role'));
    
            return this;
        },
        beforeRequest(){
            
            if(this.form.querySelector('.panel-message')!=null){
                this.form.querySelector('.panel-message').classList.remove(['error','success']);
            }
    
            this.form.classList.add('submitting');
    
            if(document.querySelector(':focus')!=undefined){
                document.querySelector(':focus').blur();
            }
    
            if(this.form.querySelectorAll('.error')!=null){
                this.form.querySelectorAll('.error').forEach(err => err.classList.remove('error'));
            }
    
            if(this.form.querySelectorAll('[value]:not([disabled])')!=null){
                this.form.querySelectorAll('[value]:not([disabled])').forEach(function(e,i){
                    e.removeAttribute('disabled');
                    e.classList.add('submitting');
                });
            }
    
            if(document.querySelector('dialog.loading') != null){
                document.querySelector('dialog.loading').setAttribute('open',true);
            }
            
            return this;
        },
        async fetchRequest(){  
            await fetch(this.url,
                {
                    method: 'POST',
                    headers: this.hearders,
                    body: this.data
                }).then(res => {
                    return res.json();
                })
                .then(post => {
                    this.setResponse(post);
                    this.requestLoadEnd();
                    this.responseWork();
                })
                .catch(err => {
                    console.log(err);
                });
        },
        XMLHttpRequest(){
            this.xhr = new XMLHttpRequest();
            this.xhr.open( "POST", this.url , true );
            this.xhr.setRequestHeader(this.hearders);
            this.xhr.addEventListener('load',this.xhrLoad);
            this.xhr.upload.addEventListener('progress',this.xhrProgress,false);
            this.xhr.addEventListener('loadend',this.requestLoadEnd);
            this.xhr.addEventListener('abort',this.xhrAbort);
            this.xhr.addEventListener('error',this.xhrError);
            this.xhr.send(this.data);
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
                this.setResponse(this.response);
                if(!this.isJson(this.response)){
                    throw ('O servidor não respondeu sua solicitação da forma esperada.');
                }
                var response = JSON.parse(this.response);
                this.setResponse(response);
                this.responseWork();
            }catch(e){
                console.log(e);
                this.onError(e);
            }
            Dialog.start();
            return this;
        },
        responseWork(){
            for(var r in this.response){
                switch(r){
                    case 'success':
                        if(typeof this.response[r]['message'] != 'undefined'){
                            Dialog.popUp(this.response[r]['message'],'success');
                        }
                    break;
                    case 'error':
                        if(typeof this.response[r] === "object"){
                            for(var er in this.response[r]){
                                var input = (this.form.querySelector("[name='"+this.response[r][er]['input']+"']") != null) ? this.form.querySelector("[name='"+this.response[r][er]['input']+"']") : null;
                                var message = this.response[r][er]['message'];
    
                                if(input != null){
                                    input.classList.add('error');
                                    this.form.querySelector('p[name="'+this.response[r][er]['input']+'"]').classList.add('error')
                                    this.form.querySelector('p[name="'+this.response[r][er]['input']+'"]').innerHTML = input.getAttribute('placeholder')+" "+message;
                                    this.form.querySelector('p[name="'+this.response[r][er]['input']+'"]').style.display = 'block';
                                }else{
                                    Dialog.popUp(message,'error');
                                }
                            }
                        }
                        
                        if(typeof this.response[r]['message'] != 'undefined') {
                            Dialog.popUp(this.response[r]['message'],'error');
                        }
                    break;
                    case 'reset':
                        if(document.querySelector('.submitting')!=undefined){
                            document.querySelector('.submitting').querySelectorAll('*:not([type="submit"])').forEach(function(e,i){
                                if(e.getAttribute('fixed')==undefined){
                                    e.value = '';
                                }
                            });
                            if(document.querySelector('.submitting').closest('dialog')!=undefined){
                                document.querySelector('.submitting').closest('dialog').querySelector('[close]').click();
                            }
                        }
                    break;
                    case 'close':
                        window.location.hash = '/';
                    break;
                    case 'script':
                        eval(this.response[r]);
                    break;
                }
            }
            return this;
        },
        onError(e){
            console.log(e);
            Dialog.popUp(e,'error');
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
                    document.querySelector('dialog.loading').removeAttribute('open',false);
                }
            }
            return this;
        }
	};
}();

export default Submitter;
