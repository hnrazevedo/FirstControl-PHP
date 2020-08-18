'use strict';
var Mask = function() {
    return {
        format : function(element) {            
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
                var text = '';
                var data = el.value;
                var c, m, i, x;

                for (i = 0, x = 1; x && i < mask.length; ++i) {
                    c = data.charAt(i);
                    m = mask.charAt(i);

                    switch (mask.charAt(i)) {
                        case '#' : 
                            if (/\d/.test(c)) {
                                text += c;
                            } else {
                                x = 0;
                            } 
                            break;

                        case 'A' : 
                            if (/[a-z]/i.test(c)) {
                                text += c;
                            } else {
                                x = 0;

                            } 
                            break;

                        case 'N' : 
                            if (/[a-z0-9]/i.test(c)) {
                                text += c;
                            } else {
                                x = 0;
                            } 
                            break;

                        case 'X' : 
                            text += c; 
                            break;

                        default  : 
                            text += m; 
                            break;
                    }
                }
                el.value = text;                
            }
        }
    };
}();


document.addEventListener('DOMContentLoaded',function(){
    if(document.querySelector('[data-mask]') != null){
        document.querySelectorAll('[data-mask]').forEach(function(input,i){
            Mask.format('[data-mask="'+input.dataset.mask+'"]');
        });
    }
});