<x-admin-layout>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
                <h4 class="page-title">All Users</h4>
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
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="mdi mdi-plus-circle me-2"></i>Add New User</a>
                        </div>
                    </div>

                    <div class="row">

                        <table id="basic-datatable" class="table table-striped table-centered dt-responsive">
                            <thead class="table-dark">
                                <tr>
                                    <th>User</th>
                                    <th>Role</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="d-flex align-items-center gap-2">
                                            <div class="avatar-sm">
                                                <span class="avatar-title bg-#666-lighten rounded-circle text-uppercase">
                                                    <img width="50" height="50" src="{{ $user->getFirstMediaUrl('avatar', 'thumb') }}" alt="{{ $user->short_name }}" />
                                                </span>
                                            </div>
                                            {{ $user->full_name }}
                                        </a>
                                    </td>
                                    <td>{{ $user->getRoleTitles()->first() }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <livewire:admin.user-status :user_id="$user->id" :status="$user->status" />
                                    </td>
                                    <td class="table-action">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="action-icon"> <i class="mdi mdi-pencil"></i></a>
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
    @section('styles')
        @vite('resources/backend/scss/plugins/datatable.css')
    @endsection
    @section('scripts')
        <script type="module">
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
        </script>
    @endsection

</x-admin-layout>
