<?php

namespace Modules\Product\DataTables;

use Modules\Product\Entities\Product;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductCategoriesDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('product_image', function ($product) {
                $image = $product->getFirstMediaUrl('images', 'thumb');
                $fallback = asset('images/fallback_product_image.png');
                return '<img src="' . ($image ?: $fallback) . '" width="50" height="50" class="img-thumbnail">';
            })
            ->addColumn('category_name', function ($product) {
                return $product->category->category_name ?? '-';
            })
            ->addColumn('action', function ($product) {
                return view('product::categories.partials.actions', compact('product'));
            })
            ->rawColumns(['product_image', 'action']);
    }

    public function query(Product $model)
    {
        return $model->newQuery()->with('category');
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('product_categories-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row'<'col-md-3'l><'col-md-5 mb-2'B><'col-md-4'f>>" .
                  "tr" .
                  "<'row'<'col-md-5'i><'col-md-7 mt-2'p>>")
            ->orderBy(1)
            ->buttons(
                Button::make('excel')->text('<i class="bi bi-file-earmark-excel-fill"></i> Excel'),
                Button::make('print')->text('<i class="bi bi-printer-fill"></i> Print'),
                Button::make('reset')->text('<i class="bi bi-x-circle"></i> Reset'),
                Button::make('reload')->text('<i class="bi bi-arrow-repeat"></i> Reload')
            );
    }

    protected function getColumns()
    {
        return [
            Column::computed('product_image')
                ->title(__('Image'))
                ->className('text-center align-middle'),

            Column::computed('category_name')
                ->title(__('Category'))
                ->className('text-center align-middle'),

            Column::make('product_code')
                ->title(__('Code'))
                ->className('text-center align-middle'),

            Column::make('product_name')
                ->title(__('Name'))
                ->className('text-center align-middle'),

            Column::make('product_cost')
                ->title(__('Cost'))
                ->className('text-center align-middle'),

            Column::make('product_price')
                ->title(__('Price'))
                ->className('text-center align-middle'),

            Column::make('product_quantity')
                ->title(__('Quantity'))
                ->className('text-center align-middle'),

            Column::computed('action')
                ->title(__('Action'))
                ->exportable(false)
                ->printable(false)
                ->className('text-center align-middle'),

            Column::make('created_at')->visible(false),
        ];
    }

    protected function filename(): string
    {
        return 'ProductCategories_' . date('YmdHis');
    }
}
