<x-admin-layout>
  <div class="container mt-8 mx-auto">
    @if (session('message'))
      <x-alert-message :message="session('message')" />
    @endif

    @if ($errors->any())
           <x-error-message />
    @endif
    <div class="grid gap-6 grid-cols-2">
      <div>
          <p class="text-lg text-center">予約可能日の追加</p>
          <form action="{{route('reserveCreate.store')}}" method="post" class="block w-80 mx-auto mt-3">
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
                  <option value="{{$course->id}}">{{$course->course_name}}</option>
                @endforeach
              </select>
            </label>
            <button type="submit" class="py-2 px-5 bg-orange-500 text-white font-semibold rounded-full shadow-md hover:bg-orange-700 focus:outline-none focus:ring focus:ring-violet-400 focus:ring-opacity-75 block mx-auto">追加</button>
          </form>
      </div>
      <div>
        <div id='calendar' data-events='@json($events)'></div>
      </div>
    </div>
   
  </div>
</x-admin-layout>