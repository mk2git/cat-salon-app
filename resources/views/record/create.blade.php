<x-app-layout>
  <x-to-dashboard />
  <p class="m-6 text-2xl border-b md:w-4/12 lg:w-1/4 text-center">{{$reserve['user_name']}}&nbsp;&nbsp;<small>様</small></p>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-2 mb-8">
    <div class="p-2 drop-shadow-2xl">
      <div class="border-4 rounded border-teal-600 py-6 px-4 mx-auto">
        <p class="text-center border-b font-bold mb-6">予約内容</p>
        <x-reserve-confirm :reserve="$reserve" />
      </div>
    </div>
    <div class="col-span-2 w-100 md:w-11/12 lg:w-10/12 mx-2 md:mx-auto border-1 rounded border-orange-800 bg-orange-800 p-4">
      <div class="rounded bg-white py-4 p-md-4 p-lg-6">
        <p class="text-center mt-2 font-bold"><i class="fa-regular fa-clipboard"></i>&nbsp;&nbsp;カルテ</p>
        <hr class="w-1/4 mx-auto">
        @if ($errors->any())
          <x-error-message />
        @endif

        @if ($record_list == null)
          <form action="{{route('record.store')}}" method="post">
            @csrf
            <input type="hidden" name="user_id" value="{{ $reserve['user_id'] }}">
            <input type="hidden" name="reserve_id" value="{{ $reserve['id'] }}">
            <x-record-form :record-list="$record_list" />
            <button type="submit" class="block w-5/12 lg:w-4/12 mx-auto bg-teal-600 hover:bg-teal-700 rounded py-3 px-8 text-white font-bold md:mb-6">登録</button>
          </form>
        @else
          <form action="{{route('record.update')}}" method="post">
            @csrf
            @method('put')
            <input type="hidden" name="user_id" value="{{ $reserve['user_id'] }}">
            <input type="hidden" name="reserve_id" value="{{ $reserve['id'] }}">
            <x-record-form :record-list="$record_list" />
            <button type="submit" class="block mx-auto bg-teal-600 hover:bg-teal-700 rounded py-3 px-8 text-white font-bold m-6">更新</button>
          </form>
        @endif
      </div>
    </div>
  </div>
  
</x-app-layout>