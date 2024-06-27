<x-admin-layout>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Roles</li>
                    </ol>
                </div>
                <h4 class="page-title">All Roles</h4>
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

            <div class="card">
                <div class="card-body">

                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary"><i class="mdi mdi-plus-circle me-2"></i>Add New Role</a>
                        </div>
                    </div>

                    <div class="row">

                        <table id="basic-datatable" class="table table-striped table-centered dt-responsive">
                            <thead class="table-dark">
                                <tr>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($roles as $role)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.roles.edit', $role->id) }}">
                                            {{ $role->title }}
                                        </a>
                                    </td>
                                    <td class="table-action">
                                        <a href="{{ route('admin.roles.edit', $role->id) }}" class="action-icon"> <i class="mdi mdi-pencil"></i></a>
                                        <a href="javascript: void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>
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
                console.log($('body'));
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
