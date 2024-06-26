import jQuery from 'jquery';
import * as bootstrap from 'bootstrap';
import DataTable from 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';
import select2 from 'select2';
import SimpleBar from 'simplebar';
import * as MainJs from './assets/main';
import * as MenuScs from "./assets/menu";

window.$ = jQuery;
window.bootstrap = bootstrap;
window.DataTable = DataTable;
window.select2 = select2($);
window.MainJs = MainJs;
window.MenuScs = MenuScs;
window.addEventListener('load', function () {
    console.log('All the assets are loaded!!!');
    MainJs.init(window, window.$);
    MenuScs.init(window, window.$);

    FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginFileValidateSize);

    const fileUploadEl = document.querySelectorAll('input.filepond');
    Array.from(fileUploadEl).forEach(inputElement => {
        FilePond.create(
            inputElement,
            {
                storeAsFile: true,
                credits: false,
                maxFileSize: '1MB'
            }
        );
    });
});
