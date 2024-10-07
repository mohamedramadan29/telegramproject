<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Models\admin\Level;
use App\Models\admin\UserLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class UserLevelController extends Controller
{
    use Message_Trait;
    public function index()
    {
        $levels = UserLevel::all();
        return view('admin.UserLevels.index',compact('levels'));
    }

    public function store (Request $request)
    {
        if ($request->isMethod('post')) {
            try {

                $data = $request->all();
                $rules = [
                    'name' => 'required',
                    'turnover' => 'required',
                    'percent_volshare' => 'required'
                ];
                $messages = [
                    'name.required' => ' من فضلك ادخل الاسم  ',
                    'turnover.required' => ' من فضلك ادخل حجم التداول   ',
                    'percent_volshare.required' => ' من فضلك ادخل volshare '
                ];
                $validator = Validator::make($data, $rules, $messages);
                if ($validator->fails()) {
                    return Redirect::back()->withInput()->withErrors($validator);
                }
                $level = new  UserLevel();
                $level->name = $data['name'];
                $level->turnover = $data['turnover'];
                $level->percent_volshare = $data['percent_volshare'];
                $level->Bonus = $data['bonus'];
                $level->save();
                return $this->success_message(' تم اضافة المستوي بنجاح  ');
            } catch (\Exception $e) {
                return $this->exception_message($e);
            }
        }
    }

    public function update(Request $request,$id)
    {
        $level = UserLevel::findOrFail($id);
        if ($request->isMethod('post')) {
            try {

                $data = $request->all();
                $rules = [
                    'name' => 'required',
                    'turnover' => 'required',
                    'percent_volshare' => 'required'
                ];
                $messages = [
                    'name.required' => ' من فضلك ادخل الاسم  ',
                    'turnover.required' => ' من فضلك ادخل حجم التداول   ',
                    'percent_volshare.required' => ' من فضلك ادخل volshare '
                ];
                $validator = Validator::make($data, $rules, $messages);
                if ($validator->fails()) {
                    return Redirect::back()->withInput()->withErrors($validator);
                }
                $level->update([
                    'name'=>$data['name'],
                    'turnover'=>$data['turnover'],
                    'percent_volshare'=>$data['percent_volshare'],
                    'Bonus'=>$data['bonus'],
                ]);
                return $this->success_message(' تم تعديل  المستوي بنجاح  ');
            } catch (\Exception $e) {
                return $this->exception_message($e);
            }
        }
    }
    public function delete($id)
    {
        $level = UserLevel::findOrFail($id);
        $level->delete();
        return $this->success_message(' تم حذف المستوي بنجاح  ');
    }
}
