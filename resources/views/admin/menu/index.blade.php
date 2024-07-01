<x-admin-layout>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Menus</li>
                    </ol>
                </div>
                <h4 class="page-title">All Menu</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card">
                <div class="card-body">

                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create-menu"><i class="mdi mdi-plus-circle me-2"></i>Add New Menu</button>
                            @include('admin.menu.modal.create-menu')
                        </div>
                    </div>

                    <div class="row">

                        <table id="basic-datatable" class="table table-striped table-centered dt-responsive">
                            <thead class="table-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($menus as $menu)
                                <tr>
                                    <td>
                                        <a class="edit-menu" href="{{ route('admin.menus.edit', $menu->id) }}">
                                            {{ $menu->name }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $menu->location }}
                                    </td>
                                    <td class="table-action d-flex">
                                        <a href="{{ route('admin.menus.edit', $menu->id) }}" class="action-icon edit-menu"> <i class="mdi mdi-pencil"></i></a>

                                    <form method="POST" action="{{ route('admin.menus.destroy', $menu->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <a href="#"
                                        onclick="event.preventDefault();
                                                            this.closest('form').submit();" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                                    </form>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>
                    <!-- end form -->

                </div> <!-- end card-body -->
            </div> <!-- end card-->

        </div>
    </div>

    @section('scripts')
    <script type="module">
        $(document).ready(function () {
            $('#basic-datatable').DataTable({
                keys: true,
                "language": {
                    "paginate": {
                        "previous": "<i class='mdi mdi-chevron-left'>",
                        "next": "<i class='mdi mdi-chevron-right'>"
                    }
                },
                "drawCallback": function () {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                }
            });
        });
    </script>
    @endsection

</x-admin-layout>
