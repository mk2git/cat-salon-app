<!-- Modal -->
<div class="modal fade" id="exampleModal{{$courseId}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">
            <i class="fa-solid fa-pen"></i>「 {{$courseName}} 」の編集
          </h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{route('course.update', $courseId)}}" method="post" class="p-4 md:p-5">
                @csrf
                @method('put')
                 <div class="grid gap-4 mb-4 grid-cols-2">
                     <div class="col-span-2">
                         <label for="name" class="form-label">コース名</label>
                         <input type="text" name="course_name" id="name" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" value="{{$courseName}}">
                     </div>
                     <div class="col-span-2 sm:col-span-1">
                         <label for="price" class="form-label">コース料金</label>
                         <input type="number" name="fee" id="price" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" value="{{$courseFee}}">
                     </div>
                     <div class="col-span-2">
                         <label for="description" class="form-label">コース内容</label>
                         <textarea id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" name="description">{{$courseDesc}}</textarea>                    
                     </div>
                 </div>
                 <button type="submit" class="btn btn-success d-block mx-auto w-50">
                     更新
                 </button>
             </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <form action="" method="post">
                @csrf
                @method('delete')
                <button type="button" class="btn btn-danger">削除</button>
            </form>
        </div>
      </div>
    </div>
  </div>