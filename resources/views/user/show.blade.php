<x-app-layout>
  <div class="mt-10 p-10 grid grid-cols-3 gap-2">
    <div class="">
      <div class="border-8 p-6 w-3/4 mx-auto">
        <p class="mb-4 text-2xl">
          <i class="fa-solid fa-user"></i>&nbsp;&nbsp;{{$user_name}}<small>様</small>
        </p>
        <p>飼い猫：</p>
        <ul class="ml-5">
          @foreach ($cats as $cat)
            <li>{{$cat->cat_name}}（{{$cat->cat_species}}）</li>
          @endforeach
          </ul>
      </div>
    </div>
    <div class="col-span-2">
      <div class="border rounded p-8 mb-10">
        <p class="mb-2 text-bold">予約一覧</p>
        <ul>
          @php $hasReservations = false; @endphp
          @foreach ($reserves as $reserve)
            @php $hasReservations = true; @endphp
            <li class="mb-2">
              <a href="{{route('reserveCreate.showDetail', $reserve['reserve_create_id'])}}" class="hover:text-teal-500 underline decoration-teal-500 hover:decoration-2">
                {{$reserve['date']}}&nbsp;&nbsp;&nbsp;&nbsp;{{$reserve['time']}}〜&nbsp;&nbsp;&nbsp;&nbsp;{{$reserve['course_name']}}
                @if (($reserve['option_names']))（オプション：{{$reserve['option_names']}}） @endif
              </a>
            </li>
          @endforeach
          @if (!$hasReservations)
            <p>予約はありません</p>
          @endif
        </ul>
      </div>
      <div class="border rounded p-10">
        <p>予約履歴</p>
      </div>
    </div>
  </div>
</x-app-layout>