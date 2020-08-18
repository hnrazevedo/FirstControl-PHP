/* ========================================================================
 * Dialog JS: v0.0.1
 * 
 * Copyright (c) 2020 Henri Azevedo
 * ========================================================================
 */

"use strict";

const Dialog =  function(){
    return {
        start(){

            if(document.querySelector('dialog') != null){
                document.querySelectorAll('dialog').forEach(function(d,i){

                    /* Add a link to close */
                    var close = document.createElement('a');
                    close.setAttribute('close',true);
                    d.prepend(close);

                    /* Add div title if settabled */
                    if(d.getAttribute('title') != null){
                        var div = document.createElement('div');
                        div.classList.add('title');
                        div.innerHTML = `<h3>${d.getAttribute("title")}</h3>`;
                        d.querySelector('div').prepend(div);
                    }
                });
            }

            document.querySelectorAll('[close]').forEach((untarget, i) => {
                untarget.removeEventListener('click',this.closeClick);
                untarget.addEventListener('click',this.closeClick);
            });

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
        }
    };
}();

document.addEventListener('DOMContentLoaded',function(){
    Dialog.start();

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

});

export default Dialog;
