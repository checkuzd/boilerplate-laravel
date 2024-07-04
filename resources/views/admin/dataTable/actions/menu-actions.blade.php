<div class="d-flex">
    <a href="{{ route('admin.menus.edit', $row->id) }}" class="action-icon edit-action"> <i class="mdi mdi-square-edit-outline"></i></a>
    <form method="POST" action="{{ route('admin.menus.destroy', $row->id) }}">
        @csrf
        @method('DELETE')
        <a href="#" class="action-icon open-delete-modal delete-action"> <i class="mdi mdi-delete"></i></a>
    </form>
</div>
