<x-app-layout>
  <x-to-dashboard />
  <p class="mt-10 text-base md:text-2xl text-center mb-6"><i class="fa-regular fa-clipboard"></i>&nbsp;&nbsp;サロン履歴一覧</p>
  <div class="border rounded p-3 md:p-8 lg:p-7 sm:w-11/12 md:w-3/4 lg:w-1/2 mx-2 md:mx-auto">
    <ul class="mt-6">
      @php $hasReservationRecords = false; @endphp
      @foreach ($done_reserve_records as $done_reserve_record)
        @php $hasReservationRecords = true; @endphp
        <li class="mb-2">
          <a href="{{route('user.showRecord', $done_reserve_record['reserve_id'])}}" class="hover:text-blue-500 underline decoration-blue-500 hover:decoration-2">
            {{$done_reserve_record['date']}}&nbsp;&nbsp;&nbsp;&nbsp;{{$done_reserve_record['course_name']}}
            @if ($done_reserve_record['options'])
              <small>（ {{$done_reserve_record['options']}}）</small>
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