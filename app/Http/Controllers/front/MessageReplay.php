<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Models\admin\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class MessageReplay extends Controller
{
    use Message_Trait;
    public function index($id)
    {
        $message = Support::findOrFail($id);
        $message_replaies = \App\Models\admin\MessageReplay::where('message_id',$id)->get();
        return view('front.Support.replay',compact('message','message_replaies'));
    }

    public function store(Request $request,$id)
    {
        $message = Support::findOrFail($id);
        if ($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                'content'=>'required'
            ];
            $messages = [
                'content.required'=>' من فضلك ادخل محتوي الرسالة  ',
            ];
            $validator = Validator::make($data,$rules,$messages);
            if ($validator->fails()){
                return Redirect::back()->withInput()->withErrors($validator);
            }

            $replay = new \App\Models\admin\MessageReplay();
            $replay->message_id = $id;
            $replay->replay = $data['content'];
            $replay->user_replay = 'user';
            $replay->save();
            ///////// Update Message Status
            ///
            $message->update([
                'status'=>'تم اضافة رد'
            ]);
            return $this->success_message(' تم اضافة رد علي الرسالة بنجاح  ');
        }
    }
}
