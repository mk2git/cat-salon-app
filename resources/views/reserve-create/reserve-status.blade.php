<x-app-layout>
  <div class="container m-8 mx-auto">
    <h2 class="text-center mt-6 text-2xl">現在の予約状況</h2>
    <div class="flex justify-between">
      <button id="prev" type="button" class="py-2 px-5 bg-green-500 rouded text-white">前の月</button>
      <button id="next" type="button" class="py-2 px-5 bg-green-500 rouded text-white">次の月</button>
    </div>
    <hr>
    <div id="calendar"></div>
    <x-calendar :events="$events" />
  </div>
  
</x-app-layout>