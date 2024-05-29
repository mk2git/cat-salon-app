<x-app-layout>
  <a href="javascript:history.back()" class="block mt-6 ms-5"><i class="fa-solid fa-angles-left"></i>&nbsp;戻る</a>
  <div class="mt-10 p-10 grid grid-cols-2 gap-2">
    <div class="">
      <div class="border-8 p-6 w-3/4 mx-auto">
        <p class="mb-4 text-2xl">
          <i class="fa-solid fa-user"></i>&nbsp;&nbsp;{{$user_name}}<small>様</small>
        </p>
        <p>飼い猫：</p>
        <ul class="ml-5">
          @foreach ($cats as $cat)
            <li>
              <small>{{$cat->cat_name}}（{{$cat->cat_species}}）</small>
            </li>
          @endforeach
          </ul>
      </div>
      <div class="border-4 m-6 px-4 pt-4 pb-18 w-11/12 mx-auto">
        <p class="text-center"><i class="fa-solid fa-stamp"></i>&nbsp;&nbsp;スタンプカード</p>
        <x-stamp-card :dates="$dates" />
        <p class="float-end mt-5">{{count($dates)}} / 20</p>
        <br>
        <br>
        {{ $stamp_done_reserves->links() }}
      </div>
    </div>
    <div class="">
      <div class="border rounded p-8 mb-10">
        <p class="mb-2 text-bold"><i class="fa-solid fa-list"></i>&nbsp;&nbsp;予約一覧</p>
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
        <p class="mb-2 text-bold">
          <i class="fa-solid fa-list"></i>&nbsp;&nbsp;サロン履歴
          <a href="{{route('record.userRecords', $user_id)}}" class="float-right hover:text-gray-500"><small>その他の履歴 ＞＞</small></a>
        </p>
        <hr>
        <ul class="mt-6">
          @php $hasReservationRecords = false; @endphp
          @foreach ($done_reserve_records as $done_reserve_record)
            @php $hasReservationRecords = true; @endphp
            <li class="mb-2">
              <a href="{{route('user.showRecord', $done_reserve_record['reserve_id'])}}" class="hover:text-blue-500 underline decoration-blue-500 hover:decoration-2">
                {{$done_reserve_record['date']}}&nbsp;&nbsp;&nbsp;&nbsp;{{$done_reserve_record['course_name']}}
                @if (($done_reserve_record['options']))（オプション：{{$done_reserve_record['options']}}） @endif
              </a>
            </li>
          @endforeach
          @if (!$hasReservationRecords)
            <p>サロン履歴はまだありません</p>
          @endif
        </ul>
      </div>
    </div>
  </div>
</x-app-layout>