<?php

namespace Modules\Currency\DataTables;

use Modules\Currency\Entities\Currency;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CurrencyDataTable extends DataTable
{

    public function dataTable($query) {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($data) {
                return view('currency::partials.actions', compact('data'));
            });
    }

    public function query(Currency $model)
    {
        return $model->newQuery()->where('user_id', auth()->id());
    }

    public function html() {
        return $this->builder()
            ->setTableId('currency-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row'<'col-md-3'l><'col-md-5 mb-2'B><'col-md-4'f>> .
                                        'tr' .
                                        <'row'<'col-md-5'i><'col-md-7 mt-2'p>>")
            ->orderBy(6)
            ->buttons(
                Button::make('excel')
                    ->text('<i class="bi bi-file-earmark-excel-fill"></i> Excel'),
                Button::make('print')
                    ->text('<i class="bi bi-printer-fill"></i> Print'),
                Button::make('reset')
                    ->text('<i class="bi bi-x-circle"></i> Reset'),
                Button::make('reload')
                    ->text('<i class="bi bi-arrow-repeat"></i> Reload')
            );
    }

    protected function getColumns() {
        return [
            Column::make('currency_name')
                ->title(__('Currency Name'))
                ->className('text-center align-middle'),

            Column::make('code')
                ->title(__('Code'))
                ->className('text-center align-middle'),

            Column::make('symbol')
                ->title(__('Symbol'))
                ->className('text-center align-middle'),

            Column::make('thousand_separator')
                ->title(__('Thousand Separator'))
                ->className('text-center align-middle'),

            Column::make('decimal_separator')
                ->title(__('Decimal Separator'))
                ->className('text-center align-middle'),

            Column::computed('action')
                ->title(__('Action'))
                ->exportable(false)
                ->printable(false)
                ->className('text-center align-middle'),

            Column::make('created_at')
                ->visible(false)
        ];
    }

    protected function filename(): string {
        return 'Currency_' . date('YmdHis');
    }
}
