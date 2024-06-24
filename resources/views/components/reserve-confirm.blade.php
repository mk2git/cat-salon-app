<div class=" grid grid-cols-2 gap-1 lg:gap-5">
  <div class="text-end text-sm">日付：</div>
  <div class="sm:text-xs md:text-sm">{{$reserve['date']}}</div>
</div>
<div class=" grid grid-cols-2 gap-5">
  <div class="text-end text-sm">時間：</div>
  <div class="sm:text-xs md:text-sm">{{$reserve['time']}}〜</div>
</div>
<div class=" grid grid-cols-2 gap-5">
  <div class="text-end text-sm">コース：</div>
  <div class="sm:text-xs md:text-sm">{{$reserve['course_name']}}</div>
</div>
<div class=" grid grid-cols-2 gap-5">
  <div class="text-end text-sm">オプション：</div>
  <div class="sm:text-xs md:text-sm">
    @if ($reserve['option'] == '')
      なし
    @else
      {{$reserve['option']}}
    @endif  
  </div>
</div>
<div class=" grid grid-cols-2 gap-5">
  <div class="text-end text-sm">合計金額：</div>
  <div class="sm:text-xs md:text-sm">&yen;{{$reserve['price']}}</div>
</div>