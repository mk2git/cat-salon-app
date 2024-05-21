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