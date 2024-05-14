<x-app-layout>
  <div class="m-4">
    <a href="{{route('dashboard')}}"><i class="fa-solid fa-angles-left"></i>&nbsp;&nbsp;戻る</a>
  </div>
  <div class="container my-8 mx-auto">
    <p class="text-center text-2xl">予約内容の確認</p>
    <div class="border my-8 w-2/4 mx-auto p-7 grid grid-cols-1 gap-6">
      <x-reserve-confirm :reserve="$reserve" />
    </div>
    <hr class="w-2/4 mx-auto">
    <form action="{{route('reserve.cancel', $reserve['id'])}}" method="post">
      @csrf
      @method('put')
      <button type="submit" class="bg-red-600 hover:bg-red-700 text-white py-3 px-6 rounded block mx-auto mt-6">キャンセル</button>
    </form>
    
  </div>
  
 
</x-app-layout>