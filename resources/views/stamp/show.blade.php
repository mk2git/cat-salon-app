<x-app-layout>
  <x-to-dashboard />
  <div class="container mt-10 sm:w-100 md:w-8/12 lg:w-1/2 sm:m-2 md:mx-auto">
    <p class="text-center text-base md:text-2xl"><i class="fa-solid fa-stamp"></i>&nbsp;&nbsp;スタンプカード</p>
    <div class="border-4 m-4 px-4 pt-4 pb-20">
      <x-stamp-card :dates="$dates" />
      <p class="float-end mt-5">{{count($dates)}} / 20</p>
      {{$done_reserves->links()}}
    </div>
    <p class="mt-3 text-center">※20個貯まると次回1,000円OFF</p>
  </div>
</x-app-layout>