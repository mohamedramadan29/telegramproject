<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Models\admin\Boot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class BootController extends Controller
{

    use Message_Trait;

    public function index()
    {
        $boots = Boot::all();
        return view('admin.Boots.index', compact('boots'));
    }

    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            try {

                $data = $request->all();
                $rules = [
                    'name' => 'required',
                    'username' => 'required',
                    'link' => 'required'
                ];
                $messages = [
                    'name.required' => ' من فضلك ادخل الاسم  ',
                    'username.required' => ' من فضلك ادخل اسم المستخدم  ',
                    'link.required' => ' من فضلك ادخل رابط البوت '
                ];
                $validator = Validator::make($data, $rules, $messages);
                if ($validator->fails()) {
                    return Redirect::back()->withInput()->withErrors($validator);
                }
                $boot = new  Boot();
                $boot->name = $data['name'];
                $boot->username = $data['username'];
                $boot->link = $data['link'];
                $boot->notes = $data['notes'];
                $boot->save();
                return $this->success_message(' تم اضافة البوت بنجاح  ');
            } catch (\Exception $e) {
                return $this->exception_message($e);
            }
        }
    }

    public function update(Request $request,$id)
    {
        $boot = Boot::findOrFail($id);
        if ($request->isMethod('post')) {
            try {

                $data = $request->all();
                $rules = [
                    'name' => 'required',
                    'username' => 'required',
                    'link' => 'required'
                ];
                $messages = [
                    'name.required' => ' من فضلك ادخل الاسم  ',
                    'username.required' => ' من فضلك ادخل اسم المستخدم  ',
                    'link.required' => ' من فضلك ادخل رابط البوت '
                ];
                $validator = Validator::make($data, $rules, $messages);
                if ($validator->fails()) {
                    return Redirect::back()->withInput()->withErrors($validator);
                }
                $boot->update([
                    'name'=>$data['name'],
                    'username'=>$data['username'],
                    'link'=>$data['link'],
                    'notes'=>$data['notes'],
                ]);
                return $this->success_message(' تم تعديل البوت بنجاح  ');
            } catch (\Exception $e) {
                return $this->exception_message($e);
            }
        }
    }

    public function delete($id)
    {
        $boot = Boot::findOrFail($id);
        $boot->delete();
        return $this->success_message(' تم حذف البوت بنجاح  ');
    }
}
