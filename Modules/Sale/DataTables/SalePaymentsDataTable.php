<?php

namespace Modules\Sale\DataTables;

use Modules\Sale\Entities\SalePayment;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Auth;


class SalePaymentsDataTable extends DataTable
{

    public function dataTable($query) {
        return datatables()
            ->eloquent($query)
            ->addColumn('amount', function ($data) {
                return format_currency($data->amount);
            })
            ->addColumn('action', function ($data) {
                return view('sale::payments.partials.actions', compact('data'));
            });
    }
    public function query(SalePayment $model) {
        $userId = Auth::id();
        return $model->newQuery()->where('user_id', $userId);
    }
    public function html() {
        return $this->builder()
            ->setTableId('sale-payments-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row'<'col-md-3'l><'col-md-5 mb-2'B><'col-md-4'f>> .
                                'tr' .
                                <'row'<'col-md-5'i><'col-md-7 mt-2'p>>")
            ->orderBy(5)
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
            Column::make('date')
                ->title(__('Date'))
                ->className('align-middle text-center'),

            Column::make('reference')
                ->title(__('Reference'))
                ->className('align-middle text-center'),

            Column::computed('amount')
                ->title(__('Amount'))
                ->className('align-middle text-center'),

            Column::make('payment_method')
                ->title(__('Payment Method'))
                ->className('align-middle text-center'),

            Column::computed('action')
                ->title(__('Action'))
                ->exportable(false)
                ->printable(false)
                ->className('align-middle text-center'),

            Column::make('created_at')
                ->visible(false),
        ];
    }

    protected function filename(): string {
        return 'SalePayments_' . date('YmdHis');
    }
}
