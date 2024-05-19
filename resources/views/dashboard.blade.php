<x-app-layout>
    @if (session('message'))
        <x-alert-message :message="session('message')" :type="session('type')" />
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-orange-600 drop-shadow-xl w-3/4 mx-auto overflow-hidden shadow-sm sm:rounded-lg p-5">
                @can('admin')
                  <p class="mb-3">本日の予約一覧</p>
                  <ul class="list-disc list-inside">
                    @php $hasTodayReservations = false; @endphp
                    @foreach ($todayReserveLists as $reserve)
                        @php $hasTodayReservations = true; @endphp
                        @if ($reserve['status'] == config('reserve.cancel'))
                            <li class="mb-3">
                                <span class="line-through decoration-red-500">
                                    {{$reserve['time']}}〜&nbsp;&nbsp;&nbsp;&nbsp;{{$reserve['user_name']}} <small>様</small>&nbsp;&nbsp;&nbsp;&nbsp;{{$reserve['course_name']}} @if (($reserve['option_names']))（オプション：{{$reserve['option_names']}}） @endif                                  
                                </span>
                                <span class="text-red-500 ms-3">キャンセル済み</span>
                            </li>
                        @elseif ($reserve['checkout_status'] == config('reserve.done'))
                            <li class="mb-3">
                                <a href="{{route('record.create', $reserve['id'])}}" class="hover:text-teal-500">
                                    {{$reserve['time']}}〜&nbsp;&nbsp;&nbsp;&nbsp;{{$reserve['user_name']}} <small>様</small>&nbsp;&nbsp;&nbsp;&nbsp;{{$reserve['course_name']}} @if (($reserve['option_names']))（オプション：{{$reserve['option_names']}}） @endif
                                </a>
                                <span class="text-blue-700 ms-3">お会計済み</span>
                            </li>
                        @else
                            <li class="mb-3">
                                <a href="{{route('record.create', $reserve['id'])}}" class="hover:text-teal-500">
                                    {{$reserve['time']}}〜&nbsp;&nbsp;&nbsp;&nbsp;{{$reserve['user_name']}} <small>様</small>&nbsp;&nbsp;&nbsp;&nbsp;{{$reserve['course_name']}} @if (($reserve['option_names']))（オプション：{{$reserve['option_names']}}） @endif
                                </a>
                            </li>
                        @endif 
                    @endforeach
                    @if (!$hasTodayReservations)
                      <p>本日の予約は入っておりません</p>
                    @endif
                  </ul>
                @else
                  <p class="mb-3">予約一覧</p>
                  <ul class="list-disc list-inside">
                    @php $hasReservations = false; @endphp
                    @foreach ($unique_reserve_lists as $reserve_list)
                        @if($reserve_list['user_id'] == Auth::user()->id)   
                        @php $hasReservations = true; @endphp                      
                            <li class="mb-3">
                                <a href="{{route('reserve.edit', $reserve_list['id'])}}" class="hover:text-teal-400">{{$reserve_list['date']}}&nbsp;&nbsp;&nbsp;&nbsp;{{$reserve_list['time']}}〜&nbsp;&nbsp;&nbsp;&nbsp;{{$reserve_list['course_name']}} @if (($reserve_list['option_names']))（オプション：{{$reserve_list['option_names']}}） @endif</a>
                            </li>
                        @endif
                    @endforeach
                    @if (!$hasReservations)
                      <p>現在予約はありません</p>
                    @endif
                  </ul>               
                @endcan
            </div>
        <div>
     </div>

        @can('admin')    
            <div class="flex flex-wrap justify-center mt-16">
                <a href="{{route('reserve.index')}}" class="block bg-teal-500 hover:bg-teal-600 text-white py-5 px-10 rounded mx-12 text-2xl">予約受付</a>
                <a href="{{route('reserveCreate.status')}}" class="block bg-teal-500 hover:bg-teal-600 text-white py-5 px-10 rounded mx-12 text-2xl">予約状況</a>
                <a href="{{route('checkout.index')}}" class="block bg-teal-500 hover:bg-teal-600 text-white py-5 px-10 rounded mx-12 text-2xl checkout-button"><span class="count">{{$checkout_count}}</span>お会計</a>
            </div>
        @endcan
    </div>
</x-app-layout>
