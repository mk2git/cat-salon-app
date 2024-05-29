<x-app-layout>
  <div class="m-4">
    <a href="{{route('reserveCreate.status')}}"><i class="fa-solid fa-angles-left"></i>&nbsp;&nbsp;戻る</a>
  </div>

  <div class="container mx-auto">
    <p class="text-center text-2xl mb-6"><i class="fa-solid fa-pencil"></i>&nbsp;&nbsp;予約確認</p>
    <div class="border my-10 w-2/4 mx-auto p-7 grid grid-cols-1 gap-6">
      <p class=" border-b-2 mb-1"><span class="font-bold">{{$reserve['user_name']}}</span>&nbsp;&nbsp;様の予約内容</p>
      <x-reserve-confirm :reserve="$reserve" />
    </div>
    <hr class="w-2/4 mx-auto">
    <form action="{{route('reserve.cancel', $reserve['id'])}}" method="post">
      @csrf
      @method('put')
      <button type="submit" class="bg-red-600 hover:bg-red-700 block mx-auto text-white py-3 px-6 rounded mt-8">キャンセル</button>
    </form>
  </div>
</x-app-layout>