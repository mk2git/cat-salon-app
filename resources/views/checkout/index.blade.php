<x-app-layout>
  <x-to-dashboard />
  <div class="container my-10 mx-auto">
    <h2 class="text-center text-base md:text-2xl mb-2"><i class="fa-solid fa-cash-register"></i>&nbsp;&nbsp;どのお会計を行いますか？</h2>
    <hr class="w-3/4 mx-auto">
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3">
      @php $hasCheckout = false; @endphp
      @foreach ($checkouts as $checkout)
        @php $hasCheckout = true; @endphp
        <a href="{{route('checkout.edit', $checkout['reserve_id'])}}" class="block p-6 mx-4 md:mx-2 lg:mx-5 shadow-xl hover:bg-gray-100">
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