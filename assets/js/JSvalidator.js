"use strict";

const Validator = function(){
    return{
        $forms:[],
        $options:[],
        $started:false,
        init($options){
            Validator.options($options);
        },
        options($options){
            if($options == undefined){
                return true;
            }

            Validator.$options['alert'] = ("alert" in $options) 
                ? $options['alert'] 
                : function(m,c) {alert(m)};

            Validator.$options['return'] = ("return" in $options) 
                ? (typeof $options['return'] != 'boolean') ? false : $options['return']
                : false;

            Validator.$options['submitter'] = ("submitter" in $options) 
                ? $options['submitter'] 
                : function(evtf) {
                    if(evtf.constructor.name == 'SubmitEvent'){
                        evtf.target.submit();
                    }
                };
        },
        load(f,rules){
            if(!Validator.$started){
                Validator.init();
            }

            let id = (f.getAttribute('id') != null) ? f.getAttribute('id') : Validator.$forms.length;
            
            Validator.$forms[id] = {'form' : f, 'rules' : rules};

            Validator.$forms[id]['form'].addEventListener('submit',function(e){
                e.preventDefault();
                Validator.formSubmit(id,e);
            });
        
            if(Validator.$forms[id]['form'].querySelectorAll('input,textarea') != undefined){
                Validator.$forms[id]['form'].querySelectorAll('input,textarea').forEach(input => {
                    input.addEventListener('blur',function(e){
                        try{
                            Validator.checkInput(id,input,rules[input.getAttribute('name')]);
                            Validator.inputShowMessage(id,input,'.');
                        }catch(err){
                            Validator.inputShowMessage(id,input,err.message,'error');
                        }
                    });
                });
            }
        },
        formSubmit(id,e){
            let valid = true;
            let field = null;
            
            e = (e == null) ? Validator.$forms[id]['form'] : e;
        
            if(Validator.$forms[id]['form'].querySelectorAll('.error')!=undefined){
                Validator.$forms[id]['form'].querySelectorAll('.error').forEach(err => err.classList.remove('error'));
            }
        
            for(var rule in Validator.$forms[id]['rules']){
                field = rule.toLowerCase().replace(/(?:^|\s)\S/g, function(a) { return a.toUpperCase(); });
        
                try{
                    if(Validator.$forms[id]['form'].querySelector('[name="'+rule+'"]')!=undefined){
                        Validator.checkInput(id,Validator.$forms[id]['form'].querySelector('[name="'+rule+'"]'),Validator.$forms[id]['rules'][rule]);
                    }else{
                        valid = false;
                        Validator.inputShowMessage(id,null,`Era esperado um campo com o nome '${rule}' para está operação.`,'error');
                    }
        
                }catch(err){
                    valid = false;
                    Validator.inputShowMessage(id,Validator.$forms[id]['form'].querySelector('[name="'+field.toLowerCase()+'"]'),err.message,'error');
                }
            }
        
            if(valid){
                if(!Validator.$options.return){
                    Validator.$options.submitter(e);
                    return true;
                }
                return valid;
            }
        },  
        checkInput(id,input,rules){
            for(var rule in rules){
                let fieldText = ( input.parentNode.querySelector(`label[for="${input.getAttribute('name')}"]`) != null ) ? input.parentNode.querySelector(`label[for="${input.getAttribute('name')}"]`).innerHTML : input.getAttribute('label');
                let required = ((typeof rules['required']) === 'boolean') ? rules['required'] : false;
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
                            let clone = Validator.$forms[id]['form'].querySelector('[name="'+rules[rule]+'"]');
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

                let m = i.closest('form').querySelector('p.inputMessage[name="'+i.getAttribute('name')+'"]');
    
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

                if(t != '.'){
                    Validator.$options.alert(t,'error');
                }

                return true;
            }
            Validator.$options.alert(t,'error');
            
            Validator.$forms[id]['form'].classList.add('disabled');
            Validator.$forms[id]['form'].querySelector('.alert').classList.add('alert-danger');
            Validator.$forms[id]['form'].querySelector('.alert').innerHTML = t;
            
        }
    }
}();

window.Validator = Validator;