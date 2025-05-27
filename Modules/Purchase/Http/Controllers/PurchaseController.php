<?php

namespace Modules\Purchase\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Modules\People\Entities\Supplier;
use Modules\Product\Entities\Product;
use Modules\Purchase\DataTables\PurchaseDataTable;
use Modules\Purchase\Entities\Purchase;
use Modules\Purchase\Entities\PurchaseDetail;
use Modules\Purchase\Entities\PurchasePayment;
use Modules\Purchase\Http\Requests\StorePurchaseRequest;
use Modules\Purchase\Http\Requests\UpdatePurchaseRequest;

class PurchaseController extends Controller
{
    public function index(PurchaseDataTable $dataTable)
    {
        abort_if(Gate::denies('access_purchases'), 403);

        return $dataTable->render('purchase::index');
    }

    public function create()
    {
        abort_if(Gate::denies('create_purchases'), 403);

        Cart::instance('purchase')->destroy();

        return view('purchase::create');
    }

    public function store(StorePurchaseRequest $request)
    {
        DB::transaction(function () use ($request) {
            $due_amount = $request->total_amount - $request->paid_amount;
            $payment_status = match (true) {
                $due_amount == $request->total_amount => 'Unpaid',
                $due_amount > 0 => 'Partial',
                default => 'Paid',
            };

            $purchase = Purchase::create([
                'user_id' => Auth::id(),
                'date' => $request->date,
                'supplier_id' => $request->supplier_id,
                'supplier_name' => Supplier::findOrFail($request->supplier_id)->supplier_name,
                'tax_percentage' => $request->tax_percentage,
                'discount_percentage' => $request->discount_percentage,
                'shipping_amount' => $request->shipping_amount * 100,
                'paid_amount' => $request->paid_amount * 100,
                'total_amount' => $request->total_amount * 100,
                'due_amount' => $due_amount * 100,
                'status' => $request->status,
                'payment_status' => $payment_status,
                'payment_method' => $request->payment_method,
                'note' => $request->note,
                'tax_amount' => Cart::instance('purchase')->tax() * 100,
                'discount_amount' => Cart::instance('purchase')->discount() * 100,
            ]);

            foreach (Cart::instance('purchase')->content() as $item) {
                PurchaseDetail::create([
                    'user_id' => Auth::id(),
                    'purchase_id' => $purchase->id,
                    'product_id' => $item->id,
                    'product_name' => $item->name,
                    'product_code' => $item->options->code,
                    'quantity' => $item->qty,
                    'price' => $item->price * 100,
                    'unit_price' => $item->options->unit_price * 100,
                    'sub_total' => $item->options->sub_total * 100,
                    'product_discount_amount' => $item->options->product_discount * 100,
                    'product_discount_type' => $item->options->product_discount_type,
                    'product_tax_amount' => $item->options->product_tax * 100,
                ]);

                if ($request->status === 'Completed') {
                    $product = Product::findOrFail($item->id);
                    $product->increment('product_quantity', $item->qty);
                }
            }

            Cart::instance('purchase')->destroy();

            if ($purchase->paid_amount > 0) {
                PurchasePayment::create([
                    'date' => $request->date,
                    'reference' => 'INV/' . $purchase->reference,
                    'amount' => $purchase->paid_amount,
                    'purchase_id' => $purchase->id,
                    'payment_method' => $request->payment_method,
                ]);
            }
        });

        toast('Purchase Created!', 'success');

        return redirect()->route('purchases.index');
    }

    public function show(Purchase $purchase)
    {
        abort_if(Gate::denies('show_purchases'), 403);

        $supplier = Supplier::findOrFail($purchase->supplier_id);

        return view('purchase::show', compact('purchase', 'supplier'));
    }

    public function edit(Purchase $purchase)
    {
        abort_if(Gate::denies('edit_purchases'), 403);

        $cart = Cart::instance('purchase');
        $cart->destroy();

        foreach ($purchase->purchaseDetails as $detail) {
            $cart->add([
                'id' => $detail->product_id,
                'name' => $detail->product_name,
                'qty' => $detail->quantity,
                'price' => $detail->price,
                'weight' => 1,
                'options' => [
                    'product_discount' => $detail->product_discount_amount,
                    'product_discount_type' => $detail->product_discount_type,
                    'sub_total' => $detail->sub_total,
                    'code' => $detail->product_code,
                    'stock' => Product::findOrFail($detail->product_id)->product_quantity,
                    'product_tax' => $detail->product_tax_amount,
                    'unit_price' => $detail->unit_price,
                ],
            ]);
        }

        return view('purchase::edit', compact('purchase'));
    }

    public function update(UpdatePurchaseRequest $request, Purchase $purchase)
    {
        DB::transaction(function () use ($request, $purchase) {
            $due_amount = $request->total_amount - $request->paid_amount;
            $payment_status = match (true) {
                $due_amount == $request->total_amount => 'Unpaid',
                $due_amount > 0 => 'Partial',
                default => 'Paid',
            };

            foreach ($purchase->purchaseDetails as $detail) {
                if ($purchase->status === 'Completed') {
                    Product::findOrFail($detail->product_id)->decrement('product_quantity', $detail->quantity);
                }
                $detail->delete();
            }

            $purchase->update([
                'user_id' => Auth::id(),
                'date' => $request->date,
                'reference' => $request->reference,
                'supplier_id' => $request->supplier_id,
                'supplier_name' => Supplier::findOrFail($request->supplier_id)->supplier_name,
                'tax_percentage' => $request->tax_percentage,
                'discount_percentage' => $request->discount_percentage,
                'shipping_amount' => $request->shipping_amount * 100,
                'paid_amount' => $request->paid_amount * 100,
                'total_amount' => $request->total_amount * 100,
                'due_amount' => $due_amount * 100,
                'status' => $request->status,
                'payment_status' => $payment_status,
                'payment_method' => $request->payment_method,
                'note' => $request->note,
                'tax_amount' => Cart::instance('purchase')->tax() * 100,
                'discount_amount' => Cart::instance('purchase')->discount() * 100,
            ]);

            foreach (Cart::instance('purchase')->content() as $item) {
                PurchaseDetail::create([
                    'user_id' => Auth::id(),
                    'purchase_id' => $purchase->id,
                    'product_id' => $item->id,
                    'product_name' => $item->name,
                    'product_code' => $item->options->code,
                    'quantity' => $item->qty,
                    'price' => $item->price * 100,
                    'unit_price' => $item->options->unit_price * 100,
                    'sub_total' => $item->options->sub_total * 100,
                    'product_discount_amount' => $item->options->product_discount * 100,
                    'product_discount_type' => $item->options->product_discount_type,
                    'product_tax_amount' => $item->options->product_tax * 100,
                ]);

                if ($request->status === 'Completed') {
                    Product::findOrFail($item->id)->increment('product_quantity', $item->qty);
                }
            }

            Cart::instance('purchase')->destroy();
        });

        toast('Purchase Updated!', 'info');

        return redirect()->route('purchases.index');
    }

    public function destroy(Purchase $purchase)
    {
        abort_if(Gate::denies('delete_purchases'), 403);

        $purchase->delete();

        toast('Purchase Deleted!', 'warning');

        return redirect()->route('purchases.index');
    }
}
