<x-app-layout>
  <a href="{{route('dashboard')}}" class="block mt-6 ms-5"><i class="fa-solid fa-house"></i></a>
  <div class="container mt-10 mx-auto">
    <p class="text-center text-2xl">
      <i class="fa-solid fa-user"></i>&nbsp;&nbsp;会員一覧
      <small>（計：{{$count}} 人）</small>
    </p>
    <div class="flex mt-6">
      @foreach ($users as $user)
        <a href="{{route('user.show', $user->id)}}" class="border-4 block px-8 py-4 m-6 shadow-md hover:shadow-xl">
          <i class="fa-solid fa-user"></i>&nbsp;&nbsp;{{$user->name}}<small>様</small>
        </a>
      @endforeach
    </div>
  </div>
</x-app-layout>