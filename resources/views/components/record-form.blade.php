<div class="grid grid-rows-8 m-6">
  <div class="grid grid-cols-2 gap-5 mb-6">
    <div>
      <p>
        <i class="fa-solid fa-paw"></i>&nbsp;&nbsp;名前：
        <input type="text" name="cat_name" class="w-full rounded-md border-b border-gray-300 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" value="{{ $recordList['cat_name'] ?? '' }}">
      </p>
    </div>
    <div>
      <p>
        <i class="fa-solid fa-paw"></i>&nbsp;&nbsp;猫種：
        <input type="text" name="cat_species" class="w-full rounded-md border-b border-gray-300 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" value="{{ $recordList['cat_species'] ?? '' }}">
      </p>
    </div>
  </div>
  <div>
    <p>
      <i class="fa-solid fa-paw"></i>&nbsp;&nbsp;本日の体重：
      <input type="text" name="weight" class="w-1/4 rounded-md border-b border-gray-300 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" min="1" value="{{ $recordList['weight'] ?? '' }}">&nbsp;&nbsp;kg
    </p>
  </div>
  <div>
    <i class="fa-solid fa-paw"></i>&nbsp;&nbsp;ボディチェック内容：
  </div>
  <div>
    <p>
      ⚪︎耳：
      <input type="text" name="ear" class="w-3/4 rounded-md border-b border-gray-300 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" value="{{ $recordList['ear'] ?? '' }}">
    </p>
  </div>
  <div>
    <p>
      ⚪︎目：
      <input type="text" name="eye" class="w-3/4 rounded-md border-b border-gray-300 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" value="{{ $recordList['eye'] ?? '' }}">
    </p>
  </div>
  <div>
    <p>
      ⚪︎抜け毛：
      <input type="text" name="hair_loss" class="w-3/4 rounded-md border-b border-gray-300 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" value="{{ $recordList['hair_loss'] ?? '' }}">
    </p>
  </div>
  <div>
    <p>
      ⚪︎毛玉：
      <input type="text" name="hair_ball" class="w-3/4 rounded-md border-b border-gray-300 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" value="{{ $recordList['hair_ball'] ?? '' }}">
    </p>
  </div>
  <div>
    ⚪︎その他：
    <input type="text" name="others" class="w-3/4 rounded-md border-b border-gray-300 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" value="{{ $recordList['others'] ?? '' }}">
  </div>
  <div>
    <p class="text-sm md:text-base"><i class="fa-solid fa-paw"></i>&nbsp;&nbsp;担当グルーマーからのメッセージ</p>
    <textarea name="message" cols="30" rows="10" class="w-full rounded-md border-b border-gray-300 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">{{ $recordList['message'] ?? '' }}</textarea>
  </div>
</div>
