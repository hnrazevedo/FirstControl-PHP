'use strict';

const Mask = function() {
    return {
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
            
            el.addEventListener('keypress', function (e){
                if (e.keyCode !== 8 || e.keyCode !== 46) {   
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

                    switch (mask.charAt(i)) {
                        case '#' : 
                            if (/\d/.test(c)) {
                                value += c;
                                continue;
                            } 
                            break;
                        case 'A' : 
                            if (/[a-z]/i.test(c)) {
                                value += c;
                                continue;
                            } 
                            break;
                        case 'N' : 
                            if (/[a-z0-9]/i.test(c)) {
                                value += c;
                                continue;
                            }
                            break;

                        case 'X' : 
                            value += c;
                            continue;

                        default  : 
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

document.addEventListener('DOMContentLoaded',function(){
    Mask.start();
    window.Mask = Mask;
});

export default Mask;