<x-admin-layout>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Products</li>
                    </ol>
                </div>
                <h4 class="page-title">All Products</h4>
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
                <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>{{ session('error') }}</strong>
                </div>
            @endif

            <div class="card">
                <div class="card-body">

                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <a href="{{ route('admin.products.create') }}" class="btn btn-primary"><i class="mdi mdi-plus-circle me-2"></i>Add New Product</a>
                        </div>
                    </div>

                    <div class="row">

                        <livewire:admin.table.product-table />

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
