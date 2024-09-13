<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Models\admin\Boot;
use App\Models\front\TraderId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class TraderIdController extends Controller
{

    use Message_Trait;

    public function index()
    {
        $tradersids = TraderId::where('user_id', Auth::id())->orderBy('id','DESC')->get();
        return view('front.TraderIds.index', compact('tradersids'));
    }

    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            try {

                $data = $request->all();
                $rules = [
                    'trader_id' => 'required|regex:/^[0-9]+$/',
                ];
                $messages = [

                    'trader_id.required' => 'من فضلك ادخل رقم المعرف  ',
                    'trader_id.regex' => 'يجب أن يحتوي رقم المعرف   على أرقام فقط',
                ];
                $validator = Validator::make($data, $rules, $messages);
                if ($validator->fails()) {
                    return Redirect::back()->withInput()->withErrors($validator);
                }
                ///////////// Check If This Trader Is Stored Before Or Not
                ///
                $countTraderIDs = TraderId::where('trader_id', $data['trader_id'])->count();
                if ($countTraderIDs > 0) {
                    return Redirect::back()->withInput()->withErrors(' الرمز التعريفي مسجل من قبل من فضلك ادخل رمز جديد  ');
                }
                // إزالة أي أحرف غير رقمية من trader_id
                $cleanedTraderId = preg_replace('/\D/', '', $request->input('trader_id'));
                $trader_id = new TraderId();
              DB::beginTransaction();
                $trader_id->user_id = Auth::id();
                $trader_id->trader_id = $cleanedTraderId;
                $trader_id->save();
                ////////// Insert Into New TradersTest
                ///
                DB::table('traderstest')->insert([
                    'trader_id'=>$cleanedTraderId,
                ]);
                DB::commit();
                return $this->success_message(' تم اضافة رمز تعريفي جديد خاص بك وفي انتظار المراجعة  ');
            } catch (\Exception $e) {
                return $this->exception_message($e);
            }
        }
    }

    public function delete($id)
    {
        $trader_id = TraderId::findOrFail($id);
        $trader_id->delete();
        return $this->success_message(' تم حذف الرمز التعريفي بنجاح ');
    }

}
