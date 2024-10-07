<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(){
        $transactions = Transaction::all();
        // التأكد من أن الأعمدة تحتوي على قيم رقمية (سواء أعداد صحيحة أو كسور)
        $total_balance = $transactions->sum(function ($transaction) {
            return is_numeric($transaction->balance) ? $transaction->balance : 0;
        });

        $total_deposits_count = $transactions->sum(function ($transaction) {
            return is_numeric($transaction->{'deposits-count'}) ? $transaction->{'deposits-count'} : 0;
        });

        $total_deposit_sum = $transactions->sum(function ($transaction) {
            return is_numeric($transaction->{'deposits-sum'}) ? $transaction->{'deposits-sum'} : 0;
        });

        $total_withdrawals_count = $transactions->sum(function ($transaction) {
            return is_numeric($transaction->{'withdrawals-count'}) ? $transaction->{'withdrawals-count'} : 0;
        });

        $total_withdrawals_sum = $transactions->sum(function ($transaction) {
            return is_numeric($transaction->{'withdrawals-sum'}) ? $transaction->{'withdrawals-sum'} : 0;
        });

        $turnover_clear = $transactions->sum(function ($transaction) {
            return is_numeric($transaction->{'turnover-clear'}) ? $transaction->{'turnover-clear'} : 0;
        });

        return view('admin.Transactions.index',compact('transactions','total_balance','total_withdrawals_sum','total_withdrawals_count',
        'total_deposit_sum','total_deposits_count','turnover_clear'));
    }
}
