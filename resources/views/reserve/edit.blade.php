<x-app-layout>
  <div class="m-4">
    <a href="{{route('dashboard')}}"><i class="fa-solid fa-angles-left"></i>&nbsp;&nbsp;戻る</a>
  </div>
  {{-- @dd($reserve['id']) --}}
  <div class="container my-8 mx-auto">
    <p class="text-center text-2xl">予約内容の確認</p>
    <div class="border my-8 w-2/4 mx-auto p-7 grid grid-cols-1 gap-6 ">
      <div class=" grid grid-cols-2 gap-6">
        <div class="text-end">日付：</div>
        <div>{{$reserve['date']}}</div>
      </div>
      <div class=" grid grid-cols-2 gap-6">
        <div class="text-end">時間：</div>
        <div>{{$reserve['time']}}〜</div>
      </div>
      <div class=" grid grid-cols-2 gap-6">
        <div class="text-end">コース：</div>
        <div>{{$reserve['course_name']}}</div>
      </div>
      <div class=" grid grid-cols-2 gap-6">
        <div class="text-end">オプション：</div>
        <div>@if ($reserve['option'] == '')
          なし
        @else
          {{$reserve['option']}}
        @endif  </div>
      </div>
      <div class=" grid grid-cols-2 gap-6">
        <div class="text-end">合計金額：</div>
        <div>{{$reserve['price']}}</div>
      </div>
    </div>
    <hr class="w-2/4 mx-auto">
    <form action="{{route('reserve.cancel', $reserve['id'])}}" method="post">
      @csrf
      @method('put')
      <button type="submit" class="bg-red-600 hover:bg-red-700 text-white p-3 rounded block mx-auto mt-6">キャンセル</button>
    </form>
    
  </div>
  
 
</x-app-layout>