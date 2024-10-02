<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\admin\Level;
use App\Models\admin\Transaction;
use App\Models\front\TraderId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LevelController extends Controller
{
   public function index()
   {
       $levels = Level::all();
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

       $current_progress = 0 ;

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


       return view('front.Levels.index',compact('levels','current_level','current_progress','profit'));
   }
}
