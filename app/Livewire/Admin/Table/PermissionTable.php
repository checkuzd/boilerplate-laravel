<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Table;

use App\Models\Permission;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class PermissionTable extends PowerGridComponent
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

    public function datasource(): Collection
    {
        return Permission::with('parent', 'roles')->get();
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('no')
            ->add('name')
            ->add('roles', fn ($permission) => $this->showRoles($permission->roles));
    }

    public function showRoles($roles): string
    {
        $roleName = [];
        if ($roles) {
            foreach ($roles as $key => $role) {
                $roleName[$key] = $role->name;
            }
        }

        return implode(' | ', $roleName);
    }

    public function columns(): array
    {

        return [
            Column::make('Sl.No', 'no')->index(),
            Column::make('Permission', 'name')->searchable(),
            Column::make('Roles', 'roles')->searchable(),
            Column::action('Action'),
        ];

    }

    public function actionsFromView($row): View
    {
        return view('admin.dataTable.actions.model-actions', ['row' => $row, 'model' => 'permission']);
    }
}
