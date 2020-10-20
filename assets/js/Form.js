"use strict";

const Form = function(){
    return {
        init(){
            Form.imageBurn();

            document.querySelectorAll('form.ajax').forEach((form, i) => {
                //form.setAttribute('enctype','multipart/form-data');
                var divM = document.createElement('div');
                divM.classList.add('alert','p-2','d-none','col-12');
                form.prepend(divM);

                form.addEventListener('submit',function(e){
                    e.preventDefault();
                    return false;
                });
            });

            if(document.querySelector('form button:not(.submit)') != null){
                document.querySelectorAll('form button:not(.submit)').forEach((button,b) => {
                    button.addEventListener('click',function(e){
                        e.preventDefault();
                    });
                });
            }

            document.querySelectorAll('form input, form textarea, form select:not(.dataTable)').forEach((input, i) => {
                if(input.getAttribute('inid') == null){

                    if(typeof input.getAttribute('value') != "string"){
                        input.setAttribute('value','');
                    }
    
                    for(var at = 0; at < input.attributes.length; at++){
    
                        switch (input.attributes[at].name) {
    
                            case 'label':
                                var c = (typeof input.getAttribute('label-class') !== 'undefined') ? input.getAttribute('label-class') : null;
                                var label = document.createElement('label');
                                label.setAttribute('for',input.getAttribute('name'));
                                label.classList.add(c);
                                label.innerHTML = input.getAttribute('label');
                                input.after(label);
    
                                var p = document.createElement('p');
                                p.setAttribute('name',input.getAttribute('name'));
                                p.classList.add('message','inputMessage');
                                input.nextSibling.after(p);
                                break;
                            case 'maxlength':
                                if(input.getAttribute('type') === 'text' || input.getAttribute('type') === 'password' || input.getAttribute('type')==='textarea'){
                                    if(typeof input.getAttribute('maxlength') !== 'undefined'){           
                                        var length = document.createElement('length');
                                        length.setAttribute('name',input.getAttribute('name'));
                                        length.innerHTML = '<current>0</current> / <max>'+input.getAttribute('maxlength')+'</max>';
                                        input.nextSibling.after(length);
                                        input.classList.add('length');
                                    }else{
                                        var length = document.createElement('length');
                                        var p = document.createElement('p');
                                        p.setAttribute('name',input.getAttribute('name'));
                                        p.classList.add('message','inputMessage');
                                        length.style.opacity = 0;
                                        input.nextSibling.after(length);
                                        input.nextSibling.after(p);
                                    }
                                }
                                break;
                            case 'type':
                                switch (input.attributes[at].value) {
                                    case 'checkbox':
                                        var length = document.createElement('length');
                                        input.nextSibling.after(length);
                                        var p = document.createElement('p');
                                        p.setAttribute('name',input.getAttribute('name'));
                                        //p.classList.add('message');
                                        input.nextSibling.after(p);
                                        break;
                                }
                                break;
                        }
                    }
                    input.setAttribute('inid',true);
                }
            });

            document.querySelectorAll('select[name]:not(.dataTable)').forEach((select, s) => {
                if(select.nextSibling == null){
                    return true;
                }
                select.querySelector('[value="'+select.getAttribute('value')+'"]').setAttribute('selected',true);
            });

            Form.eventInputs();

        },
        imageBurn(){
            setTimeout(function(){
                function IsImageOk(img) {
                    if (!img.complete) return false;
                    if (typeof img.naturalWidth != "undefined" && img.naturalWidth == 0) return false;
                    return true;
                }
    
                for (var i = 0; i < document.images.length; i++) {
                    if (!IsImageOk(document.images[i])) {
                        document.images[i].setAttribute('data-src',document.images[i].getAttribute('src'));
                        document.images[i].setAttribute('src','/assets/img/icon.placeholder.svg');
                        document.images[i].classList.add('notfound');
                    }
                }
            },500);
        },
        eventInputs(){
            var t = Form;
    
            document.querySelectorAll('select[name]:not(.dataTable)').forEach((select, i) => {
                select.addEventListener('change',t.selectChange);
                select.addEventListener('focus',t.selectFocus);
                select.addEventListener('click',t.selectFocus);
            });
    
            document.querySelectorAll('[select-value]').forEach((option, i) => {
                option.addEventListener('click',t.selectDataClick);
            });
    
            document.querySelectorAll('input:not([type="checkbox"]), textarea').forEach((input, i) => {
                input.addEventListener('blur',t.inputBlur);
                input.addEventListener('keypress',t.inputKeyUp);
                input.addEventListener('keyup',t.inputKeyUp);
            });

            document.querySelectorAll('input[type="file"]').forEach((input, i) => {
                input.addEventListener('change',t.inputChange);
            });

            document.querySelectorAll('input[preview]').forEach((input, i) => {
                input.addEventListener('change',t.inputPreview);
            });
    
            document.addEventListener('click',t.unFocus);
            window.addEventListener('hashchange', t.windowHistory);
            window.addEventListener('load',t.windowHistory);
            setTimeout(t.windowHistory,500);
    
        },
        inputPreview(e){
            let input = this;

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    document.querySelector('#'+input.getAttribute('preview')).setAttribute('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        },
        windowHistory(){
            window.history.pushState("Object", "",(window.location.href).split('#')[0]);
        },
        inputChange(e){
            if(e.target.files.length === 1){
                e.target.setAttribute('textDefault',e.target.getAttribute('text'));
                e.target.setAttribute('text',e.target.files[0]['name']);
                e.target.classList.add("select");
            }else{
                e.target.setAttribute('text',e.target.getAttribute('textDefault'));
                e.target.classList.remove("select");
            }
            
        },
        unFocus(e){
            if(e.target.closest('.select-data.focus') == null && e.target.tagName != 'SELECT' && e.target.querySelector('.select-data') != null){
                document.querySelectorAll('.select-data.focus').forEach((item, i) => {
                    item.style.display = 'none';
                    item.classList.remove('focus');
                    item.closest('form').querySelector('select#'+item.getAttribute('select-id')).style.opacity = 1;
                });
            }
        },
        selectChange(){
            this.setAttribute('value',this.value);
        },
        selectFocus(){
            var data = this.nextSibling.nextSibling;
            if(data.offsetParent == null){
                this.classList.add('focus');
                this.parentNode.style.paddingBottom = 'calc('+this.parentNode.style.paddingBottom+' + 2.2em)';
                this.parentNode.querySelector('.focus').style.opacity = 0;
                data.style.display = 'block';
                data.style.opacity = '1';
                data.style.width = data.parentNode.offsetWidth;
                data.style.left = 0;
                data.style.top = data.parentNode.style.paddingTop;
                setTimeout(function(){
                    data.classList.add('focus');
                    data.setAttribute('tabindex','-1');
                    data.focus();
                },200);
            }
        },
        selectDataClick(){
            var select = this.closest('form').querySelector('select#'+this.getAttribute('select-id'));
            select.value = this.getAttribute('select-value');
            select.setAttribute('value',this.getAttribute('select-value'));
            select.classList.remove('focus');
            select.style.opacity = 1;
            this.closest('.select-data').style.display = 'none';
            this.closest('.select-data').classList.remove('focus');
        },
        inputBlur(){
            this.setAttribute('value',this.value);
        },
        inputKeyUp(){
            if(document.querySelector('length[name="'+this.getAttribute('name')+'"] current') != null){
                document.querySelector('length[name="'+this.getAttribute('name')+'"] current').innerHTML = this.value.length;
                document.querySelector('length[name="'+this.getAttribute('name')+'"] max').innerHTML = this.getAttribute('maxlength');
            }
    
            if(this.value.length<=parseInt(this.getAttribute('_maxlength'))){
                if(typeof this.getAttribute('_mask')!=='undefined'){
                    if(typeof $ == 'function'){
                        $(this).mask(this.getAttribute('mask'));
                    }
    
                }
            }
        }

    };
}();
