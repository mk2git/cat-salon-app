<x-app-layout>
  <p class="m-6 text-2xl border-b w-1/4 text-center">{{$reserve['user_name']}}&nbsp;&nbsp;<small>様</small></p>
  <div class="grid grid-cols-3 gap-2 p-6 mb-8">
    <div class="border mx-auto p-6 grid grid-rows-6 grid-cols-1 drop-shadow-2xl w-3/4">
       <p class="text-center border-b font-bold" style="height: 50px">予約内容</p>
       <x-reserve-confirm :reserve="$reserve" />
    </div>
    <div class="border col-span-2 w-3/4 mx-auto px-6">
      <p class="text-center mt-6 font-bold">カルテ</p>
      <hr class="w-1/4 mx-auto">
      @if ($errors->any())
        <x-error-message />
      @endif
      <form action="{{route('record.store')}}" method="post">
        @csrf
        <input type="hidden" name="user_id" value="{{$reserve['user_id']}}">
        <input type="hidden" name="reserve_id" value="{{$reserve['id']}}">
        <div class="grid grid-rows-8 m-6">
          <div class="grid grid-cols-2 gap-5 mb-6">
            <div>
              <p>
                <i class="fa-solid fa-paw"></i>&nbsp;&nbsp;名前：
                <input type="text" name="cat_name" class="w-full rounded-md border-b border-gray-300 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
              </p>
            </div>
            <div>
              <p>
                <i class="fa-solid fa-paw"></i>&nbsp;&nbsp;猫種：
                <input type="text" name="cat_species" class="w-full rounded-md border-b border-gray-300 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
              </p>
             </div>
          </div>
          <div class="">
            <p>
              <i class="fa-solid fa-paw"></i>&nbsp;&nbsp;本日の体重：
              <input type="text" name="weight" class="w-1/4 rounded-md border-b border-gray-300 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" min="1">&nbsp;&nbsp;kg
            </p>
          </div>
          <div class="">
            <i class="fa-solid fa-paw"></i>&nbsp;&nbsp;ボディチェック内容：
          </div>
          <div class="">
            <p>
              ⚪︎耳：
              <input type="text" name="ear" class="w-3/4 rounded-md border-b border-gray-300 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            </p>
          </div>
          <div>
            <p>
              ⚪︎目：
              <input type="text" name="eye" class="w-3/4 rounded-md border-b border-gray-300 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            </p>
          </div>
          <div>
            <p>
              ⚪︎抜け毛：
              <input type="text" name="hair_loss" class="w-3/4 rounded-md border-b border-gray-300 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            </p>
          </div>
          <div>
            <p>
              ⚪︎毛玉：
              <input type="text" name="hair_ball" class="w-3/4 rounded-md border-b border-gray-300 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            </p>
          </div>
          <div>
            ⚪︎その他：
            <input type="text" name="others" class="w-3/4 rounded-md border-b border-gray-300 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
          </div>
        </div>
        <div>
          <p><i class="fa-solid fa-paw"></i>&nbsp;&nbsp;担当グルーマーからのメッセージ</p>
          <textarea name="message" cols="30" rows="10" class="w-full rounded-md border-b border-gray-300 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
        </div>
        
        <button type="submit" class="block mx-auto bg-teal-600 hover:bg-teal-700 rounded py-3 px-8 text-white font-bold m-6">登録</button>
      </form>
    </div>
  </div>
  
</x-app-layout>