<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Table;

use App\Enums\RoleEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class UserTable extends PowerGridComponent
{
    public function setUp(): array
    {
        // $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage(25)
                ->showRecordCount(),
        ];
    }

    public function header(): array
    {
        return [];
    }

    public function datasource(): Builder|Collection
    {
        $users = User::query()
            ->select(
                'users.id as id',
                'users.email',
                'users.username',
                'users.status',
                'users.first_name',
                'users.last_name',
                'roles.id as role_id',
                'roles.name as role_name',
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) as full_name")
            )
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id') // Assuming the pivot table is named 'model_has_roles'
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('users.id', '!=', auth()->user()->id);

        if (! auth()->user()->hasRole(RoleEnum::SUPER_ADMIN)) {
            $roles = Role::currentUserCanManageRoles()->first();
            $roles = $roles->access_to->pluck('id')->toArray();

            $users->whereIn('roles.id', $roles);
        }

        return $users;
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('full_name')
            ->add('username')
            ->add('role_name')
            ->add('email', fn ($user) => '<a class="copy-clipboard" data-bs-placement="bottom" data-bs-content="Copied"><i class="mdi mdi-content-copy"></i></a> '.$user->email)
            ->add('status');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->hidden(isHidden: true, isForceHidden: false),
            Column::make('Name', 'full_name')
                ->sortable()
                ->searchable(),

            Column::make('Username', 'username')
                ->sortable()
                ->searchable(),

            Column::make('Role', 'role_name')
                ->sortable(),

            Column::make('Email', 'email')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('Status')
                ->field('status')
                ->bodyAttribute('text-center')
                ->toggleable(
                    hasPermission: auth()->user()->can('user-update'),
                    trueLabel: 'Active',
                    falseLabel: 'Inactive'
                )
                ->sortable(),

            Column::action('Action')->hidden(
                isHidden: ! auth()->user()->can('user-delete') && ! auth()->user()->can('user-update')
            )->fixedOnResponsive()->sortable(),
        ];
    }

    public function onUpdatedToggleable(string|int $id, string $field, string $value): void
    {
        User::query()->find($id)->update([
            $field => e($value),
        ]);

        $this->toast('User status updated successfully!');
    }

    public function filters(): array
    {
        if (auth()->user()->hasRole(RoleEnum::SUPER_ADMIN)) {
            $roles = Role::select('id', 'name')->get();
        } else {
            $roles = Role::currentUserCanManageRoles()->first();
            $roles = $roles->access_to;
        }

        return [
            Filter::select('role_name', 'roles.id')
                ->dataSource($roles)
                ->optionLabel('name')
                ->optionValue('id'),
            Filter::boolean('status')->label('Active', 'Inactive'),
            Filter::inputText('id', 'users.id')->operators(['is']),
        ];
    }

    public function actionsFromView($row): View
    {
        return view('admin.dataTable.actions.model-actions', ['row' => $row, 'model' => 'user']);
    }
}
