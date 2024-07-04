<div class="d-flex">
    @can($model.'-update')
        <a href="{{ route('admin.'.$model.'s.edit', $row->id) }}" class="action-icon edit-action"> <i class="mdi mdi-square-edit-outline"></i></a>
    @endcan
    @can($model.'-delete')
        <form method="POST" action="{{ route('admin.'.$model.'s.destroy', $row->id) }}">
            @csrf
            @method('DELETE')
            <a href="#" class="action-icon open-delete-modal delete-action"> <i class="mdi mdi-delete"></i></a>
        </form>
    @endcan
</div>
