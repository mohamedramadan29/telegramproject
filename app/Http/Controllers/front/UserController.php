<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Models\admin\Admin;
use App\Models\admin\Level;
use App\Models\admin\Transaction;
use App\Models\admin\UserLevel;
use App\Models\front\TraderId;
use App\Models\front\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
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
        // التأكد من أن الأعمدة تحتوي على قيم رقمية (سواء أعداد صحيحة أو كسور)


        //  $turnover_sum = $transactions['turnover-clear']->sum();
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

        $vol_share = $transactions->sum(function ($transaction) {
            return is_numeric($transaction->{'vol-share'}) ? $transaction->{'vol-share'} : 0;
        });


        $withdrawSumCompeleted = \App\Models\admin\WithDraw::where('user_id',Auth::id())->where('status',1)->sum('amount');


        ///// Last Main Balance For User

        $last_main_price = $allbalance - $withdrawSumCompeleted;
        return view('front.dashboard', compact('total_balance', 'total_deposits_count', 'total_deposit_sum',
            'total_withdrawals_count', 'total_withdrawals_sum', 'turnover_clear', 'vol_share','profit','profit_without_bouns'
            ,'user_earning','allbalance','level_bouns','current_level','last_main_price','withdrawSumCompeleted'));
    }

    public function register(Request $request)
    {
//        $referral_code = $request->query('ref');
//        if(isset($referral_code)){
//            $referring_user = User::where('referral_code', $referral_code)->first();
//            $referring_level = $referring_user['level_id'];
//        }else{
//            $referring_level = null;
//        }
        if ($request->isMethod('post')) {
            try {
                // تأكيد ما إذا كان التسجيل يتم باستخدام كود إحالة
                $referral_code = $request->input('referral_code');
                $referring_user = null;
                $referring_level = null;

                if ($referral_code) {
                    // ابحث عن المستخدم الذي يملك كود الإحالة
                    $referring_user = User::where('referral_code', $referral_code)->first();

                    // إذا كان هناك مستخدم صاحب كود الإحالة، حدد المستوى الخاص به
                    if ($referring_user) {
                        $referring_level = $referring_user['level_id'];
                    }
                }
               // dd($referring_user->id );
                // ابحث عن المستخدم الذي يملك كود الإحالة
                DB::beginTransaction();
                $data = $request->all();
                // dd($data);
                $email = $data['email'];
                $checkUseremail = User::where('email', $email)->count();
                if ($checkUseremail > 0) {
                    return redirect()->back()->withErrors([' البريد الالكتروني مستخدم بالفعل من فضلك ادخل بريد الكتروني جديد  '])->withInput();
                }
                $rules = [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email|max:150',
                    'password' => 'required|min:8',
                    'confirm-password' => 'required|same:password'
                ];
                $messages = [
                    'name.required' => ' من فضلك ادخل الاسم  ',
                    'email.required' => 'من فضلك ادخل البريد الالكتروني ',
                    'email.unique' => 'البريد الالكتروني مستخدم بالفعل ',
                    'email.email' => 'من فضلك ادخل بريد الكتروني بشكل صحيح ',
                    'email.max' => 'من فضلك ادخل بريد الكتروني اقل من 150 حرف ',
                    'password.required' => 'من فضلك ادخل كلمة المرور ',
                    'password.min' => ' من فضلك ادخل كلمة مرور قوية اكثر من 8 احرف وارقام ',
                    'confirm-password.same' => 'من فضلك اكد كلمة المرور بشكل صحيح ',
                ];
                $validator = Validator::make($data, $rules, $messages);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'referral_code' => Str::random(10),
                    'referred_by' => $referring_user ? $referring_user->id : null,
                    'referred_by_level'=>$referring_level,
                ]);
                ////////////////////// Send Confirmation Email ///////////////////////////////
                ///
                $email = $data['email'];
                $MessageDate = [
                    'name' => $data['name'],
                    "email" => $data['email'],
                    'code' => base64_encode($email)
                ];
                Mail::send('front.mails.UserActivationEmail', $MessageDate, function ($message) use ($email) {
                    $message->to($email)->subject(' تفعيل الحساب الخاص بك  ');
                });
                DB::commit();
                return $this->success_message('تم انشاء الحساب بنجاح من فضلك فعل حسابك من خلال البريد المرسل  ⚡️');
            } catch (\Exception $e) {
                return $this->exception_message($e);
            }
        }
        return view('front.sign-up');
    }

    // Active User Email
    public function UserConfirm($email)
    {
        $email = base64_decode($email);
        // check if this email exist in users or not
        $user_details = User::where('email', $email)->first();
        $userCount = User::where('email', $email)->count();
        if ($userCount > 0) {
            if ($user_details->status == 1) {
                //$message = 'تم تفعيل البريد الالكتروني بالفعل ! سجل دخولك الان ';
                // return redirect('login')->with('Error_Message', $message);
                return redirect('/')->withErrors([' تم تفعيل البريد الالكتروني بالفعل ! سجل دخولك الان  '])->withInput();
            } else {
                // Update User Status
                User::where('email', $email)->update(['status' => 1]);
                // Redirect User To Login/ Regitser Page With Message
                $message = 'تم تفعيل البريد الالكتروني الخاص بك يمكنك تسجيل الدخول الان ';
                return redirect('/')->with('Success_message', $message);
            }
        } else {
            abort(404);
        }

    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            try {
                $data = $request->all();
                $rules = [
                    'email' => 'required|email',
                    'password' => 'required'
                ];
                $messages = [
                    'email.required' => '  من فضلك ادخل البريد الالكتروني   ',
                    'email.email' => ' من فضلك ادخل بريد الكتروني صحيح  ',
                    'password.required' => ' من فضلك ادخل كلمة المرور ',
                ];
                $validator = Validator::make($data, $rules, $messages);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                    if (Auth::user()->status == 0) {
                        Auth::logout();
                        return Redirect::back()->withInput()->withErrors('  من فضلك يجب تفعيل الحساب الخاص بك اولا  ');
                    }
                    return \redirect('user/dashboard');
                } else {
                    return Redirect::back()->withInput()->withErrors('لا يوجد حساب بهذه البيانات  ');
                }

            } catch (\Exception $e) {
                return $this->exception_message($e);
            }
        }
        if (Auth::user()) {
            return \redirect('user/dashboard');
        }
        return view('front.login');
    }

    public function forget_password(Request $request)
    {
        if
        ($request->isMethod('post')) {
            $data = $request->all();
            // dd($data);
            $email = $data['email'];
            $user = User::where('email', $email)->count();
            if ($user > 0) {
                ////////////////////// Send Forget Mail To User  ///////////////////////////////
                ///
                DB::beginTransaction();
                $email = $data['email'];
                $MessageDate = [
                    'code' => base64_encode($email)
                ];
                Mail::send('front.mails.UserChangePasswordMail', $MessageDate, function ($message) use ($email) {
                    $message->to($email)->subject(' رابط تغير كلمة المرور ');
                });
                DB::commit();
                return $this->success_message(' تم ارسال رابط تغير كلمة المرور علي البريد الالكتروني  ');
            } else {
                return Redirect::back()->withErrors(['للاسف لا يوجد حساب بهذة البيانات ']);
                // return $this->Error_message(' للاسف لا يوجد حساب بهذة البيانات  ');
            }
        }
        return view('front.forget-password');
    }

    public function change_forget_password(Request $request, $email)
    {
        $email = base64_decode($email);
        return view('front.change-password', compact('email'));
    }

    public function update_forget_password(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // dd($data);
            $email = $data['email'];
            //dd($data);
            $usercount = User::where('email', $email)->count();
            if ($usercount > 0) {
                ////////// Start Change Password
                $user = User::where('email', $email)->first();
                $rules = [
                    'password' => 'required',
                    'confirm_password' => 'required|same:password'
                ];
                $messages = [
                    'password.required' => ' من فضلك ادخل كلمة المرور  ',
                    'confirm_password.required' => ' من فضلك اكد كلمة المرور ',
                    'confirm_password.same' => ' من فضلك يجب تاكيد كلمة المرور بنجاح '
                ];
                $validator = Validator::make($data, $rules, $messages);
                if ($validator->fails()) {
                    return Redirect::back()->withInput()->withErrors($validator);
                }
                $user->update([
                    'password' => Hash::make($data['password']),
                ]);
                return redirect()->to('/')->with('Success_message', '   تم تعديل كلمة المرور بنجاح سجل ذخولك الان ');
            } else {
                return Redirect::back()->withErrors(['للاسف لا يوجد حساب بهذة البيانات ']);
            }
        }
    }


    // check admin password in client side
    public function check_user_password(Request $request)
    {
        $data = $request->all();
        $old_password = $data['current_password'];
        if (Hash::check($old_password, Auth::user()->password)) {
            return "true";
        } else {
            return "false";
        }
    }

    /////// Update Admin Password /////////////
    public function update_user_password(Request $request)
    {
        if ($request->isMethod('post')) {
            $request_data = $request->all();
            //check if old password is correct or not
            if (Hash::check($request_data['old_password'], Auth::user()->password)) {
                // check if the new password == confirm password
                if ($request_data['new_password'] == $request_data['confirm_password']) {
                    $admin_user = User::where('id', Auth::user()->id)->first();
                    $admin_user->update([
                        'password' => bcrypt($request_data['new_password'])
                    ]);
                    $this->success_message('تم تعديل كلمة المرور بنجاح');
                } else {
                    $this->Error_message('يجب تأكيد كلمة المرور بشكل صحيح');
                }
            } else {
                $this->Error_message('كلمة المرو القديمة غير صحيحة');
            }
        }
        $admin_data = User::where('email', Auth::user()->email)->first();
        return view('front.AdminSetting.update_user_password', compact('admin_data'));
    }

    ///////////////// Update Admin Details  //////////
    public function update_user_details(Request $request)
    {
        $admin_data = User::where('id', Auth::id())->first();
        $id = $admin_data['id'];
        if ($request->isMethod('post')) {
            $all_update_data = $request->all();
            ////////////////////// Make Validation //////////////
            $rules = [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                'email' => 'required|email|unique:users,email,' . $id,
            ];
            $customeMessage = [
                'name.required' => 'من فضلك ادخل الأسم',
                'name.regex' => 'من فضلك ادخل الأسم بشكل صحيح ',
                'email.required' => 'من فضلك ادخل البريد الألكتروني',
                'email.email' => 'من فضلك ادخل البريد الألكتروني بشكل صحيح',
                'email.unique' => 'هذا البريد الألكتروني موجود من قبل من فضلك ادخل بريد الكتروني جديد',

            ];
            $this->validate($request, $rules, $customeMessage);
            $admin_data->update([
                'name' => $all_update_data['name'],
                'email' => $all_update_data['email'],
                'country' => $all_update_data['country'],
            ]);
            $this->success_message('تم تحديث البيانات بنجاح');
            //            return redirect()->back()->with(['Success_message'=>'']);
        }
        return view('front.AdminSetting.update_user_data', compact('admin_data'));
    }

    /////////////////// Logout Admin /////////////////////
    ///
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }


    public function update_trader_id(Request $request)
    {
        $user = Auth::user();
        try {
            $data = $request->all();
            $trader_id = $data['trader_id'];
            $user_traders_count = User::where('trader_id', $trader_id)->count();
            if ($user_traders_count > 0) {
                return Redirect::back()->withInput()->withErrors(' تم استخدام هذا الرمز التعريفي من قبل  ');
            }
            $user->trader_id = $data['trader_id'];
            $user->save();
            return $this->success_message(' تم اضافة الرمز التعريفي الخاص بك بنجاح شاهد عملياتك الان  ');
        } catch (\Exception $e) {
            return $this->exception_message($e);
        }
    }

}
