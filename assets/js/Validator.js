"use strict";

const Validator = function(){
    return{
        forms:[],
        rules:[],
        options:[],
        start(options){
            Validator.setOptions(options);

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
        },
        setOptions(options){
            Validator.options['alert'] = ("alert" in options) 
                ? options['alert'] 
                : function(m,c) {alert(m)};

            Validator.options['submitter'] = ("submitter" in options) 
                ? options['submitter'] 
                : function(form) {
                    if(form.constructor.name == 'SubmitEvent'){
                        form.target.submit();
                    }
                };

        },
        needValidate(f,rules){
            var id = `${f.getAttribute('provider')}.${f.getAttribute('role')}`;

            Validator.forms[id] = {'form' : f, 'rules' : rules};

            Validator.forms[id]['form'].addEventListener('submit',function(e){
                e.preventDefault();
                Validator.formSubmit(id,e);
            });
        
            if(Validator.forms[id]['form'].querySelectorAll('input,textarea')!=undefined){
                Validator.forms[id]['form'].querySelectorAll('input,textarea').forEach(input => input.addEventListener('blur',function(e){
                    try{
                        Validator.checkInput(id,input,rules[input.getAttribute('name')]);
                        Validator.inputShowMessage(id,input,'.');
                    }catch(err){
                        Validator.inputShowMessage(id,input,err.message,'error');
                    }
                }));
            }
        },
        formSubmit(id,e){
            var valid = true;
            var field = null;
            
            e = (e == null) ? Validator.forms[id]['form'] : e;
        
            if(Validator.forms[id]['form'].querySelectorAll('.error')!=undefined){
                Validator.forms[id]['form'].querySelectorAll('.error').forEach(err => err.classList.remove('error'));
            }
        
            for(var rule in Validator.forms[id]['rules']){
                field = rule.toLowerCase().replace(/(?:^|\s)\S/g, function(a) { return a.toUpperCase(); });
        
                try{
                    if(Validator.forms[id]['form'].querySelector('[name="'+rule+'"]')!=undefined){
                        Validator.checkInput(id,Validator.forms[id]['form'].querySelector('[name="'+rule+'"]'),Validator.forms[id]['rules'][rule]);
                    }else{
                        valid = false;
                        Validator.inputShowMessage(id,null,`Era esperado um campo com o nome '${rule}' para está operação.`,'error');
                    }
        
                }catch(err){
                    valid = false;
                    Validator.inputShowMessage(id,Validator.forms[id]['form'].querySelector('[name="'+field.toLowerCase()+'"]'),err.message,'error');
                }
            }
        
            if(valid){
                Validator.options.submitter(e);
            }
        },  
        checkInput(id,input,rules){
            for(var rule in rules){
                var fieldText = ( input.parentNode.querySelector(`label[for="${input.getAttribute('name')}"]`) != null ) ? input.parentNode.querySelector(`label[for="${input.getAttribute('name')}"]`).innerHTML : input.getAttribute('label');
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
                            var clone = Validator.forms[id]['form'].querySelector('[name="'+rules[rule]+'"]');
                            if(input.value!==clone.value){
                                throw new Error(fieldText+' está diferente de '+clone.nextSibling.innerHTML+'.');
                            }
                        }
                        break;
                }
            }
        },
        inputShowMessage(id,i, t, c = null){

            if(i != null){

                var m = i.closest('form').querySelector('p[name="'+i.getAttribute('name')+'"]');
    
                if(m != null){
        
                    m.innerHTML = t;
                    
                    if(c==null){
                        i.classList.remove('error','success');
                        m.classList.remove('error','success');
                        return true;
                    }

                    m.classList.add(c);
                    i.classList.add(c);

                    return true;
                }
                
                console.log(1);
                Validator.options.alert(t,'error');
                return true;
            }
            Validator.options.alert(t,'error');
            
            Validator.forms[id]['form'].classList.add('disabled');
            Validator.forms[id]['form'].querySelector('.panel-message').classList.add('error');
            Validator.forms[id]['form'].querySelector('.panel-message').innerHTML = t;
            
        }
    }
}();

export default async function(){
    window.Validator = Validator;
    return Validator;
}