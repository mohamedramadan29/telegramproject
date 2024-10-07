<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Models\admin\Level;
use App\Models\admin\Transaction;
use App\Models\admin\UserLevel;
use App\Models\admin\WithDraw;
use App\Models\front\TraderId;
use App\Models\front\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class WithDrawController extends Controller
{

    use Message_Trait;

    public function index()
    {
        $user = Auth::user();
        $user_earning = $user['earnings'];
        $tradersIds = TraderId::where('user_id', Auth::id())->pluck('trader_id')->toArray();
        /////// Get All The Transactions Where Trader_id == transaction Trader Id
        ///
        $transactions = Transaction::whereIn('trader-id', $tradersIds)
            ->orderBy('id', 'DESC')
            ->get();
        $turnover_sum = $transactions->sum('turnover-clear');
        $current_level = UserLevel::where('turnover', '<=', $turnover_sum)
            ->orderBy('turnover', 'desc')
            ->first();

        // حساب الربح بناءً على نسبة مستوى الربح
        $profit = 0;
        if ($current_level && isset($current_level['percent_volshare'])) {
            // حساب الربح بناءً على نسبة الربح من حجم التداول
            $profit = (($current_level['percent_volshare'] / 100) * $turnover_sum) + $current_level['Bonus'] ;
            $profit_without_bouns = ($current_level['percent_volshare'] / 100) * $turnover_sum;

        }
        $level_bouns = $current_level['Bonus'];
        $allbalance = floatval($profit + $user_earning);
        $total_balance = $transactions->sum(function ($transaction) {
            return is_numeric($transaction->balance) ? $transaction->balance : 0;
        });

        /////////// حصة الشريك
        /// volshare = userbalance
        $vol_share = $transactions->sum('vol-share');

        $withdraws = WithDraw::where('user_id',Auth::id())->orderBy('id','desc')->get();
        // WithDrawSum Under Revision
        $withdrawSum = WithDraw::where('user_id',Auth::id())->where('status',0)->sum('amount');
        ////// WithDrawSum Compeleted
        $withdrawSumCompeleted = WithDraw::where('user_id',Auth::id())->where('status',1)->sum('amount');
        $last_vol_share = $allbalance - $withdrawSumCompeleted;
        return view('front.WithDraws.index',compact('withdraws','last_vol_share','withdrawSum','withdrawSumCompeleted'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $user_earning = $user['earnings'];
        $tradersIds = TraderId::where('user_id', Auth::id())->pluck('trader_id')->toArray();
        /////// Get All The Transactions Where Trader_id == transaction Trader Id
        ///
        $transactions = Transaction::whereIn('trader-id', $tradersIds)
            ->orderBy('id', 'DESC')
            ->get();
        /////////// حصة الشريك
        /// volshare = userbalance
        $turnover_sum = $transactions->sum('turnover-clear');
        $current_level = UserLevel::where('turnover', '<=', $turnover_sum)
            ->orderBy('turnover', 'desc')
            ->first();

        // حساب الربح بناءً على نسبة مستوى الربح
        $profit = 0;
        if ($current_level && isset($current_level['percent_volshare'])) {
            // حساب الربح بناءً على نسبة الربح من حجم التداول
            $profit = (($current_level['percent_volshare'] / 100) * $turnover_sum) + $current_level['Bonus'] ;
            $profit_without_bouns = ($current_level['percent_volshare'] / 100) * $turnover_sum;

        }

        $level_bouns = $current_level['Bonus'];
        $allbalance = floatval($profit + $user_earning);
        $total_balance = $transactions->sum(function ($transaction) {
            return is_numeric($transaction->balance) ? $transaction->balance : 0;
        });


        $vol_share = $transactions->sum('vol-share');
        ////// WithDrawSum Compeleted
        $withdrawSumCompeleted = WithDraw::where('user_id',Auth::id())->where('status',1)->sum('amount');
        $withdrawSumPending = WithDraw::where('user_id',Auth::id())->where('status',0)->sum('amount');
        //dd($withdrawSumPending);
        $last_vol_share = $allbalance - $withdrawSumCompeleted;
        $last_vol_share_new = $allbalance - ($withdrawSumPending + $withdrawSumCompeleted);
        try {
            $data = $request->all();
            $rules = [
                'amount' => 'required',
                'withdraw_method' => 'required',
            ];
            $messages = [
                'amount.required' => ' من فضلك حدد المبلغ ',
                'withdraw_method.required' => ' من فضلك حدد طريقة السحب '
            ];
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            }
            if ($last_vol_share_new < $data['amount']) {
                return Redirect::back()->withInput()->withErrors('رصيدك الحالي لا يكفي لاجراء طلب السحب ');
            }
//            if ($data['amount'] < 50) {
//                return Redirect::back()->withInput()->withErrors(' اقل مبلغ للسحب هو 20 دولار  ');
//            }
            DB::beginTransaction();
            $withdraw = new WithDraw();
            $withdraw->user_id = Auth::id();
            $withdraw->amount = $data['amount'];
            $withdraw->withdraw_method = $data['withdraw_method'];
            $withdraw->usdt_link = $data['usdt_link'];
            $withdraw->save();
            DB::commit();
            return $this->success_message(' تم اضافة طلب سحب بنجاح  ');

        } catch (\Exception $e) {
            return $this->exception_message($e);
        }
    }

    public function delete($id)
    {
        $withdraw = WithDraw::findOrFail($id);
        if ($withdraw['status'] == 1){
            return Redirect::back()->withInput()->withErrors(' لا يمكن حذف تلك العملية  ');
        }
        /////////// Update User Balance
        $withdraw_amount = $withdraw['amount'];
        $user = Auth::user();
        $main_balance = $user['balance'] + $withdraw_amount;
        $user->balance = $main_balance;
        $user->save();
        $withdraw->delete();
        return $this->success_message(' تم حذف طلب السحب   ');
    }
}
