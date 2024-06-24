<x-app-layout>
  <div class="m-4">
    <x-history-back />
  </div>
  <div class="m-8 sm:w-11/12 md:w-3/4 lg:w-2/4 mx-auto">
    <p class="text-center"><i class="fa-solid fa-pencil"></i>「 {{$one_course->course_name}} 」の内容の修正</p>
    <form action="{{route('course.update', $one_course->id)}}" method="post" class="p-4 md:p-5">
      @csrf
      @method('put')
       <div class="grid gap-4 mb-4 grid-cols-2">
           <div class="col-span-2">
               <label for="name" class="form-label">コース名</label>
               <input type="text" name="course_name" id="name" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" value="{{$one_course->course_name}}">
           </div>
           <div class="col-span-2 sm:col-span-1">
               <label for="price" class="form-label">コース料金</label>
               <input type="number" name="fee" id="price" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" value="{{$one_course->fee}}">
           </div>
           <div class="col-span-2">
               <label for="description" class="form-label">コース内容</label>
               <textarea id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" name="description">{{$one_course->description}}</textarea>                    
           </div>
           <div class="col-span-2 sm:col-span-1">
              <label for="color" class="form-label">色分け</label>
              <div class="grid grid-cols-3 gap-3 md:flex md:gap-6">         
                <div>
                  <input type="radio" name="color" id="emerald" value="emerald"{{ in_array('emerald', array_column($selected_colors, 'color')) ? 'disabled' : '' }} @if($one_course->color == 'emerald') checked @endif>
                  <label for="emerald" class="bg-emerald-300 p-1 rounded">emerald</label>
                </div>
                <div>
                    <input type="radio" name="color" id="yellow" value="yellow"{{ in_array('yellow', array_column($selected_colors, 'color')) ? 'disabled' : '' }} @if($one_course->color == 'yellow') checked @endif>
                    <label for="yellow" class="bg-yellow-300 p-1 rounded">yellow</label>
                </div>
                <div>
                    <input type="radio" name="color" id="blue" value="blue"{{ in_array('blue', array_column($selected_colors, 'color')) ? 'disabled' : '' }} @if($one_course->color == 'blue') checked @endif>
                    <label for="blue" class="bg-blue-300 p-1 rounded">blue</label>
                </div>
                <div>
                    <input type="radio" name="color" id="teal" value="teal"{{ in_array('teal', array_column($selected_colors, 'color')) ? 'disabled' : '' }} @if($one_course->color == 'teal') checked @endif>
                    <label for="teal" class="bg-teal-300 p-1 rounded">teal</label>
                </div>
                <div>
                    <input type="radio" name="color" id="orange" value="orange"{{ in_array('orange', array_column($selected_colors, 'color')) ? 'disabled' : '' }} @if($one_course->color == 'orange') checked @endif>
                    <label for="orange" class="bg-orange-300 p-1 rounded">orange</label>
                </div>
              </div>
            </div>
          </div>
        <button type="submit" class="py-2 px-5 bg-green-700 text-white font-semibold rounded-full shadow-md hover:bg-green-800 focus:outline-none focus:ring focus:ring-violet-400 focus:ring-opacity-75 block mx-auto w-2/4 my-4">
           更新
        </button>
      </form>

   <hr class="w-3/4 mx-auto">
   <form action="{{route('course.destroy', $one_course->id)}}" method="post">
      @csrf
      @method('delete')
      <button type="submit" class="py-2 px-5 bg-red-500 text-white font-semibold rounded-full shadow-md hover:bg-red-700 focus:outline-none focus:ring focus:ring-violet-400 focus:ring-opacity-75 block mx-auto mt-6">削除しますか？</button>
    </form>
  </div>
</x-app-layout>