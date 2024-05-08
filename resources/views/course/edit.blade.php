<x-app-layout>
  <div class="m-4">
    <a href="{{route('course.index')}}"><i class="fa-solid fa-angles-left"></i>&nbsp;&nbsp;戻る</a>
  </div>
  <div class="m-8 w-2/4 mx-auto">
    <p class="text-center"><i class="fa-solid fa-pencil"></i>「 {{$course->course_name}} 」の内容の修正</p>
    <form action="{{route('course.update', $course->id)}}" method="post" class="p-4 md:p-5">
      @csrf
      @method('put')
       <div class="grid gap-4 mb-4 grid-cols-2">
           <div class="col-span-2">
               <label for="name" class="form-label">コース名</label>
               <input type="text" name="course_name" id="name" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" value="{{$course->course_name}}">
           </div>
           <div class="col-span-2 sm:col-span-1">
               <label for="price" class="form-label">コース料金</label>
               <input type="number" name="fee" id="price" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" value="{{$course->fee}}">
           </div>
           <div class="col-span-2">
               <label for="description" class="form-label">コース内容</label>
               <textarea id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" name="description">{{$course->description}}</textarea>                    
           </div>
       </div>
       <button type="submit" class="py-2 px-5 bg-green-700 text-white font-semibold rounded-full shadow-md hover:bg-green-800 focus:outline-none focus:ring focus:ring-violet-400 focus:ring-opacity-75 block mx-auto w-2/4 my-4">
           更新
       </button>
   </form>

   <hr>
   <form action="{{route('course.destroy', $course->id)}}" method="post">
      @csrf
      @method('delete')
      <button type="submit" class="py-2 px-5 bg-red-500 text-white font-semibold rounded-full shadow-md hover:bg-red-700 focus:outline-none focus:ring focus:ring-violet-400 focus:ring-opacity-75 block mx-auto mt-6">削除しますか？</button>
    </form>
  </div>
</x-app-layout>