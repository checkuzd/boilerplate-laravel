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

                        <livewire:admin.table.menu-table />

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
