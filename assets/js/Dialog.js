"use strict";

const Dialog =  function(){
    return {
        callback:null,
        start(){

            if(document.querySelector('dialog') != null){
                document.querySelectorAll('dialog').forEach(function(d,i){

                    /* Add a link to close */
                    if(!d.classList.contains('fixed')){
                        var close = document.createElement('a');
                        close.setAttribute('close',true);
                        d.prepend(close);

                        if(d.querySelector('.heading') != null){
                            var close = document.createElement('a');
                            close.classList.add('close');
                            close.dataset.tooltip = "Fechar";
                            d.querySelector('.heading').append(close);
                            close.addEventListener('click',Dialog.closeClick);
                        }
                    }

                });
            }

            document.querySelectorAll('[close]').forEach((untarget, i) => {
                untarget.removeEventListener('click',Dialog.closeClick);
                untarget.addEventListener('click',Dialog.closeClick);
            });

            Dialog.eventsDialog();
        },
        closeClick(e){
            e.target.closest('dialog').removeAttribute('open');
        },
        popUp(m,c){
            if(document.querySelector("dialog#d_message p") == null){
                return false;
            }
            document.querySelector("dialog#d_message p").classList.remove(['sucess','error']);
            document.querySelector("dialog#d_message p").classList.add(c);
            document.querySelector("dialog#d_message p").innerHTML = m;
            document.querySelector("dialog#d_message").setAttribute('open',true);
        },
        eventsDialog(){
            /* click in element attr dialog="#refer" */
            if(document.querySelector('[dialog]') != null){
                document.querySelectorAll('[dialog]').forEach(function(dialog,i){
                    dialog.addEventListener('click',function(){
                        if(document.querySelector('dialog'+dialog.getAttribute('dialog')) != null){
                            document.querySelector('dialog'+dialog.getAttribute('dialog')).setAttribute('open','open');
                        }
                    });
                });
            }

            /* press ESC to close */
            document.addEventListener('keydown',function(e){
                if(document.querySelector('dialog[open]:not(.fixed)') != null && e.keyCode == 27){
                    document.querySelectorAll('dialog[open]:not(.fixed)').forEach(function(dialog,d){
                        dialog.removeAttribute('open');
                    });
                }
            });

            /* Close dialog loading */
            setTimeout(function(){
                if(document.querySelector('dialog.loading') != null){
                    document.querySelector('dialog.loading').removeAttribute('open');
                }
            },5000);
        },
        confirm(callback){
            Dialog.callback = callback;

            var dial = document.querySelector('dialog#d_confirm');
            dial.setAttribute('open','open');

            dial.querySelectorAll('button').forEach((button,b) => {
                button.removeEventListener('click',Dialog.testConfirm);
                button.addEventListener('click',Dialog.testConfirm);
            });

        },
        testConfirm(e){
            var value = e.target.getAttribute('id');

            if(value === 'cfm_confirm'){
                var callback = Dialog.callback;
                e.target.closest('dialog').removeAttribute('open');
                callback();
                return true;
            }

            e.target.closest('dialog').removeAttribute('open');

        }
    };
}();

document.addEventListener('DOMContentLoaded',function(){
    Dialog.start();
    window.Dialog = Dialog;
});

export default Dialog;