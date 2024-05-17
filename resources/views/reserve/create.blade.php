<x-app-layout>
  <div class="m-4">
    <a href="{{route('reserve.index')}}"><i class="fa-solid fa-angles-left"></i>&nbsp;&nbsp;戻る</a>
  </div>
  <div class="container mt-8 mx-auto">
    <h2 class="text-center text-2xl mb-5">予約内容</h2>
    <form action="{{route('reserve.store')}}" method="post">
      @csrf
      <div class="border w-2/4 mx-auto p-5 text-center">
        <p class="mb-4">日付：{{$reserve->date}}</p>
        <p class="mb-4">時間：{{$reserve->time}}</p>
        <p class="mb-8">コース内容：{{$reserve->course->course_name}}</p>
        <small>ご希望のオプションがありましたら、下記から選択してください。（複数選択可）</small>
        <label class="block mx-auto mb-6">
          <p class="font-medium my-2">オプション</p>
          <div class="flex justify-center">
            @foreach ($reserve_options as $reserve_option)
            <div class="me-4">
              <input type="checkbox" id="{{$reserve_option->name}}" name="reserve_option[{{$reserve_option->id}}]" value="{{$reserve_option->id}}" class="mt-1 border border-slate-300 rounded-md text-sm shadow-sm placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500
            "/>
              <label for="{{$reserve_option->name}}">{{$reserve_option->name}}</label>
            </div>              
            @endforeach
          </div>
        </label>
        @can('admin')       
        <hr>
          <label class="block mx-auto mb-6 mt-5">
            <p class="font-medium my-2">どの会員様の予約でしょうか？</p>
            <div class="flex justify-center">
              @foreach ($users as $user)
              <div class="me-4">
                <input type="radio" id="user_{{$user->id}}" name="user_id" value="{{$user->id}}" class="mt-1 border border-slate-300 rounded-md text-sm shadow-sm placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500
              "/>
                <label for="user_{{$user->id}}">{{$user->name}}</label>
              </div>              
              @endforeach
            </div>
          </label>
        @endcan
         <button type="submit" class="py-2 px-5 bg-orange-500 text-white font-semibold rounded-full shadow-md hover:bg-orange-700 focus:outline-none focus:ring focus:ring-violet-400 focus:ring-opacity-75 block mx-auto">予約確定</button>
      </div>
      <input type="hidden" name="reserve_create_id" value="{{$reserve->id}}">
      @can('general')
        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
      @endcan
      
    </form>
  </div>
</x-app-layout>