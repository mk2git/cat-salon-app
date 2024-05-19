<x-app-layout>
  <div class="container mt-10 mx-auto">
    <p class="text-center text-2xl">
      <i class="fa-solid fa-user"></i>&nbsp;&nbsp;会員一覧
      <small>（計：{{$count}} 人）</small>
    </p>
    <div class="flex mt-6">
      @foreach ($users as $user)
        <a href="{{route('user.show', $user->id)}}" class="block px-6 py-2 m-6 hover:bg-teal-300 shadow-xl">
          {{$user->name}}<small>様</small>
        </a>
      @endforeach
    </div>
  </div>
</x-app-layout>