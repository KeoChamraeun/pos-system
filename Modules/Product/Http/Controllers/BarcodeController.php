<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;


class BarcodeController extends Controller
{
    public function printBarcode() {
        $userId = Auth::id(); // Get current logged-in user id

        // You can do something with $userId, for example check if user exists:
        if (!$userId) {
            abort(403, 'Unauthorized');
        }

        // Then return the view
        return view('product::barcode.index');
    }

}
