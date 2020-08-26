'use strict';

document.addEventListener('DOMContentLoaded',function(){
    (async function(){
        await (await import("./Dialog.js")).default();
        await (await import("./Submitter.js")).default(); 
        await (await import("./Form.js")).default();
        await (await import("./Mask.js")).default();
        await (await import("./DataTables.js")).default();
        await (await import("./Validator.js")).default(); 
    
        window.Form.start();
        window.Dialog.start();
        window.Mask.start();
        window.DataTables.start();

        Validator.start({
            alert : window.Dialog.popUp,
            submitter : window.Submitter.work
        });
    })();   
});