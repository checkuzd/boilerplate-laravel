<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Table;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class ProductTable extends PowerGridComponent
{
    public string $sortField = 'created_at';

    public string $sortDirection = 'desc';

    public function setUp(): array
    {
        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Product::query();
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name', fn ($product) => $this->productInfo($product))
            ->add('price')
            ->add('stock')
            ->add('status');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->hidden(isHidden: true, isForceHidden: false),

            Column::make('Name', 'name')
                ->searchable()
                ->sortable(),

            Column::make('Price', 'price')
                ->sortable(),

            Column::make('Stock', 'stock')
                ->sortable(),

            Column::add()
                ->title('Status')
                ->field('status')
                ->bodyAttribute('text-center')
                ->toggleable(
                    hasPermission: auth()->user()->can('product-update'),
                    trueLabel: 'Active',
                    falseLabel: 'Inactive'
                )
                ->sortable(),

            Column::action('Action')->hidden(
                isHidden: ! auth()->user()->can('product-delete') && ! auth()->user()->can('product-update')
            ),
        ];
    }

    public function onUpdatedToggleable(string|int $id, string $field, string $value): void
    {
        Product::query()->find($id)->update([
            $field => e($value),
        ]);

        $this->toast('Product status updated successfully!');
    }

    public function actionsFromView($row): View
    {
        return view('admin.dataTable.actions.model-actions', ['row' => $row, 'model' => 'product']);
    }

    private function productInfo($product): string
    {
        return Blade::render('<x-admin.product-image image="'.$product->getFirstMediaUrl('product-images', 'thumb').'" productName="'.$product->name.'"/>');
    }
}
