<x-app-layout>
  <x-to-dashboard />
  <div class="container my-8 md:w-11/12 lg:w-10/12 mx-1 md:mx-auto">
    <h2 class="text-center mt-6 text-xl md:text-2xl">現在の予約状況</h2>
    <p class="text-end my-3 me-3 text-sm md:text-base">
      <span class="p-1 text-red-700"><i class="fa-solid fa-check"></i></span>・・・予約済み
    </p>
    @if ($courses->isEmpty())
      
    @else
    <div class="flex justify-center mt-4 md:mt-8">
      <div class="grid grid-cols-3 sm:w-9/12 md:w-9/12 lg:w-3/4">
        @foreach ($courses as $course)
          <p class="mb-2 text-center">
            <span class="inline-block course-color w-3 h-3 mr-1 bg-{{$course->color}}-300 hover:bg-{{$course->color}}-500"></span>
            <small class="course-name-font">{{$course->course_name}}</small>
          </p>
        @endforeach
      </div>
    </div>
    @endif
    <div class="flex justify-between border-b">
      <button id="prev" type="button" class="py-2 px-5 bg-green-700 rouded text-white">前の月</button>
      <button id="next" type="button" class="py-2 px-5 bg-green-700 rouded text-white">次の月</button>
    </div>
    <div id="calendar" class="mx-6"></div>
    <x-reserve-status-calendar :events="$events" />
  </div>
  
</x-app-layout>