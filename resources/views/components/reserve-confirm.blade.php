<div class=" grid grid-cols-2 gap-6">
  <div class="text-end">日付：</div>
  <div>{{$reserve['date']}}</div>
</div>
<div class=" grid grid-cols-2 gap-6">
  <div class="text-end">時間：</div>
  <div>{{$reserve['time']}}〜</div>
</div>
<div class=" grid grid-cols-2 gap-6">
  <div class="text-end">コース：</div>
  <div>{{$reserve['course_name']}}</div>
</div>
<div class=" grid grid-cols-2 gap-6">
  <div class="text-end">オプション：</div>
  <div>@if ($reserve['option'] == '')
    なし
  @else
    {{$reserve['option']}}
  @endif  </div>
</div>