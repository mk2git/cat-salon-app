<x-app-layout>
  <div class="container mt-8 mx-auto">
    @if (session('message'))
      <x-alert-message :message="session('message')" :type="session('type')" />
    @endif

    @if ($errors->any())
           <x-error-message />
    @endif
    <x-to-dashboard />
    <div class="grid mb-8 grid-cols-1 md:grid-cols-3 gap-7 md:gap-0">
      <div class="mx-3 mx-md-2">
          <p class="text-base lg:text-lg text-center">予約可能日の追加</p>
          <form action="{{route('reserveCreate.store')}}" method="post" class="block w-full mx-auto mt-3">
            @csrf
            <label class="block mx-auto mb-3">
              <span class="block text-sm font-medium text-slate-700">日付</span>
              <input type="date" name="date" class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm shadow-sm placeholder-slate-400
                focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500
                disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none
                invalid:border-pink-500 invalid:text-pink-600
                focus:invalid:border-pink-500 focus:invalid:ring-pink-500
              "/>
            </label>
            <label class="block mx-auto mb-3">
              <span class="block text-sm font-medium text-slate-700">時間</span>
              <input type="time" name="time" class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm shadow-sm placeholder-slate-400
                focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500
                disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none
                invalid:border-pink-500 invalid:text-pink-600
                focus:invalid:border-pink-500 focus:invalid:ring-pink-500
              "/>
            </label>
            <label class="block mx-auto mb-6">
              <span class="block text-sm font-medium text-slate-700">コース選択</span>
              <select name="course_id" id="" class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm shadow-sm placeholder-slate-400
              focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500
              disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none
              invalid:border-pink-500 invalid:text-pink-600
              focus:invalid:border-pink-500 focus:invalid:ring-pink-500">
                <option value="" disabled selected>コースを選択してください</option>
                @foreach ($courses as $course)
                  <option value="{{$course->id}}">{{$course->course_name}}（{{$course->color}}）</option>
                @endforeach
              </select>
            </label>
            <button type="submit" class="py-2 block w-5/12 bg-orange-500 text-white font-semibold rounded-full shadow-md hover:bg-orange-700 focus:outline-none focus:ring focus:ring-violet-400 focus:ring-opacity-75 block mx-auto">追加</button>
          </form>
      </div>
      <div class="col-span-2">
        @if ($courses->isEmpty())
      
        @else
        <div class="flex justify-center">
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
          {{-- FullCalendarを利用する場合は51行目のコードが必要 --}}
          {{-- <div id='calendar' data-events='@json($events)'></div> --}}

          <div class="flex justify-between mx-2">
            <button id="prev" type="button" class="py-2 px-5 bg-green-700 rouded text-white">前の月</button>
            <button id="next" type="button" class="py-2 px-5 bg-green-700 rouded text-white">次の月</button>
          </div>
          <hr>
          <div id="calendar" class="mx-6"></div>
          <x-calendar :events="$events" />
      </div>
    </div>
  </div>
</x-app-layout>