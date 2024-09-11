<x-admin-layout>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Product</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
                <h4 class="page-title">Create Product</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
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
        </div>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" class="mb-3" enctype="multipart/form-data">
        @csrf
        <div class="row">

            <div class="col-md-9">
                    
                <!-- Title & Description -->
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-xl-12">

                                <div class="mb-3">
                                    <x-admin.input-label for="name" :value="__('Name')" />
                                    <x-admin.text-input id="name" class="form-control" type="text" name="name" :value="old('name')" required autocomplete="name" />
                                    <x-admin.input-error :messages="$errors->get('name')" />
                                </div>
                                <div class="mb-3">
                                    <x-admin.input-label for="description" :value="__('Product Descrption')" />                                            
                                    <textarea name="description" id="" cols="30" rows="10"></textarea>
                                    <x-admin.input-error :messages="$errors->get('name')" />
                                </div>

                            </div> <!-- end col-->

                            <div class="col-xl-6">
                                

                            </div> <!-- end col-->
                        </div>
                        <!-- end form -->

                    </div> <!-- end card-body -->
                </div> 
                <!-- end card-->

                <!-- Images, Inventory... -->
                <div class="accordion" id="accordion-1">

                    <div class="accordion-item accordion__item-1">
                        <h2 class="accordion-header" id="accordion__inner_1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#acc-product-images"
                                aria-expanded="true" aria-controls="acc-product-images">
                                Images
                            </button>
                        </h2>
                        <div id="acc-product-images" class="accordion-collapse collapse show" aria-labelledby="accordion__inner_1"
                            data-bs-parent="#accordion-1">
                            <div class="accordion-body">
                                <input type="file" name="product_images[]" class="filepond-upload" id="product-images">
                                <x-admin.input-error :messages="$errors->get('product_images')" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item accordion__item-2">
                        <h2 class="accordion-header" id="accordion__inner_2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#acc-product-pricing" aria-expanded="false" aria-controls="collapseTwo">
                                Pricing
                            </button>
                        </h2>
                        <div id="acc-product-pricing" class="accordion-collapse collapse" aria-labelledby="accordion__inner_2"
                            data-bs-parent="#accordion-1">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <x-admin.input-label for="price" :value="__('Price')" />
                                            <x-admin.text-input id="price" class="form-control" type="number" name="price" :value="old('price')" required autocomplete="price" />
                                            <x-admin.input-error :messages="$errors->get('price')" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <x-admin.input-label for="old_price" :value="__('Compare at price')" />
                                            <x-admin.text-input id="old_price" class="form-control" type="number" name="old_price" :value="old('old_price')" autocomplete="old_price" />
                                            <x-admin.input-error :messages="$errors->get('old_price')" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item accordion__item-3">
                        <h2 class="accordion-header" id="accordion__inner_3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#acc-product-stock" aria-expanded="false" aria-controls="collapseTwo">
                                Inventory
                            </button>
                        </h2>
                        <div id="acc-product-stock" class="accordion-collapse collapse" aria-labelledby="accordion__inner_3"
                            data-bs-parent="#accordion-1">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <x-admin.input-label for="stock" :value="__('Stock')" />
                                            <x-admin.text-input id="stock" class="form-control" type="number" name="stock" :value="old('stock')" required autocomplete="stock" />
                                            <x-admin.input-error :messages="$errors->get('stock')" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <x-admin.input-label for="stock_alert" :value="__('Alert Stock at')" />
                                            <x-admin.text-input id="stock_alert" class="form-control" type="number" name="stock_alert" :value="old('stock_alert')" autocomplete="stock_alert" />
                                            <x-admin.input-error :messages="$errors->get('stock_alert')" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- end card-->
                                                                
            </div>

            <div class="col-md-3">

                <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-xl-12">

                                    <div class="mb-3 d-flex gap-2 items-center">
                                        <div class="badge bg-success d-flex items-center">Status</div>
                                        <div class="form-check form-switch">
                                            <input value="1" type="checkbox" class="form-check-input" name="status" checked id="product-status">
                                            <label class="form-check-label" for="product-status"></label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary mb-3">Create Product</button>
                                    </div> <!-- end col-->

                                </div> <!-- end col-->

                            </div>
                            <!-- end form -->

                    </div> <!-- end card-body -->
                </div> <!-- end card-->
                
            </div>

        </div>
    </form>
    @section('scripts')
        {{ Vite::useBuildDirectory('backend') }}
        @vite('resources/backend/js/filepond.js')
        {{-- <script src="https://cdn.tiny.cloud/1/1yszj8py3dc4j35imv9cg1yxc3thhuoo25a7npxymim0rj0d/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
        tinymce.init({
            selector: 'textarea',
        });
        </script> --}}
    @endsection
</x-admin-layout>
