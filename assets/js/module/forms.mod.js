"use strict";

import Dialog from "./dialog.mod.js";
import Submmiter from "./submitter.mod.js";
import "./imask.js";

document.addEventListener('DOMContentLoaded',function(){

    document.querySelectorAll('form').forEach((form, i) => {
        form.addEventListener('submit',function(e){
            e.preventDefault();
            return false;
        });
    });

});

window.forms = {
    start(){
        var t = window.forms;
        t.imageBurn();

        document.querySelectorAll('form[provider]').forEach((form, i) => {
            form.setAttribute('method','POST');
            form.setAttribute('enctype','multipart/form-data');
            var divM = document.createElement('div');
            divM.classList.add('panel-message');
            form.prepend(divM);
        });

        document.querySelectorAll('form input, form textarea, form select').forEach((input, i) => {

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
                            p.classList.add('message');
                            input.nextSibling.after(p);
                            break;
                        case 'maskMoney':
                            //input.maskMoney({thousands:'.', decimal:',', prefix: 'R$ '});
                            break;
                        case 'mask':
                            //input.mask(input.getAttribute('mask'));
                            input.setAttribute('_maxlength',input.getAttribute('mask').length);
                            break;
                        case 'maxlength':
                            if(input.getAttribute('type') === 'text' || input.getAttribute('type') === 'password' || input.getAttribute('type')==='textarea'){
                                if(typeof input.getAttribute('maxlength') !== 'undefined'){           
                                    var length = document.createElement('length');
                                    length.setAttribute('name',input.getAttribute('name'));
                                    length.innerHTML = '<current>0</current> / <max>'+input.getAttribute('maxlength')+'</max>';
                                    input.nextSibling.after(length);
                                   
                                }else{
                                    var length = document.createElement('length');
                                    var p = document.createElement('p');
                                    p.setAttribute('name',input.getAttribute('name'));
                                    p.classList.add('message');
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
                                    p.classList.add('message');
                                    input.nextSibling.after(p);
                                    break;
                            }
                            break;
                    }
                }
                input.setAttribute('inid',true);
            }
        });

        document.querySelectorAll('select[name]').forEach((select, s) => {
            if(select.nextSibling == null){
                return true;
            }

            var div = document.createElement('div');
            div.classList.add('select-data');
            div.innerHTML = '<ul></ul>';
            div.setAttribute('select-id',select.getAttribute('id'));

            select.nextSibling.after(div);
            select.getAttribute('id', ((typeof select.getAttribute('id')) == 'undefined') ? select.getAttribute('name') : select.getAttribute('id'));
            var ul = select.nextSibling.nextSibling.querySelector('ul');

            select.querySelector('[value="'+select.getAttribute('value')+'"]').setAttribute('selected',true);

            select.querySelectorAll('option').forEach((option, o) => {
                ul.innerHTML = ul.innerHTML + '<li><a class="select_data" select-value="'+option.getAttribute('value')+'" select-id="'+select.getAttribute('id')+'">'+option.innerHTML+'</a></li>';
            });
        });

        window.forms.eventInputs();
    },
    eventInputs(){
        var t = window.forms;

        document.querySelectorAll('select[name]').forEach((select, i) => {
            select.addEventListener('change',t.selectChange);
            select.addEventListener('focus',t.selectFocus);
            select.addEventListener('click',t.selectFocus);
        });

        document.querySelectorAll('[select-value]').forEach((option, i) => {
            option.addEventListener('click',t.selectDataClick);
        });

        document.querySelectorAll('input:not([type="checkbox"])','textarea').forEach((input, i) => {
            input.addEventListener('blur',t.inputBlur);
            input.addEventListener('keypress',t.inputKeyPress);
            input.addEventListener('keypress',t.inputKeyUp);
            input.addEventListener('keyup',t.inputKeyUp);
        });

        document.addEventListener('click',t.unFocus);
        window.addEventListener('hashchange', t.windowHistory);
        window.addEventListener('load',t.windowHistory);
        setTimeout(t.windowHistory,500);

    },
    windowHistory(){
        window.history.pushState("Object", "",(window.location.href).split('#')[0]);
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
    inputKeyPress(){
        
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
                    document.images[i].setAttribute('src','/assets/img/placeholder_images.svg');
                    document.images[i].classList.add('notfound');
                }
            }
        },500);
    }
}

window.addEventListener('load',function(){
    forms.start();
});