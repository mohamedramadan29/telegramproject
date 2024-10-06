<div class="modal fade" id="edit_withdraw_{{$boot['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> تعديل بيانات البوت  </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{url('admin/boot/update/'.$boot['id'])}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for=""> الاسم  </label>
                        <input required type="text" name="name" class="form-control" placeholder="اسم البوت  "
                               value="{{$boot['name']}}">
                    </div>
                    <div class="mb-3">
                        <label for=""> الاسم التعريفي  </label>
                        <input required type="text" name="username" class="form-control" placeholder="الاسم التعريفي"
                               value="{{$boot['username']}}">
                    </div>
                    <div class="mb-3">
                        <label for=""> الرابط   </label>
                        <input required type="text" name="link" class="form-control" placeholder="الرابط"
                               value="{{$boot['link']}}">
                    </div>
                    <div class="mb-3">
                        <label for=""> ملاحظات   </label>
                        <textarea name="notes" class="form-control">{{$boot['notes']}}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> رجوع</button>
                    <button type="submit" class="btn btn-primary"> تعديل  </button>
                </div>
            </form>
        </div>
    </div>
</div>
