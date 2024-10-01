<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Models\admin\Level;
use App\Models\admin\Transaction;
use App\Models\front\TraderId;
use Illuminate\Support\Facades\Auth;

class ReferalController extends Controller
{
    use Message_Trait;

    public function index()
    {
        $user = Auth::user();
        // جلب جميع الإحالات المرتبطة بهذا المستخدم
        $referrals = $user->referrals;

        // تقسيم الإحالات حسب المستوى الذي كان فيه المستخدم عند تسجيلهم
        $referrals_by_level = $referrals->groupBy('referred_by_level');
        //dd($referrals_by_level);
        $transaction_total = 0;
        $volshare_total = 0;
        // التعامل مع كل مجموعة من الإحالات بناءً على المستوى
        foreach ($referrals_by_level as $level_id => $referral_group) {
            $group_transaction_total = 0;
            // لكل إحالة في هذه المجموعة، جمع حجم التداول
            foreach ($referral_group as $ref) {
                $traders = TraderId::where('user_id', $ref['id'])->pluck('trader_id');
                $transactions = Transaction::whereIn('trader-id', $traders)->sum('turnover-clear');
                // جمع حجم التداول لهذه الإحالة
                $group_transaction_total += $transactions;
            }
            //dd($level_id);
            // بعد جمع حجم التداول لهذه المجموعة، قم بحساب نسبة هذا المستوى
            $level = Level::find($level_id);
            // dd($level);
            $percentage = $level ? $level->percent_volshare : 1; // إذا لم يتم العثور على المستوى، استخدم نسبة 100%
            //dd($percentage);
            // حساب الربح الخاص بالمجموعة وجمعه مع الإجمالي
            $volshare_total += $group_transaction_total * ($percentage / 100); // تحويل النسبة إلى نسبة عشرية

            // جمع حجم التداول الإجمالي لهذه المجموعة
            $transaction_total += $group_transaction_total;
        }

        // بعد حساب إجمالي حجم التداول، تحديد المستوى الجديد للمستخدم
        $bonus = 0; // متغير لحفظ المكافأة
        if ($transaction_total > 0) {
            $current_level = Level::where('turnover', '<=', $transaction_total)
                ->orderBy('turnover', 'desc')
                ->first();

            if ($current_level) {
                // احفظ المستوى الجديد إذا كان مختلفًا
                if ($user->level_id != $current_level->id) {
                    // إضافة المكافأة عند الانتقال للمستوى الجديد إذا لم يحصل عليها بعد
                    if (!$user->bonus_received) {
                        $bonus = $current_level->Bonus; // تأكد من أن عمود "Bonus" موجود في جدول "levels"
                        $user->earnings += floatval($bonus); // تحديث الأرباح مع المكافأة
                        $user->bonus_received = true; // تعيين أن المكافأة قد تم منحها
                    } else {
                        // إعادة تعيين bonus_received إذا انتقل المستخدم إلى مستوى أعلى
                        $user->bonus_received = false;
                    }
                    $user->level_id = $current_level->id; // تحديث المستوى
                }

                $bonus = $current_level->Bonus;
            }
        }
        // حساب مجموع الأرباح الجديد
        $new_earnings =  floatval($volshare_total) + floatval($bonus);
        //dd($bonus);
        // إذا كانت الأرباح الجديدة أكبر من الحالية، نضيف الفرق فقط
        if ($new_earnings > $user->earnings) {
            $difference = $new_earnings - $user->earnings;
            $user->earnings += $difference; // إضافة الفرق
        }

        $user->save(); // احفظ التغييرات في قاعدة البيانات

        // عرض إجمالي حجم التداول وإجمالي الربح الناتج من الإحالات
        return view('front.referrals.index', compact('referrals', 'transaction_total', 'volshare_total'));
    }

}
