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

        document.querySelectorAll('form[_aim]').forEach((form, i) => {
            form.setAttribute('method','POST');
            form.setAttribute('enctype','multipart/form-data');
            var divM = document.createElement('div');
            divM.classList.add('panel-message');
            form.prepend(divM);
        });

        document.querySelectorAll('input,textarea,select').forEach((input, i) => {
            if(input.getAttribute('inid')==null){
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
                            p.classList.add('message','none');
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
                                    p.classList.add('message','none');
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
                                    p.classList.add('message','none');
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
        /*$(document).on('keypress','input',function(){
            if(this.value.length==parseInt(this.getAttribute('_maxlength'))){


                if(typeof this.getAttribute('_mask')!=='undefined'){
                    if(typeof $ == 'function'){
                        $(this).mask(this.getAttribute('_mask'));
                    }
                }



            }
        });*/
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


/*



 $(document).ready(function(){

     if($('.pop-up').length===0){
         $('body').append('<div class="pop-up"><div class="dialog" id="dialog" src="/path/static.dialog"></div></div>');
     }

     //Stop redirection on upload file from drop
     $("html").on("drop", function(e) { e.preventDefault(); e.stopPropagation(); });
     $(document).on('drop',function(){ e.stopPropagation(); e.preventDefault(); });
     $(document).on('dragenter',function(e){ e.stopPropagation(); e.preventDefault(); });
     $(document).on('dragover',function(e){ e.stopPropagation(); e.preventDefault(); });


     $(document).on('click','[data-toggle]',function(){
         $(document).find('.'+$(this)[0].dataset.toggle).slideToggle();
     });

     $('.drop_upload').on('drop', function (e) {
        e.stopPropagation();
        e.preventDefault();

        var filename = e.originalEvent.dataTransfer.files[0]['name'];
        extensao = (filename.substring(filename.lastIndexOf("."))).toLowerCase();

        var extensoes = ($(this).find('.drop').attr('accept')).split(',');

        if($.inArray(extensao,extensoes) > -1){
            $(this).find('.drop').prop('files',e.originalEvent.dataTransfer.files);
            $(this).parents('section').find('.file_name').css('margin-left','0').html('Arquivo selecionado: '+e.originalEvent.dataTransfer.files[0]['name']);

            if($(this).find('.drop').hasClass('submit')){
                $(this).parents('form').submit();
            }

        }else{
            $(this).parents('section').find('.file_name').css('margin-left','2em').html('<img src="http://localhost:8000/assets/img/erro.svg" class="error_extension"> Extensão de arquivo não suportada. <a href="#!">Saiba mais</a>');
        }
        uploadVideo(e.originalEvent.dataTransfer.files);

    });


     //Close div pop on click left content
     $(document).on('click','div.pop-up',function(e){
         if(e.target.getAttribute('class')=='pop-up')
            pop_up();
     });
     $(document).on('keyup','body',function(e){
         if(e.key=='Escape')
            pop_up();
     });

     //Menu list
     $(document).on('click','.menu-list-a',function(){
         is = $(this).prop('checked');
         $('.menu-list-a').prop('checked',is);
         if(is){
             $('.painel-left').addClass('active');
         }else{
              $('.painel-left').removeClass('active');
              $('.painel-left').find('ul.sublist:visible').slideToggle('fast').prev().removeClass('active');
         }
     });

     $(document).on('click','a.list-a',function(){
         $(this).find('input').trigger('click');
     });



     $(document).on('click','a.sublist',function(){

       if(!$('.menu-list-a').prop('checked')){
           $('.menu-list-a').prop('checked','checked').trigger('click');
       }
       $(this).removeClass('active').parent().parent().find('ul.sublist:visible').stop().slideToggle('fast');
       $(this).removeClass('active').parent().parent().find('a.sublist.active').removeClass('active');
       if($(this).next().css('display')!=='block')
            $(this).addClass('active').next().stop().slideToggle();


     });

    // Set input value to attr value






    $(document).on('blur','div.select-data.focus',function(){
        $('div.select-data.focus').animate(
            {'opacity':'0'},
            300,
            function(){
                $(this).css('display','none').removeClass('focus');
            }
        )
        .prev().prev()
        .css('display','block')
        .parent().css('padding-bottom','');
    });

    $(document).on('click','body',function(e){
        if($('div.select-data.focus').length>0){
           if(!$(e.target).hasClass('select-data') && !$(e.target).hasClass('select_data') && !$(e.target).hasClass('sel'))
                $('div.select-data.focus').animate(
                    {'opacity':'0'},
                    300,
                    function(){
                        $(this).css('display','none').removeClass('focus');
                    }
                )
                .prev().prev()
                .css('display','block')
                .parent().css('padding-bottom','');
        }
    });


    //Set mask to input from mask attr

    //Set alternat mask to input from mask attr



    //Close sublist on a link clicked
    //$(document).on('click','ul.sub a',function(){
    //    $(this).parents('ul.sub').parent().find('input[type="checkbox"]').prop('checked',false);
    //});

    $(document).on('click','.show a',function(){
        $(this).parents('.show').animate({'opacity':'0'},200,function(){$(this).css('display','none');});
        $(document).find('[show="'+$(this).parents('.show').attr('id')+'"]').removeClass('open');
    });

    function readURL(input,e,type) {

        if (input.files && input.files[0]) {

            if(input.files[0].size > (parseInt($(input).attr('limit_size')) * 1024 * 1024)) {
                popUpDialog('Arquivo selecionado excede o tamanho máximo permitido.','error');
                e.preventDefault();
            }else{
                if(type=='image'){
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('.'+$(input).attr('name')+'_prev').find('img').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
                $(input).next('label').html($(input).val().split("\\").pop());
            }
        }
    }

    //Imagem file select
    $(document).on('change','input[type="file"]',function(e){
        if(e.originalEvent.target.files[0] != undefined){
          $(this).parents('section').find('.file_name').css('margin-left','2em').html('Arquivo selecionado: '+e.originalEvent.target.files[0]['name']);
        }
        //readURL(this,e,typeof $(this).attr('img'));
    });


    $(document).on('click','a[minimize]',function(){
        container = $(document).find('section#'+$(this).attr('minimize')).find('.container_').slideToggle(500);
    });






    $(document).on('click','[show]',function(){
        var show = $('#'+$(this).attr('show'));
        if($(this).hasClass('open')){
            show.animate({'opacity':'0'},200,function(){$(this).css('display','none');});
            $(this).removeClass('open');
        }else{
            $('.show:visible').animate({'opacity':'0'},200,function(){$(this).css('display','none');});

            $('.open').removeClass('open');
            var t = $(this);
            setTimeout(function(){
                t.addClass('open');

                show.css({'display':'block'}).animate({'opacity':'1'},200);
                leftThis = parseInt(t.offset().left);
                topThis = parseInt(t.offset().top);
                widthBody = parseInt($('body').css('width').replace('px',''));
                widthMe = parseInt(show.css('width').replace('px',''));

                if( (widthMe+leftThis) <= widthBody ){
                    show.css({'left':leftThis-8+'px','top':topThis+35+'px'});
                }else{
                    show.css({'left':'unset','top':topThis+35+'px'});
                }
            },300);

        }
    });

    //window.history.pushState("Object", "", e.originalEvent.oldURL);



    //Add div.temp in body
    $('body').append('<div class="temp"></div>');



    $(document).on('click','input[type="radio"] ~ label',function(){
        $(this).prev().prop('checked', true);
        $(this).parent().parent().find('label.active').removeClass('active');
        $(this).addClass('active');

        container = $(this).parent().parent().attr('container_id');
        tab = $(this).parent().attr('tab');

        $('#'+container+' > li.active').removeClass('active');
        $('#'+container+' > li[tab-container="'+tab+'"]').addClass('active');
    });

    //checkbox to close pop-up's
    $(document).on('click','button.close',function(){
        pop_up();
    });

    //Event dispared from a or button to show pop-up
    $(document).on('click','.pop',function(){
        pop_up($(this).attr('pop-up'));
    });

    //blocke submit from tag button
    $(document).on('click','button',function(e){
        e.preventDefault();
    });
    //Input type file
    $(document).on('change','.submit',function(){
        var $form = $(this).closest('form');
        $form.submit();
    });
    $(document).on('click','a.submit',function(){
        var form = $('form#'+$(this).attr('form'));
        form.find($(this).attr('field')).val($(this).attr('value'));
        form.submit();
    });

    $(document).on('keydown',function(e){
        if(e.key == 'Escape' && $('div.pop-up div.container:visible').length > 0){
            pop_up();
        }
    });

    //Automatic cep search
    $(document).on('blur','#cep',function(){
        var cep = $(this).val().replace(/\D/g, '');
        var validacep = /^[0-9]{8}$/;
        if(validacep.test(cep)) {
            $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
                if (!("erro" in dados)) {
                    $("[name='logradouro']").val(dados.logradouro).attr('value',dados.logradouro);
                    $("[name='bairro']").val(dados.bairro).attr('value',dados.bairro);
                    $("[name='municipio']").val(dados.localidade).attr('value',dados.localidade);
                    $("[name='uf']").val(dados.uf).attr('value',dados.uf);
                    $("[name='ibg']").val(dados.ibge).attr('value',dados.ibge);
                } else {
                    popUpDialog('CEP inválido.','error');
                }
            });
        }
    });

    $(document).on('blur','[id="cep_do_usuario"]',function(){
        var cep = $(this).val().replace(/\D/g, '');
        var validacep = /^[0-9]{8}$/;
        if(validacep.test(cep)) {
            $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
                if (!("erro" in dados)) {
                    $("[name='logradouro_do_usuario']").val(dados.logradouro).attr('value',dados.logradouro);
                    $("[name='bairro_do_usuario']").val(dados.bairro).attr('value',dados.bairro);
                    $("[name='municipio_do_usuario']").val(dados.localidade).attr('value',dados.localidade);
                    $("[name='uf_do_usuario']").val(dados.uf).attr('value',dados.uf);
                    $("[name='ibg_do_usuario']").val(dados.ibge).attr('value',dados.ibge);
                } else {
                    popUpDialog('CEP inválido.','error');
                }
            });
        }
    });

    //close dialog



    // Input initial
    initialize_fields();
});

//Pop-up function, show and hide
function pop_up(container = null){
    $(document).ready(function(){
        $('.dialog_on').removeClass('dialog_on');
        if(container == null){
            container = $('div.pop-up .container:visible').parent();
            container.animate({opacity:'0'},500,
                function(){
                    container.css({'display':'none'});
                    $('div.pop-up').animate({opacity:'0'},500,function(){$('div.pop-up').hide();}
                );
            });
        }else{
            container = $('#'+container);
            container.find('.container').css({'display':'block','opacity':'1'});
            container.css({'display':'block'});
            $('div.pop-up').css({'display':'flex'}).animate({opacity:'1'},500);
            container.animate({opacity:'1'},500);
        }
    });
}






}
*/
