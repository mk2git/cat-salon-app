<x-app-layout>
  <div class="m-4">
    <a href="{{route('reserveCreate.index')}}"><i class="fa-solid fa-angles-left"></i>&nbsp;&nbsp;戻る</a>
  </div>
  
  <div class="my-8">
    <p class="text-lg text-center"><i class="fa-solid fa-pencil"></i>&nbsp;&nbsp;予約可能日の編集</p>
    <form action="{{route('reserveCreate.update', $reserve->id)}}" method="post" class="block w-80 mx-auto mt-3">
        @csrf
        @method('put')
        <label class="block mx-auto mb-3">
          <span class="block text-sm font-medium text-slate-700">日付</span>
          <input type="date" name="date" value="{{$reserve->date}}" class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm shadow-sm placeholder-slate-400
            focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500
            disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none
            invalid:border-pink-500 invalid:text-pink-600
            focus:invalid:border-pink-500 focus:invalid:ring-pink-500
          "/>
        </label>
        <label class="block mx-auto mb-3">
          <span class="block text-sm font-medium text-slate-700">時間</span>
          <input type="time" name="time" value="{{$reserve->time}}" class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm shadow-sm placeholder-slate-400
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
                <option value="{{$course->id}}" @if($reserve->course_id == $course->id) selected @endif>{{$course->course_name}}</option>
              @endforeach
          </select>
        </label>
        <button type="submit" class="py-2 px-5 bg-green-500 text-white font-semibold rounded-full shadow-md hover:bg-green-700 focus:outline-none focus:ring focus:ring-violet-400 focus:ring-opacity-75 block mx-auto">変更</button>
     </form>
  </div>
  <hr class="w-2/4 mx-auto">
  <form action="{{route('reserveCreate.destroy', $reserve->id)}}" method="post">
    @csrf
    @method('delete')
    <button type="submit" class="py-2 bg-red-500 text-white font-semibold rounded-full shadow-md hover:bg-red-700 focus:outline-none focus:ring focus:ring-violet-400 focus:ring-opacity-75 block mx-auto w-1/4 mt-8 text-center">削除しますか？</buttom>
  </form>
  
</x-app-layout>