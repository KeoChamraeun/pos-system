<?php

namespace Modules\Product\DataTables;

use Modules\Product\Entities\Category;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductCategoriesDataTable extends DataTable
{
    public function dataTable($query)
    {
        $userId = auth()->id(); // Get the logged-in user ID

        return datatables()
            ->eloquent($query)
            ->addColumn('product_image', function ($category) {
                $image = $category->product_image ? asset('storage/' . $category->product_image) : asset('images/fallback_product_image.png');
                return '<img src="' . $image . '" width="50" height="50" class="img-thumbnail">';
            })
            ->addColumn('action', function ($category) use ($userId) {
                // Only show action buttons if the category belongs to the user
                if ($category->user_id === $userId) {
                    return view('product::categories.partials.actions', compact('category'));
                }
                return ''; // or return some notice/message if you want
            })
            ->rawColumns(['product_image', 'action']);
    }

    public function query(Category $model)
    {
        $userId = auth()->id(); // Get the logged-in user ID

        // Filter categories by user ID
        return $model->newQuery()->where('user_id', $userId);
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('categories-table')
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
            Column::make('category_code')
                ->title(__('Code'))
                ->className('text-center align-middle'),
            Column::make('category_name')
                ->title(__('Name'))
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
        return 'Categories_' . date('YmdHis');
    }
}
