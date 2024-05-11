<x-app-layout>
    @if (session('message'))
        <x-alert-message :message="session('message')" :type="session('type')" />
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                @can('admin')
                  <p>今日の予定</p>
                @else
                  <p class="mb-3">予約一覧</p>
                  <ul class="list-disc list-inside">
                    @foreach ($reserve_lists as $reserve_list)
                        @if($reserve_list['user_id'] == Auth::user()->id)
                            <li class="mb-3"><a href="" class="hover:text-teal-400">{{$reserve_list['date']}}&nbsp;&nbsp;&nbsp;&nbsp;{{$reserve_list['time']}}〜&nbsp;&nbsp;&nbsp;&nbsp;{{$reserve_list['course_name']}}</a></li>
                        @endif
                    @endforeach
                  </ul>               
                @endcan
            </div>

            <div>

            </div>
        </div>
    </div>
</x-app-layout>
