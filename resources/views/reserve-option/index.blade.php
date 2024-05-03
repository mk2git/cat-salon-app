<x-admin-layout>
  <div class="container mt-8 mx-auto">
    @if (session('message'))
      <x-alert-message :message="session('message')" />
    @endif

    @if ($errors->any())
           <x-error-message />
    @endif

    <div class="grid gap-6 grid-cols-2 mb-5">
      <div>
        <p class="text-center">オプションの新規登録</p>
        <form action="{{route('reserve-option.store')}}" method="post" class="block w-80 mx-auto mt-3">
          @csrf
          <x-option-form />
          <button type="submit" class="py-2 px-5 bg-orange-500 text-white font-semibold rounded-full shadow-md hover:bg-orange-700 focus:outline-none focus:ring focus:ring-violet-400 focus:ring-opacity-75 block mx-auto">登録</button>
        </form>
      </div>
      <div>
        <p class="text-center mb-3">オプションの編集</p>
        @foreach ($options as $option)
          <div class="border rounded p-4 mb-3">
            <form action="{{route('reserve-option.update', $option->id)}}" method="post" class="block mb-3">
              @csrf
              @method('put')
              <x-option-form :option-name="$option->name" :option-fee="$option->fee" :option-desc="$option->description" />
              <button type="submit" class="py-2 px-5 bg-teal-600 text-white font-semibold rounded-full shadow-md hover:bg-teal-800 focus:outline-none focus:ring focus:ring-violet-400 focus:ring-opacity-75 block mx-auto">更新</button>
            </form>
            <hr>
            <div class="mt-3 text-right">
               <form action="{{route('reserve-option.delete', $option->id)}}" method="post">
                  @csrf
                  @method('delete')
                <small>このオプションを削除しますか？</small>&nbsp;&nbsp;
                <button type="submit" class="py-2 px-5 bg-red-600 text-white font-semibold rounded shadow-md hover:bg-red-800 focus:outline-none focus:ring focus:ring-violet-400 focus:ring-opacity-75">削除</button>
              </form>
            </div>
          </div>  
        @endforeach
      </div>
    </div>
  </div>
</x-admin-layout>