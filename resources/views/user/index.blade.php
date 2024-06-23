<x-app-layout>
  <x-to-dashboard />
  <div class="container mt-10 mx-auto">
    <p class="text-center text-2xl">
      <i class="fa-solid fa-user"></i>&nbsp;&nbsp;会員一覧
      <small>（計：{{$count}} 人）</small>
    </p>
    <div class="flex flex-wrap flex-auto mt-6">
      @foreach ($users as $user)
        <a href="{{route('user.show', $user->id)}}" class="border-4 block m-6 px-8 py-4 shadow-md hover:shadow-xl sm:text-sm">
          {{$user->name}}<small>様</small>
        </a>
      @endforeach
    </div>
  </div>
</x-app-layout>