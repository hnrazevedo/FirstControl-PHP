/*
 * © 2020 Henri Azevedo All Rights Reserved.
 */
"use strict";

import validate from "./validator.mod.js";

window.submitter = {
	form: null,
	data: null,
	xhr: null,
	response:null,
	url:null,
	work(e){
		var t = window.submitter;
		e.preventDefault();
		t.setForm(e.target);
		t.prepareData();
		t.beforeRequest();
		t.execute();
		return t;
	},
	execute(result = null){
		var t = window.submitter;
		if(window.fetch) {
			if(result){
				return t.fetchRequest();
			}else{
				var promise = t.fetchRequest();

				if (promise !== undefined) {
		            promise.then(_ => {}).catch(error => {
						console.log(error);
		            });
		        }else{
					console.log(3);
				}
			}
		}else{
			t.XMLHttpRequest();
			if(result){
				return t.getResponse();
			}
		}
		return t;
	},
	setUrl(u){
		var t = window.submitter;
		t.url = u;
		return t;
	},
	setForm(f){
		var t = window.submitter;
		t.form = f;
		t.url = t.form.getAttribute('access');
		t.hearders = {
	    	'Requested-Method': 'ajax'
	  	};
		return t;
	},
	setResponse(r){
		var t = window.submitter;
		t.response = r;
		return t;
	},
	getResponse(){
		var t = window.submitter;
		return t.response;
	},
	prepareData(){
		var t = window.submitter;
		t.data = new FormData(t.form);

		for(var at = 0; at< t.form.attributes.length; at++){
			if(t.form.attributes[at].name.substring(0,1)=='_'){
			    t.data.append(t.form.attributes[at].name,t.form.attributes[at].value);
			}
		}

		var data = JSON.stringify(Object.fromEntries(t.data));

		t.data = new FormData();
		t.data.append('data',data);
		t.data.append('provider',t.form.getAttribute('provider'));
		t.data.append('role',t.form.getAttribute('role'));

		return t;
	},
	beforeRequest(){
		var t = window.submitter;

		if(t.form.querySelector('.panel-message')!=null){
			t.form.querySelector('.panel-message').classList.remove(['error','success']);
		}

		t.form.classList.add('submitting');

		if(document.querySelector(':focus')!=undefined){
			document.querySelector(':focus').blur();
		}

		/*t.form.querySelectorAll('p.message').forEach(p => p.style.display = 'none');*/

		if(t.form.querySelectorAll('.error')!=null){
			t.form.querySelectorAll('.error').forEach(err => err.classList.remove('error'));
		}


		if(t.form.querySelectorAll('[value]:not([disabled])')!=null){
			t.form.querySelectorAll('[value]:not([disabled])').forEach(function(e,i){
				e.removeAttribute('disabled');
				e.classList.add('submitting');
			});
		}

		if(document.querySelector('dialog.loading') != null){
			document.querySelector('dialog.loading').setAttribute('open',true);
		}
		

		return t;
	},
	fetchRequest(){
		var t = window.submitter;
		return (async () => {
			const rawResponse = await fetch(t.url, {
				method: 'POST',
				headers: t.hearders,
				body: t.data
			});

			const response = await rawResponse.json();

			t.setResponse(response);

			if(typeof response == 'object'){
				t.responseWork();
			}else{
				//console.log(response);
			}

			t.requestLoadEnd();
		})();
	},
	XMLHttpRequest(){
		var t = window.submitter;
		t.xhr = new XMLHttpRequest();
		t.xhr.open( "POST", t.url , true );
		t.xhr.setRequestHeader(t.hearders);
		t.xhr.addEventListener('load',t.xhrLoad);
		t.xhr.upload.addEventListener('progress',t.xhrProgress,false);
		t.xhr.addEventListener('loadend',t.requestLoadEnd);
		t.xhr.addEventListener('abort',t.xhrAbort);
		t.xhr.addEventListener('error',t.xhrError);
		t.xhr.send(t.data);
		return t;
	},
	xhrError(e){
		var t = window.submitter;
		console.log(e);
		return t;
	},
	xhrAbort(){
		var t = window.submitter;
		console.log('Requisição cancelada pelo cliente.');
		return t;
	},
	xhrLoad(){
		var t = window.submitter;
		try{
			t.setResponse(this.response);
			if(!t.isJson(t.response)){
				throw ('O servidor não respondeu sua solicitação da forma esperada.');
			}

			var response = JSON.parse(this.response);
			t.setResponse(response);
			t.responseWork();
		}catch(e){
			console.log(e);
			t.onError(e);
		}
		window.dialog.start();
		return t;
	},
	responseWork(){
		var t = window.submitter;

		for(var r in t.response){
			switch(r){
				case 'success':
					if(typeof t.response[r]['message'] != 'undefined'){
						window.dialog.popUp(t.response[r]['message'],'success');
					}
				break;
				case 'error':

					if(typeof t.response[r] === "object"){
						for(var er in t.response[r]){
							var input = (t.form.querySelector("[name='"+t.response[r][er]['input']+"']") != null) ? t.form.querySelector("[name='"+t.response[r][er]['input']+"']") : null;
							var message = t.response[r][er]['message'];

							if(input != null){
								input.classList.add('error');
								t.form.querySelector('p[name="'+t.response[r][er]['input']+'"]').classList.add('error')
								t.form.querySelector('p[name="'+t.response[r][er]['input']+'"]').innerHTML = input.getAttribute('placeholder')+" "+message;
								t.form.querySelector('p[name="'+t.response[r][er]['input']+'"]').style.display = 'block';
							}else{
								window.dialog.popUp(message,'error');
							}
						}
					}
					
					if(typeof t.response[r]['message'] != 'undefined') {
						window.dialog.popUp(t.response[r]['message'],'error');
					}
				break;
				case 'container':
					if(typeof t.response[r]['after'] != 'undefined') t.response[r]['html'] = t.response[r]['html'] + document.querySelector(t.response[r]['_container']).innerHTML;
					if(typeof t.response[r]['before'] != 'undefined') t.response[r]['html'] = document.querySelector(t.response[r]['_container']).innerHTML + t.response[r]['html'];
					if(typeof t.response[r]['html'] != 'undefined') document.querySelector(t.response[r]['_container']).innerHTML = t.response[r]['html'];
					if(typeof t.response[r]['class'] != 'undefined') document.querySelector(t.response[r]['_container']).classList.add(t.response[r]['class']);
					if(typeof t.response[r]['rclass'] != 'undefined') document.querySelector(t.response[r]['_container']).classList.remove(t.response[r]['rclass']);
				break;
				case 'enable':
					document.querySelector(t.response[r]).classList.remove('disabled');
				break;
				case 'disable':
					document.querySelector(t.response[r]).classList.add('disabled');
				break;
				case 'reset':
					if(document.querySelector('.submitting')!=undefined){
						document.querySelector('.submitting').querySelectorAll('*:not([type="submit"])').forEach(function(e,i){
							if(e.getAttribute('fixed')==undefined){
								e.value = '';
							}
						});
						if(document.querySelector('.submitting').closest('dialog')!=undefined){
							document.querySelector('.submitting').closest('dialog').querySelector('.untarget').click();
						}
					}
				break;
				case 'close':
					window.location.hash = '/';
				break;
				case 'script':
					eval(t.response[r]);
				break;
			}
		}
		return t;
	},
	onError(e){
		console.log(e);
		var t = window.submmiter;
		window.dialog.popUp(e,'error');
		return t;
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
		var t = window.submmiter;
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
		return t;
	}
}

export default window.submitter;
