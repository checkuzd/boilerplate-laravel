<?php

namespace App\Livewire\Admin\Table;

use App\Models\Menu\Menu;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class MenuTable extends PowerGridComponent
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
        return Menu::select('id', 'name', 'location')->get();
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('no')
            ->add('name')
            ->add('location');
    }

    public function columns(): array
    {

        return [
            Column::make('Sl.No', 'no')->index(),
            Column::make('Menu', 'name')->searchable(),
            Column::make('Location', 'location')->searchable(),
            Column::action('Action'),
        ];

    }

    public function actionsFromView($row): View
    {
        return view('admin.dataTable.actions.menu-actions', ['row' => $row, 'model' => 'menu']);
    }
}
