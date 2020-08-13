window.dialog = {
    start(){
        var t = window.dialog;

        document.querySelectorAll('dialog .title').forEach((title, i) => {
            if(title.querySelector('[close]') == null){
                title.innerHTML = title.innerHTML + '<a close href="#"></a>';
            }
        });

        document.querySelectorAll('.untarget,[close]').forEach((untarget, i) => {
            untarget.removeEventListener('click',t.closeClick);
            untarget.addEventListener('click',t.closeClick);
        });

    },
    closeClick(){
        this.closest('dialog').removeAttribute('open');
        if(this.closest('dialog').querySelector('video')!=null){
            window.player.videoplay = true;
            window.player.togglePlay();
        }
    },
    popUp(m,c){
        if(document.querySelector("#d_message p") == null){
            return false;
        }
        document.querySelector("#d_message p").classList.remove('sucess');
        document.querySelector("#d_message p").classList.remove('error');
        document.querySelector("#d_message p").innerHTML = m;
        document.querySelector("#d_message p").classList.add(c);
        document.querySelector("#d_message p").closest('dialog').setAttribute('open',true);
    }
}

window.addEventListener('load',function(){
    window.dialog.start();
    setTimeout(function(){
        if(document.querySelector('dialog.loading') != null){
            document.querySelector('dialog.loading').removeAttribute('open');
        }
    },500);


    
});

document.addEventListener('DOMContentLoaded',function(){
    document.addEventListener('keydown',function(e){
        if(document.querySelector('dialog[open]:not(.fixed)') != null && e.keyCode == 27){
            document.querySelectorAll('dialog[open]:not(.fixed)').forEach(function(dialog,d){
                dialog.removeAttribute('open');
            });
        }
    });
});

export default window.dialog;
