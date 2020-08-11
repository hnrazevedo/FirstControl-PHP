/*
 * © 2020 Henri Azevedo All Rights Reserved.
 */
"use strict";

const validate = function(f,options){
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
                }
            }catch(err){
                valid = false;
                inputShowMessage(f.querySelector('[name="'+field.toLowerCase()+'"]'),err.message,'error');
            }
        }

        if(valid){
            submitter.work(e);
        }
    });

    if(f.querySelectorAll('input:not([type="submit"]),textarea')!=undefined){
        f.querySelectorAll('input:not([type="submit"]),textarea').forEach(input => input.addEventListener('blur',function(e){
            input.classList.remove('error');
            try{
                checkInput(f,input,options[input.getAttribute('name')]);
                inputShowMessage(input,'');
                input.style.marginBottom = '';
            }catch(err){
                inputShowMessage(input,err.message,'error');
            }
        }));
    }

    function inputShowMessage(input,text,c=null){
        var message = input.closest('form').querySelector('p[name="'+input.getAttribute('name')+'"]');
        if(message != null){
            message.innerHTML = text;
            input.classList.add(c);
            input.style.marginBottom = message.offsetHeight + 2;
            (c==null) ? message.classList.remove(['error','success']) : message.classList.add(c);
        }
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
                    if(input.value.length<rules[rule])
                        throw new Error(fieldText+' deve ter no mínimo '+rules[rule]+' caracteres.');
                  }
                  break;
                case 'maxlength':
                  if(required || input.value.length>0){
                    if(input.value.length>rules[rule])
                        throw new Error(fieldText+' deve ter no mínimo '+rules[rule]['minlength']+' e no máximo '+value+' caracteres.');
                  }
                  break;
                case 'regex':
                  if(required || input.value.length>0){
                    if(!(new RegExp(rules[rule])).test(input.value)){
                        console.log(input.value);
                        console.log(rules[rule]);
                        throw new Error(fieldText+' inválido(a).');
                    }
                  }
                break;
                case 'equals':
                  if(required || input.value.length>0){
                    var clone = f.querySelector('[name="'+rules[rule]+'"]');
                    if(input.value!==clone.value)
                        throw new Error(fieldText+' está diferente de '+clone.nextSibling.innerHTML+'.');
                  }
                  break;
            }
        }
    }
}

document.addEventListener('DOMContentLoaded',function(e){
    if(document.querySelectorAll('form')!=undefined){
        document.querySelectorAll('form[_provider]').forEach(function(f,i){

            var data = new FormData();
            data.processData = false;
            data.append('provider',f.getAttribute('_provider'));
            data.append('role',f.getAttribute('_role'));

            if(self.fetch) {
                (async () => {
                    const rawResponse = await fetch('/validator', {
                        method: 'POST',
                        //headers: {
                        //  'X-Requested-With': 'XMLHttpRequest'
                        //},
                        body: data
                      });
                      const response = await rawResponse.json();
                      if(typeof response == 'object'){
                          formWork(response);
                      }else{
                          console.log(response);
                      }
                })();
            } else {
                var xhr = new XMLHttpRequest();
                xhr.open( "POST", '/validator' , true );
                //xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");

                xhr.addEventListener('load',function(e){
                    if(isJson(xhr.response)){
                        response = JSON.parse(String(xhr.response));
                        formWork(response);
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
                            f.innerHTML = '<div class="panel-message error" style="display:block">'+response[r]+'</div>' + f.innerHTML;
                            break;
                    }
                }
            }
        });
    }
});

export default validate;
