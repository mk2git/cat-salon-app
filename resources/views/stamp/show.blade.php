<x-app-layout>
  <div class="container mt-10 w-1/2 mx-auto">
    <p class="text-center text-2xl"><i class="fa-solid fa-stamp"></i>&nbsp;&nbsp;スタンプカード</p>
    <div class="border-4 m-6 px-4 pt-4 pb-20">
      <div class="grid grid-cols-5 border">
        @for ($i = 1; $i <= 20; $i++)
          <div class="border w-full h-20 flex justify-center items-center stamp">
            @if(isset($dates[$i - 1]))
              <x-stamp />
              <small class="date">{{ $dates[$i - 1]['date'] }}</small>               
            @endif
          </div>    
        @endfor
      </div>
      <p class="float-end mt-5">{{count($dates)}} / 20</p>
    </div>
    <p class="mt-3 text-center">※20個貯まると次回1,000円OFF</p>
  </div>
</x-app-layout>