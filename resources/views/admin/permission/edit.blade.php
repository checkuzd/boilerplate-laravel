<x-admin-layout>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}">Permission</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Permission</h4>
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

            <form action="{{ route('admin.permissions.update', $permission->id) }}" method="POST" class="mb-3">
                @csrf
                @method('PATCH')
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-xl-6">

                                <div class="mb-3">
                                    <x-admin.input-label for="name" :value="__('Permission Name')" />
                                    <x-admin.text-input id="name" class="form-control" type="text" name="name" :value="old('name',$permission->name)" required autocomplete="name" />
                                    <x-admin.input-error :messages="$errors->get('name')" />
                                </div>

                            </div> <!-- end col-->

                            <div class="col-xl-6">

                                <div class="mb-3">
                                    <x-admin.input-label for="permission_id" :value="__('Category')" />
                                    <select name="permission_id" class="form-control" id="permission_id">
                                        <option value="">Select</option>
                                        @foreach ($permissions as $data)
                                            <option value="{{ $data->id }}"
                                                {{ ($data->id == $permission->permission_id) ? 'selected' : '' }}
                                            >
                                                {{ $data->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-admin.input-error :messages="$errors->get('name')" />
                                </div>

                            </div> <!-- end col-->
                        </div>
                        <!-- end form -->

                    </div> <!-- end card-body -->
                </div> <!-- end card-->

                <button type="submit" class="btn btn-primary mb-3">Update Permission</button>
            </form>
        </div>
    </div>
</x-admin-layout>
