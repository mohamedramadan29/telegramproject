<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Http\Traits\Upload_Images;
use App\Models\admin\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class SupportController extends Controller
{
    use Message_Trait;
    use Upload_Images;

    public function index()
    {
        $messages = Support::where('user_id',Auth::id())->orderby('id', 'desc')->get();
        return view('front.Support.index', compact('messages'));
    }

    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            try {
                $data = $request->all();
                $rules = [
                    'subject' => 'required',
                    'content' => 'required',
                ];
                if ($request->hasFile('images')) {
                    $rules['images'] = 'sometimes|array|max:10'; // تحديد أقصى عدد للصور بـ 10
                    $rules['images.*'] = 'image|mimes:jpg,png,jpeg,webp|max:2048'; // ٢ ميجا اقصي حجم
                }
                $messages = [
                    'subject.required' => ' من فضلك ادخل عنوان الرسالة  ',
                    'content.required' => ' من فضلك ادخل محتوي الرسالة  ',
                    'images.image' => ' من فضلك حدد صورة بشكل صحيح  ',
                    'images.max' => 'يمكنك تحميل حتى 10 صور فقط',
                    'images.*.image' => 'من فضلك حدد صورة بشكل صحيح',
                    'images.*.mimes' => 'الصور يجب أن تكون بإحدى الصيغ التالية: jpg, png, jpeg, webp',
                    'images.*.max' => 'حجم الصورة يجب ألا يتعدى 2 ميجا بايت',
                ];
                $validator = Validator::make($data, $rules, $messages);
                if ($validator->fails()) {
                    return Redirect::back()->withInput()->withErrors($validator);
                }
                $filenames = [];
                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $image) {
                        $filename = $this->saveImage($image, public_path('assets/uploads/support_files'));
                        $filenames[] = $filename;
                    }
                }
                $support = new Support();
                $support->create([
                    'user_id' => Auth::id(),
                    'subject' => $data['subject'],
                    'content' => $data['content'],
                    'attachments' => implode(',', $filenames), // تخزين أسماء الملفات كقائمة مفصولة بفواصل

                ]);
                return $this->success_message(' تم اضافة رسالتك بنجاح سنتواصل معك في اقرب وقت ممكن  ');

            } catch (\Exception $e) {
                return $this->exception_message($e);
            }

        }
        return view('front.Support.add');
    }

    public function update(Request $request, $id)
    {
        $support = Support::findOrFail($id);

        if ($request->isMethod('post')) {
            $data = $request->all();
            $support->update([
                'status' => $data['status'],
            ]);
            return $this->success_message(' تم تعديل حالة الرسالة بنجاح  ');
        }
        return view('front.Support.update', compact('support'));
    }

    public function delete($id)
    {

        $support = Support::findOrFail($id);
        if ($support['attachments'] != '') {
            $images = explode(',', $support['attachments']);
            foreach ($images as $image) {
                $oldimage = public_path('assets/uploads/support_files/' . $image);
                if (file_exists($oldimage)){
                    unlink($oldimage);
                }
            }
        }
        $support->delete();
        return $this->success_message(' تم حذف الرسالة  ');
    }
}
