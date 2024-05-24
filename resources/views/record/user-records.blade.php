<x-app-layout>
  <p class="mt-10 text-2xl text-center mb-6"><i class="fa-regular fa-clipboard"></i>&nbsp;&nbsp;サロン履歴一覧</p>
  <div class="border rounded p-10 w-1/2 mx-auto">
    <ul class="mt-6">
      @php $hasReservationRecords = false; @endphp
      @foreach ($done_reserve_records as $done_reserve_record)
        @php $hasReservationRecords = true; @endphp
        <li class="mb-2">
          <a href="{{route('user.showRecord', $done_reserve_record['reserve_id'])}}" class="hover:text-blue-500 underline decoration-blue-500 hover:decoration-2">
            {{$done_reserve_record['date']}}&nbsp;&nbsp;&nbsp;&nbsp;{{$done_reserve_record['course_name']}}
            @if ($done_reserve_record['options'])
             （ {{$done_reserve_record['options']}}）
            @endif
          </a>
        </li>
      @endforeach
      @if (!$hasReservationRecords)
        <p>サロン履歴はまだありません</p>
      @endif
    </ul>
    {{$done_reserves->links()}}
  </div>
</x-app-layout>