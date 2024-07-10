<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Table;

use App\Models\Role;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class RoleTable extends PowerGridComponent
{
    public function setUp(): array
    {
        // $this->showCheckBox();

        return [
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder|Collection
    {

        if (auth()->user()->hasRole('super-admin')) {
            $roles = Role::select('id', 'title', 'name')
                ->where('name', '!=', 'super-admin')
                ->get();
        } else {
            $roles = Role::select('id', 'title', 'name')
                ->with(['access_to' => fn ($query) => $query->where('id', '!=', auth()->user()->getRoleId())
                    ->orderBy('access_child_id', 'asc'),
                ])
                ->where('id', auth()->user()->getRoleId())
                ->first();

            $roles = $roles->access_to;
        }

        return $roles;
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('no')
            ->add('role');
    }

    public function columns(): array
    {
        return [
            Column::make('Sl.No', 'no')->index(),
            Column::make('Role', 'title')->searchable(),
            Column::action('Action')->hidden(
                isHidden: ! auth()->user()->can('role-delete') && ! auth()->user()->can('role-update')
            ),
        ];
    }

    public function actionsFromView($row): View
    {
        return view('admin.dataTable.actions.model-actions', ['row' => $row, 'model' => 'role']);
    }
}
