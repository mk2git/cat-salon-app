<x-app-layout>
  <div class="container my-10 mx-auto">
    <h2 class="text-center text-2xl">どのお会計を行いますか？</h2>
    <div class="mt-6 flex">
      @foreach ($checkouts as $checkout)
        <a href="{{route('checkout.edit', $checkout['reserve_id'])}}" class="block p-6 w-1/4 mx-6 shadow-xl hover:bg-gray-100">
          <p><span class="font-bold text-xl">{{$checkout['user_name']}}</span>&nbsp;&nbsp;様</p>
          <hr>
          <p class="mt-6 text-center">{{$checkout['date']}}&nbsp;&nbsp;&nbsp;&nbsp;{{$checkout['time']}}〜</p>
          <p class="mt-3 text-center">{{$checkout['course_name']}}</p>
        </a>
      @endforeach
    </div>
  </div>
</x-app-layout>