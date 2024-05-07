<script>
  $(document).ready(function() {
      $('.edit-course').click(function() {
          var courseId = $(this).data('course-id');
          $.get('/course/' + courseId, function(data) {
              $('#crud-modal' + courseId).find('.modal-body').html(data);
              $('#crud-modal' + courseId).modal('show');
          });
      });
  });
</script>

<div id="crud-modal{{$courseId}}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
  <div class="relative p-4 w-full max-w-md max-h-full">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
          <!-- Modal header -->
          <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                <i class="fa-solid fa-pen"></i>「 {{$courseName}} 」の編集
              </h3>
              <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal{{$courseId}}">
                  <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                  </svg>
                  <span class="sr-only">Close modal</span>
              </button>
          </div>
          <!-- Modal body -->
          <form action="{{route('course.update', $courseId)}}" method="post" class="p-4 md:p-5">
             @csrf
             @method('put')
              <div class="grid gap-4 mb-4 grid-cols-2">
                  <div class="col-span-2">
                      <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">コース名</label>
                      <input type="text" name="course_name" id="name" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" value="{{$courseName}}">
                  </div>
                  <div class="col-span-2 sm:col-span-1">
                      <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">コース料金</label>
                      <input type="number" name="fee" id="price" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" value="{{$courseFee}}">
                  </div>
                  <div class="col-span-2">
                      <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">コース内容</label>
                      <textarea id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" name="description">{{$courseDesc}}</textarea>                    
                  </div>
              </div>
              <button type="submit" >
                  更新
              </button>
          </form>
      </div>
  </div>
</div> 