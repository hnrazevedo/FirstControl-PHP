'use strict';

const Mask = function() {
    return {
        masks:{
            '#':'\\d',
            'A':'[A-Z]',
            'a':'[a-z]',
            'S':'[a-zA-Z]',
            'X':'[0-9a-zA-Z]'
        },
        start(){
            if(document.querySelector('[data-mask]') != null){
                document.querySelectorAll('[data-mask]').forEach(function(input,i){
                    Mask.format('[data-mask="'+input.dataset.mask+'"]');
                });
            }
        },
        format(element) {            
            var el = document.querySelector(element);
            var maskForm = '';
            
            maskForm = el.dataset.mask;
            el.maxLength = maskForm.length;
            
            el.addEventListener('keyup', function (e){
                if (e.keyCode !== 8 && e.keyCode !== 46) { 
                    costume(maskForm);
                }
            });
            
            function costume(mask) {
                var value = '';
                var data = el.value;
                var c, m, i, x;

                for (i = 0, x = 1; x && i < mask.length; ++i) {
                    c = data.charAt(i);
                    m = mask.charAt(i);

                    if(Mask.masks[m] != undefined){
                        if((new RegExp(Mask.masks[m])).test(c)){
                            value += c;
                            continue;
                        }
                    }else{
                        value += m;
                        continue;
                    }
                    x = 0;
                }
                el.value = value;                
            }
            
        }
    };
}();

if (/complete|interactive|loaded/.test(document.readyState)) {
    Mask.start();
}