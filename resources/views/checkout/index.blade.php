<x-app-layout>
  <x-to-dashboard />
  <div class="container my-10 mx-auto">
    <h2 class="text-center text-2xl mb-2">どのお会計を行いますか？</h2>
    <hr class="w-3/4 mx-auto">
    <div class="mt-6 flex">
      @php $hasCheckout = false; @endphp
      @foreach ($checkouts as $checkout)
        @php $hasCheckout = true; @endphp
        <a href="{{route('checkout.edit', $checkout['reserve_id'])}}" class="block p-6 w-1/4 mx-6 shadow-xl hover:bg-gray-100">
          <p><span class="font-bold text-xl">{{$checkout['user_name']}}</span>&nbsp;&nbsp;様</p>
          <hr>
          <p class="mt-6 text-center">{{$checkout['date']}}&nbsp;&nbsp;&nbsp;&nbsp;{{$checkout['time']}}〜</p>
          <p class="mt-3 text-center">{{$checkout['course_name']}}</p>
        </a>
      @endforeach
      @if (!$hasCheckout)
        <p class="text-center mt-10 mx-auto">お会計できるものはありません。</p>
      @endif
    </div>
  </div>
</x-app-layout>