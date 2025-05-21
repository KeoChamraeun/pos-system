<?php

namespace Modules\Adjustment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Modules\Adjustment\Entities\Adjustment;
use Modules\Adjustment\Entities\AdjustedProduct;
use Modules\Product\Entities\Product;
use Modules\Adjustment\DataTables\AdjustmentsDataTable;

class AdjustmentController extends Controller
{
    public function index(AdjustmentsDataTable $dataTable)
    {
        abort_if(Gate::denies('access_adjustments'), 403);
        return $dataTable->render('adjustment::index');
    }

    public function create()
    {
        abort_if(Gate::denies('create_adjustments'), 403);
        return view('adjustment::create');
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('create_adjustments'), 403);

        $request->validate([
            'reference'   => 'required|string|max:255',
            'date'        => 'required|date',
            'note'        => 'nullable|string|max:1000',
            'product_ids' => 'required|array',
            'quantities'  => 'required|array',
            'types'       => 'required|array'
        ]);

        DB::transaction(function () use ($request) {
            $adjustment = Adjustment::create([
                'reference' => $request->reference,
                'date' => $request->date,
                'note' => $request->note
            ]);

            foreach ($request->product_ids as $key => $id) {
                AdjustedProduct::create([
                    'adjustment_id' => $adjustment->id,
                    'product_id' => $id,
                    'quantity' => $request->quantities[$key],
                    'type' => $request->types[$key]
                ]);

                $product = Product::findOrFail($id);

                if ($request->types[$key] === 'add') {
                    $product->increment('product_quantity', $request->quantities[$key]);
                } else {
                    $product->decrement('product_quantity', $request->quantities[$key]);
                }
            }
        });

        toast(__('Adjustment Created!'), 'success');
        return redirect()->route('adjustments.index');
    }

    public function show(Adjustment $adjustment)
    {
        abort_if(Gate::denies('show_adjustments'), 403);
        return view('adjustment::show', compact('adjustment'));
    }

    public function edit(Adjustment $adjustment)
    {
        abort_if(Gate::denies('edit_adjustments'), 403);
        return view('adjustment::edit', compact('adjustment'));
    }

    public function update(Request $request, Adjustment $adjustment)
    {
        abort_if(Gate::denies('edit_adjustments'), 403);

        $request->validate([
            'reference'   => 'required|string|max:255',
            'date'        => 'required|date',
            'note'        => 'nullable|string|max:1000',
            'product_ids' => 'required|array',
            'quantities'  => 'required|array',
            'types'       => 'required|array'
        ]);

        DB::transaction(function () use ($request, $adjustment) {
            $adjustment->update([
                'reference' => $request->reference,
                'date' => $request->date,
                'note' => $request->note
            ]);

            foreach ($adjustment->adjustedProducts as $adjustedProduct) {
                $product = Product::findOrFail($adjustedProduct->product_id);
                if ($adjustedProduct->type === 'add') {
                    $product->decrement('product_quantity', $adjustedProduct->quantity);
                } else {
                    $product->increment('product_quantity', $adjustedProduct->quantity);
                }
                $adjustedProduct->delete();
            }

            foreach ($request->product_ids as $key => $id) {
                AdjustedProduct::create([
                    'adjustment_id' => $adjustment->id,
                    'product_id' => $id,
                    'quantity' => $request->quantities[$key],
                    'type' => $request->types[$key]
                ]);

                $product = Product::findOrFail($id);
                if ($request->types[$key] === 'add') {
                    $product->increment('product_quantity', $request->quantities[$key]);
                } else {
                    $product->decrement('product_quantity', $request->quantities[$key]);
                }
            }
        });

        toast(__('Adjustment Updated!'), 'info');
        return redirect()->route('adjustments.index');
    }

    public function destroy(Adjustment $adjustment)
    {
        abort_if(Gate::denies('delete_adjustments'), 403);
        $adjustment->delete();
        toast(__('Adjustment Deleted!'), 'warning');
        return redirect()->route('adjustments.index');
    }
}
