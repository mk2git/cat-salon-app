<x-app-layout>
  <p class="m-6 text-2xl border-b w-1/4 text-center">{{$reserve['user_name']}}&nbsp;&nbsp;<small>様</small></p>
  <div class="grid grid-cols-3 gap-2 p-6 mb-8">
    <div class="mx-auto p-6 drop-shadow-2xl">
      <div class="border-4 rounded border-teal-600 py-6 px-4 mx-auto">
        <p class="text-center border-b font-bold mb-6">予約内容</p>
        <x-reserve-confirm :reserve="$reserve" />
      </div>
       
    </div>
    <div class="col-span-2 w-3/4 mx-auto border-2 rounded border-orange-700 bg-orange-700 p-6">
      <div class="rounded bg-white p-6">
        <p class="text-center mt-6 font-bold">カルテ</p>
        <hr class="w-1/4 mx-auto">
        @if ($errors->any())
          <x-error-message />
        @endif

        @if ($record_list == null)
          <form action="{{route('record.store')}}" method="post">
            @csrf
            <x-record-form :record-list="$record_list" :reserve="$reserve" />
            <button type="submit" class="block mx-auto bg-teal-600 hover:bg-teal-700 rounded py-3 px-8 text-white font-bold m-6">登録</button>
          </form>
        @else
          <form action="" method="post">
            @csrf
            @method('put')
            <x-record-form :record-list="$record_list" :reserve="$reserve" />
            <button type="submit" class="block mx-auto bg-teal-600 hover:bg-teal-700 rounded py-3 px-8 text-white font-bold m-6">更新</button>
          </form>
        @endif
      </div>
    </div>
  </div>
  
</x-app-layout>