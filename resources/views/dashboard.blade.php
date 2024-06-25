<x-app-layout>
    @if (session('message'))
        <x-alert-message :message="session('message')" :type="session('type')" />
    @endif
    <div class="py-12">
        <div class="sm:px-6 lg:px-8">
            <div class="bg-white border border-orange-600 drop-shadow-xl w-11/12 md:w-100 lg:w-3/4 mx-auto overflow-hidden shadow-sm sm:rounded-lg p-5">
                @can('admin')
                  <p class="mb-3">＜ 本日の予約一覧 ＞</p>
                  <ul class="list-disc list-inside text-xs md:text-base">
                    @php $hasTodayReservations = false; @endphp
                    @foreach ($todayReserveLists as $reserve)
                        @php $hasTodayReservations = true; @endphp
                        @if ($reserve['status'] == config('reserve.cancel'))
                            <li class="mb-3">
                                <span class="line-through decoration-red-500">
                                    {{$reserve['time']}}〜&nbsp;&nbsp;&nbsp;&nbsp;{{$reserve['user_name']}}<small>様</small>&nbsp;&nbsp;&nbsp;&nbsp;{{$reserve['course_name']}} @if (($reserve['option_names']))<small>（オプション：{{$reserve['option_names']}}） </small>@endif                                  
                                </span>
                                <small class="text-red-500 ms-3">キャンセル済み</small>
                            </li>
                        @elseif ($reserve['checkout_status'] == config('reserve.done'))
                            <li class="mb-3">
                                <a href="{{route('record.create', $reserve['id'])}}" class="hover:text-teal-500">
                                    {{$reserve['time']}}〜&nbsp;&nbsp;&nbsp;&nbsp;{{$reserve['user_name']}} <small>様</small>&nbsp;&nbsp;&nbsp;&nbsp;{{$reserve['course_name']}} @if (($reserve['option_names']))
                                     <small>（オプション：{{$reserve['option_names']}}）</small>
                                     @endif
                                </a>
                                <small class="text-blue-700 ms-3">お会計済み</small>
                            </li>
                        @else
                            <li class="mb-3">
                                <a href="{{route('record.create', $reserve['id'])}}" class="hover:text-teal-500">
                                    {{$reserve['time']}}〜&nbsp;&nbsp;&nbsp;&nbsp;{{$reserve['user_name']}} <small>様</small>&nbsp;&nbsp;&nbsp;&nbsp;{{$reserve['course_name']}} @if (($reserve['option_names']))<small>（オプション：{{$reserve['option_names']}}）</small> @endif
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
                                <a href="{{route('reserve.edit', $reserve_list['id'])}}" class="hover:text-teal-400">{{$reserve_list['date']}}&nbsp;&nbsp;&nbsp;&nbsp;{{$reserve_list['time']}}〜&nbsp;&nbsp;&nbsp;&nbsp;{{$reserve_list['course_name']}} @if (($reserve_list['option_names']))<small>（オプション：{{$reserve_list['option_names']}}）</small> @endif</a>
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
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-1 mt-16 text-center flex items-center md:w-11/12 lg:w-10/12 mx-auto">
            <a href="{{route('reserve.index')}}" class="block bg-teal-500 hover:bg-teal-600 text-white py-4 rounded mx-12 sm:text-2xl md:text-base lg:text-2xl md:w-7/12 lg:w-7/12">予約受付</a>
            <a href="{{route('reserveCreate.status')}}" class="block bg-teal-500 hover:bg-teal-600 text-white py-4 rounded mx-12 sm:text-2xl md:text-base lg:text-2xl md:w-7/12 lg:w-7/12">予約状況</a>
            <a href="{{route('checkout.index')}}" class="block bg-teal-500 hover:bg-teal-600 text-white py-4 rounded mx-12 sm:text-2xl md:text-base lg:text-2xl md:w-7/12 lg:w-7/12 checkout-button"><span class="count">{{$checkout_count}}</span>お会計</a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-1 mt-16 text-center flex items-center">
            <a href="{{route('reserve.index')}}" class="block bg-rose-600 hover:bg-rose-700 text-white py-4 rounded mx-12 sm:text-2xl md:text-base lg:text-2xl md:w-7/12 lg:w-7/12">予約受付</a>
            <a href="{{route('record.userRecords', Auth::user()->id)}}" class="block bg-rose-600 hover:bg-rose-700 text-white py-4 rounded mx-12 sm:text-2xl md:text-base lg:text-2xl md:w-7/12 lg:w-7/12"><i class="fa-solid fa-list"></i>&nbsp;&nbsp;サロン履歴</a>
            <a href="{{route('stamp.show', Auth::user()->id)}}" class="block bg-rose-600 hover:bg-rose-700 text-white py-4 rounded mx-12 sm:text-2xl md:text-base lg:text-2xl md:w-7/12 lg:w-7/12"><i class="fa-solid fa-stamp"></i>&nbsp;&nbsp;スタンプ</a>
        </div>
    @endcan
    </div>
</x-app-layout>
