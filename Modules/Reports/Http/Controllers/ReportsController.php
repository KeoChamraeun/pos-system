<?php

namespace Modules\Reports\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    public function profitLossReport()
    {
        abort_if(Gate::denies('access_reports'), 403);

        $userId = Auth::id(); // Get current user ID
        return view('reports::profit-loss.index', compact('userId'));
    }

    public function paymentsReport()
    {
        abort_if(Gate::denies('access_reports'), 403);

        $userId = Auth::id();
        return view('reports::payments.index', compact('userId'));
    }

    public function salesReport()
    {
        abort_if(Gate::denies('access_reports'), 403);

        $userId = Auth::id();
        return view('reports::sales.index', compact('userId'));
    }

    public function purchasesReport()
    {
        abort_if(Gate::denies('access_reports'), 403);

        $userId = Auth::id();
        return view('reports::purchases.index', compact('userId'));
    }

    public function salesReturnReport()
    {
        abort_if(Gate::denies('access_reports'), 403);

        $userId = Auth::id();
        return view('reports::sales-return.index', compact('userId'));
    }

    public function purchasesReturnReport()
    {
        abort_if(Gate::denies('access_reports'), 403);

        $userId = Auth::id();
        return view('reports::purchases-return.index', compact('userId'));
    }
}
