<x-app-layout>
  
  <div class="container mt-8 mx-auto">
    @if (session('message'))
      <x-alert-message :message="session('message')" />
    @endif

    @if ($errors->any())
           <x-error-message />
    @endif

    <div class="grid gap-6 grid-cols-2">
      <div>
        <form action="{{route('course.store')}}" method="post" class="block w-80 mx-auto mt-3">
          @csrf
          <label class="block mx-auto mb-3">
            <span class="block text-sm font-medium text-slate-700">コース名</span>
            <input type="text" name="course_name" class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm shadow-sm placeholder-slate-400
              focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500
              disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none
              invalid:border-pink-500 invalid:text-pink-600
              focus:invalid:border-pink-500 focus:invalid:ring-pink-500
            "/>
          </label>
          <label class="block mx-auto mb-3">
            <span class="block text-sm font-medium text-slate-700">料金</span>
            <input type="number" name="fee" class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm shadow-sm placeholder-slate-400
              focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500
              disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none
              invalid:border-pink-500 invalid:text-pink-600
              focus:invalid:border-pink-500 focus:invalid:ring-pink-500
            "/>
          </label>
          <label class="block mx-auto mb-6">
            <span class="block text-sm font-medium text-slate-700">コース内容</span>
            <textarea id="message" name="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="コース内容を入力してください"></textarea>
          </label>
          <button type="submit" class="py-2 px-5 bg-orange-500 text-white font-semibold rounded-full shadow-md hover:bg-orange-700 focus:outline-none focus:ring focus:ring-violet-400 focus:ring-opacity-75 block mx-auto">登録</button>
        </form>
      </div>
      <div class="container mx-auto mt-6">
        @foreach ($courses as $course)
        <div class="">
          <button type="button" class="block bg-amber-300 hover:bg-amber-400 font-medium rounded-lg shadow-lg hover:drop-shadow-xl m-3 edit-course w-full" data-bs-toggle="modal" data-bs-target="#exampleModal{{$course->id}}">
            <div class="m-6">
              <p class="text-2xl">{{$course->course_name}}</p>
              <p class="mt-3"><small>料金：</small>&yen;{{number_format($course->fee)}}</p>
              <p><small>コース内容：</small>{{$course->description}}</p>
            </div>
          </button>
          <x-modal-course-edit :course-id="$course->id" :course-name="$course->course_name" :course-fee="$course->fee" :course-desc="$course->description" />
          </div>  
        @endforeach
      </div>
    </div>      
  </div>  
</x-app-layout>