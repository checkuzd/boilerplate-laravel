import './assets/config';
import './assets/layout';
import './assets/main';

import Swal from 'sweetalert2'
import axios from 'axios';
import jQuery from 'jquery';
import * as bootstrap from 'bootstrap';
import select2 from 'select2';
import SimpleBar from 'simplebar';
import * as MainJs from './assets/main';
import * as MenuScs from "./assets/menu";

// Register the plugin
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.$ = jQuery;
window.Swal = Swal;
window.bootstrap = bootstrap;
window.select2 = select2($);
window.MainJs = MainJs;
window.MenuScs = MenuScs;
window.addEventListener('load', function () {
    console.log('All the assets are loaded!!!');
    MainJs.init(window, window.$);
    MenuScs.init(window, window.$);
});
