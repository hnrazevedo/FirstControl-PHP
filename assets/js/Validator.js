/* ========================================================================
 * Validator JS: v0.0.1
 * 
 * Copyright (c) 2020 Henri Azevedo
 * ========================================================================
 */

import Submitter from "./Submitter.js";

"use strict";

const Validate = function(f,options){
    
    f.addEventListener('submit',function(e){
        e.preventDefault();

        var valid = true;
        var field = null;

        if(f.querySelectorAll('.error')!=undefined){
            f.querySelectorAll('.error').forEach(err => err.classList.remove('error'));
        }

        for(var opt in options){
            field = opt.toLowerCase().replace(/(?:^|\s)\S/g, function(a) { return a.toUpperCase(); });

            try{

                if(f.querySelector('[name="'+opt+'"]')!=undefined){
                    checkInput(f,f.querySelector('[name="'+opt+'"]'),options[opt]);
                }else{
                    valid = false;
                    inputShowMessage(null,`Era esperado um campo com o nome '${opt}' para está operação.`,'error');
                }

            }catch(err){
                valid = false;
                inputShowMessage(f.querySelector('[name="'+field.toLowerCase()+'"]'),err.message,'error');
            }
        }

        if(valid){
            Submitter.work(e);
        }
    });

    if(f.querySelectorAll('input,textarea')!=undefined){
        f.querySelectorAll('input,textarea').forEach(input => input.addEventListener('blur',function(e){
            try{
                checkInput(f,input,options[input.getAttribute('name')]);
                inputShowMessage(input,'.');
            }catch(err){
                inputShowMessage(input,err.message,'error');
            }
        }));
    }

    function inputShowMessage(i, t, c = null){

        if(i != null){
            var m = i.closest('form').querySelector('p[name="'+i.getAttribute('name')+'"]');

            if(m != null){
    
                m.innerHTML = t;
                
                if(c==null){
                    i.classList.remove('error','success');
                    m.classList.remove('error','success');
                }else{
                    m.classList.add(c);
                    i.classList.add(c);
                }

            }
            return true;
        }
        
        f.classList.add('disabled');
        f.querySelector('.panel-message').classList.add('error');
        f.querySelector('.panel-message').innerHTML = t;
        
    }

    function checkInput(f,input,rules){
        for(var rule in rules){
            var fieldText = input.nextSibling.innerHTML;
            fieldText = (fieldText===undefined || fieldText.trim().length == 0 ) ? input.getAttribute('placeholder') : fieldText;
            var required = ((typeof rules['required']) === 'boolean') ? rules['required'] : false;

            switch(rule){
                case 'required':
                    if(required && input.value.length===0){
                        throw new Error(fieldText+' é obrigatório.');
                    } 
                    break;
                  
                case 'minlength':
                    if(required || input.value.length>0){
                        if(input.value.length<rules[rule]){
                            throw new Error(fieldText+' deve ter no mínimo '+rules[rule]+' caracteres.');
                        }
                    }
                    break;

                case 'maxlength':
                    if(required || input.value.length>0){
                        if(input.value.length>rules[rule]){
                            throw new Error(fieldText+' deve ter no máximo '+rules[rule]+' caracteres.');
                        }
                    }
                    break;

                case 'regex':
                    if(required || input.value.length>0){
                        if(!(new RegExp(rules[rule])).test(input.value)){
                            throw new Error(fieldText+' inválido(a).');
                        }
                    }
                    break;

                case 'equals':
                    if(required || input.value.length>0){
                        var clone = f.querySelector('[name="'+rules[rule]+'"]');
                        if(input.value!==clone.value){
                            throw new Error(fieldText+' está diferente de '+clone.nextSibling.innerHTML+'.');
                        }
                    }
                    break;
            }
        }
    }
}

document.addEventListener('DOMContentLoaded',function(e){
    if(document.querySelectorAll('form[provider]')!=undefined){
        document.querySelectorAll('form[provider]').forEach(function(f,i){

            var data = new FormData();
            data.processData = false;
            data.append('provider',f.getAttribute('provider'));
            data.append('role',f.getAttribute('role'));

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
                            f.classList.add('disabled');
                            f.querySelector('.panel-message').classList.add('error');
                            f.querySelector('.panel-message').innerHTML = response[r]['message'];
                            break;
                    }
                }
            }
        });
    }
});

export default Validate;
