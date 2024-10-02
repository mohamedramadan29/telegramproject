<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\admin\Level;
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
      //  $turnover_sum = $transactions['turnover-clear']->sum();
        $turnover_sum = $transactions->sum('turnover-clear');
        $current_level = Level::where('turnover', '<=', $turnover_sum)
            ->orderBy('turnover', 'desc')
            ->first();
        // الحصول على المستوى التالي (الذي يحتاج العميل الوصول إليه)
        $next_level = Level::where('turnover', '>', $turnover_sum)
            ->orderBy('turnover', 'asc')
            ->first();
        // حساب النسبة المئوية المتبقية للوصول إلى المستوى التالي
        $percentage_level_to_complete = 0; // الافتراضي 0 في حالة عدم وجود مستوى أعلى


        if ($next_level) {
            // حساب الفرق بين المستوى الحالي والمستوى التالي
            $turnover_difference = $next_level->turnover - $current_level->turnover;

            // حساب التقدم الحالي
            $current_progress = $turnover_sum - $current_level->turnover;

            // حساب النسبة المئوية للتقدم للوصول إلى المستوى التالي
            $percentage_level_to_complete = ($current_progress / $turnover_difference) * 100;

        }
        //dd($percentage_level_to_complete);
       //   dd($current_level);
        // حساب الربح بناءً على نسبة مستوى الربح
        $profit = 0;
        if ($current_level && isset($current_level['percent_volshare'])) {
            // حساب الربح بناءً على نسبة الربح من حجم التداول
            $profit = (($current_level['percent_volshare'] / 100) * $turnover_sum) + $current_level['Bonus'] ;
        }


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

       // dd($profit);
        return view('front.Transactions.index', compact('transactions','turnover_sum',
            'current_level','percentage_level_to_complete','profit','current_progress','total_balance','total_deposits_count',
        'total_deposit_sum','total_withdrawals_count','total_withdrawals_sum','turnover_clear'));
    }
}
