<x-app-layout>
  <div class="container mt-8 mx-auto">
    <h2 class="text-center text-2xl">どの予約をしますか？</h2>
    <div class="flex justify-between">
      <button id="prev" type="button" class="py-2 px-5 bg-green-700 rouded text-white">前の月</button>
      <button id="next" type="button" class="py-2 px-5 bg-green-700 rouded text-white">次の月</button>
    </div>
    <hr>
    <div id="calendar" class="mx-6"></div>
    <x-reserve-calendar :events="$events" />
  </div>
</x-app-layout>