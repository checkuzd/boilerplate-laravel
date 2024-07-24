import SortableList from "../plugins/sortableList";
var sortable;
var editMenuItemModalEl;
let editMenuItemModal;
let validationErrors = {};

export function initMenuTree() {
    var options = {
        maxLevels: 2,
        insertZonePlus: true,
        // placeholderCss: { 'background-color': '#ff8', 'padding': '5px' },
        placeholderCss: { 'background-color': '#ffe75f' },
        hintCss: { 'background-color': '#bbf' },
        // currElClass: 'currElemClass',
        // currElCss: { 'background-color': 'green', 'color': '#fff' },
        isAllowed: function (cEl, hint, target) {
            if (target.data('module') === 'c' && cEl.data('module') !== 'c') {
                hint.css('background-color', '#ff9999');
                return false;
            }
            else {
                hint.css('background-color', '#99ff99');
                return true;
            }
        },
        opener: {
            active: true,
            as: 'html',  // if as is not set plugin uses background image
            close: '<i class="mdi mdi-minus-thick c3"></i>',  // or 'fa-minus c3'
            open: '<i class="mdi mdi-plus-thick"></i>',  // or 'fa-plus'
            openerCss: {
                'display': 'inline-block',
                //'width': '18px', 'height': '18px',
                'float': 'left',
                'margin-left': '-40px',
                'margin-right': '5px',
                //'background-position': 'center center', 'background-repeat': 'no-repeat',
                'font-size': '1.1em'
            }
        },
        ignoreClass: 'menu-item-clickable'
    };
    sortable = new SortableList('.sortableLists', options);
    // $('.sortableLists').sortableLists(options);
}

export function initSaveMenuTreeOrder() {
    $('#saveOrder').on('click', function () {
        var menu_items = sortable.sortableListsToArray();
        var sort_items = {};

        menu_items.forEach(function (menu_item) {
            // Perform operations on each menu item
            sort_items[$('#' + menu_item.id).data('id')] = {
                'parent_id': $('#' + menu_item.parentId).data('id'),
                'order': menu_item.order
            };
        });

        $.ajax({
            url: $(this).data('action'),
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            data: {
                items: JSON.stringify(sort_items),
            },
            success: function (response) {
                Swal.fire({
                    toast: true,
                    position: 'top-right',
                    iconColor: 'white',
                    customClass: {
                        popup: 'colored-toast'
                    },
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                    icon: 'success',
                    title: response
                })
            },
            error: function (response) {
            }
        });
    });
}

export function initDeleteMenuItem() {
    $('body').on('click', '.delete-menu-item', function (e) {
        e.preventDefault();

        var $this = $(this);
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#73a7e9',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: $this.data('action'),
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    method: 'DELETE',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (response) {
                        $this.closest('li').remove();
                        Swal.fire({
                            toast: true,
                            position: 'top-right',
                            iconColor: 'white',
                            customClass: {
                                popup: 'colored-toast'
                            },
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                            icon: 'success',
                            title: response
                        })
                    },
                    error: function (response) {
                    }
                });
            }
        })
    });
}

export function initLoadMenuItem() {
    $('body').on('click', '.open-menu-item', function (e) {
        e.preventDefault();
        editMenuItemModal.show();
        $.ajax({
            url: $(this).data('action'),
            method: 'GET',
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                $('#edit-menu-item .modal-content').html(response);
                $('.select-permissions').select2();
            },
            error: function (response) {
            }
        });
    });
}

export function initAddMenuItem() {
    $('.add-menu-item').submit(function (e) {
        e.preventDefault();
        var $this = $(this);
        $.ajax({
            url: $this.attr('action'),
            method: 'POST',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                $this[0].reset();
                $('.select2').trigger('change');
                var item = $(response.view);
                item.data('insideLevels', 0);
                item.data('upperLevels', 0);
                $('#menu-builder').append(item);
                Swal.fire({
                    toast: true,
                    position: 'top-right',
                    iconColor: 'white',
                    customClass: {
                        popup: 'colored-toast'
                    },
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                    icon: 'success',
                    title: response.msg
                })
            },
            error: function (response) {
            }
        });
    });
}

export function initUpdateMenuItem() {
    $('body').on('submit', '#edit-menu-item form', function (e) {
        e.preventDefault();
        var $this = $(this);
        $('.validation-error').html('');
        $.ajax({
            url: $this.attr('action'),
            method: 'POST',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                editMenuItemModal.hide();
                $('#menu-' + $this.data('menu-id') + ' .menu-title').text(response.data.name);
                Swal.fire({
                    toast: true,
                    position: 'top-right',
                    iconColor: 'white',
                    customClass: {
                        popup: 'colored-toast'
                    },
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                    icon: 'success',
                    title: response.msg
                })
            },
            error: function (response) {
                if (response.status === 422){
                    Object.entries(response.responseJSON.errors).forEach(validationError => {
                        const [key, value] = validationError;
                        $(`.error-${key}`).html(value[0]);
                    });
                }
            }
        });
    });
}

export function initHideModal() {
    editMenuItemModalEl.addEventListener('hidden.bs.modal', event => {
        $('#edit-menu-item form').remove();
    })
}

export function init() {
    if ($('#menu-builder').length){
        editMenuItemModal = new bootstrap.Modal('#edit-menu-item');
        editMenuItemModalEl = document.getElementById('edit-menu-item');
        initLoadMenuItem();
        initMenuTree();
        initAddMenuItem();
        initUpdateMenuItem();
        initDeleteMenuItem();
        initSaveMenuTreeOrder();
        initHideModal();
    }
}
