<x-app-layout>
  <x-history-back />
  <div class="container mt-8 mx-auto">
    <h2 class="text-center text-base md:text-2xl">どの予約をしますか？</h2>
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
    <div class="mt-4 sm:w-100 md:w-11/12 md:mx-auto">
      <div class="flex justify-between">
        <button id="prev" type="button" class="py-2 px-5 bg-green-700 rouded text-white">前の月</button>
        <button id="next" type="button" class="py-2 px-5 bg-green-700 rouded text-white">次の月</button>
      </div>
      <hr>
      <div id="calendar" class="mx-6"></div>
      <x-reserve-calendar :events="$events" />
    </div>
  </div>
</x-app-layout>