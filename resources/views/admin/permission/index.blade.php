<x-admin-layout>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Permissions</li>
                    </ol>
                </div>
                <h4 class="page-title">All Permissions</h4>
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
                            <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary"><i class="mdi mdi-plus-circle me-2"></i>Add New Permission</a>
                        </div>
                    </div>

                    <div class="row">

                        <livewire:admin.table.permission-table />

                    </div>
                    <!-- end form -->

                </div> <!-- end card-body -->
            </div> <!-- end card-->

        </div>
    </div>
    
    @section('scripts')
        {{ Vite::useBuildDirectory('backend') }}
        @vite('resources/backend/js/powergrid.js')
    @endsection

</x-admin-layout>
