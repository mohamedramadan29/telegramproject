<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Models\admin\WithDraw;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class WithDrawController extends Controller
{
    use Message_Trait;

    public function index()
    {
        $withdraws = WithDraw::with('user')->orderBy('id','desc')->get();
        $users = User::all();
        return view('admin.WithDraws.index', compact('withdraws', 'users'));
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $rules = [
                'user_id' => 'required',
                'amount' => 'required',
                'withdraw_method' => 'required',
            ];
            $messages = [
                'user_id.required' => ' من فضلك حدد المستخدم  ',
                'amount.required' => ' من فضلك حدد المبلغ ',
                'withdraw_method.required' => ' من فضلك حدد طريقة السحب '
            ];
            if ($data['amount'] < 10) {
                return Redirect::back()->withErrors('  dfdfdf dfdfdfdf');
            }
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            }
            $user_withdraw = User::where('id', $data['user_id'])->first();
            $old_balance = $user_withdraw['balance'];
            if ($old_balance < $data['amount']) {
                return Redirect::back()->withInput()->withErrors('رصيدك الحالي لا يكفي لاجراء طلب السحب ');
            }
            if ($data['amount'] < 20) {
                return Redirect::back()->withInput()->withErrors(' اقل مبلغ للسحب هو 20 دولار  ');
            }
            $withdraw = new WithDraw();
            $withdraw->user_id = $data['user_id'];
            $withdraw->amount = $data['amount'];
            $withdraw->withdraw_method = $data['withdraw_method'];
            $withdraw->save();
            return $this->success_message(' تم اضافة طلب سحب بنجاح  ');

        } catch (\Exception $e) {
            return $this->exception_message($e);
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            try {
                $data = $request->all();
                $withdraw = WithDraw::findOrFail($id);
                $withdraw->update([
                    'status' => $data['status']
                ]);
                return $this->success_message(' تم تعديل حالة طلب السحب  ');
            } catch (\Exception $e) {
                return $this->exception_message($e);
            }
        }
    }

    public function delete($id)
    {
        $withdraw = WithDraw::findOrFail($id);
        if ($withdraw['status'] == 1){
            return Redirect::back()->withInput()->withErrors(' لا يمكن حذف تلك العملية  ');
        }
        $withdraw->delete();
        return $this->success_message(' تم حذف طلب السحب   ');
    }
}
