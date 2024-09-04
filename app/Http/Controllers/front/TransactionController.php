<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\admin\Transaction;
use App\Models\front\TraderId;
use App\Models\front\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        $tradersIds = TraderId::where('user_id', Auth::id())->pluck('trader_id')->toArray();
        /////// Get All The Transactions Where Trader_id == transaction Trader Id
        ///
        $transactions = Transaction::whereIn('trader-id', $tradersIds)
            ->orderBy('id', 'DESC')
            ->get();
        return view('front.Transactions.index', compact('transactions'));
    }
}
