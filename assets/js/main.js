'use strict';

import Form from "./Form.js";
import Dialog from "./Dialog.js";
import Mask from "./Mask.js";
import Validator from "./Validator.js";
import DataTables from "./DataTables.js";

document.addEventListener('DOMContentLoaded',function(){
    Dialog.start();
    DataTables.start();
    Form.start();
    Mask.start();
    Validator.start();
});