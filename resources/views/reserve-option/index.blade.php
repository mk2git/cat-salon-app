<x-admin-layout>
  <div class="container mt-8 mx-auto">
    @if (session('message'))
      <x-alert-message :message="session('message')" />
    @endif

    @if ($errors->any())
           <x-error-message />
    @endif

    <div class="grid gap-6 grid-cols-2">
      <div>
        <form action="{{route('reserve-option.store')}}" method="post" class="block w-80 mx-auto mt-3">
          @csrf
          <label class="block mx-auto mb-3">
            <span class="block text-sm font-medium text-slate-700">オプション名</span>
            <input type="text" name="name" class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm shadow-sm placeholder-slate-400
              focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500
              disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none
              invalid:border-pink-500 invalid:text-pink-600
              focus:invalid:border-pink-500 focus:invalid:ring-pink-500
            "/>
          </label>
          <label class="block mx-auto mb-3">
            <span class="block text-sm font-medium text-slate-700">料金</span>
            <input type="number" name="fee" class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm shadow-sm placeholder-slate-400
              focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500
              disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none
              invalid:border-pink-500 invalid:text-pink-600
              focus:invalid:border-pink-500 focus:invalid:ring-pink-500
            "/>
          </label>
          <label class="block mx-auto mb-6">
            <span class="block text-sm font-medium text-slate-700">オプション内容</span>
            <textarea id="message" name="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="オプション内容を入力してください"></textarea>
          </label>
          <button type="submit" class="py-2 px-5 bg-orange-500 text-white font-semibold rounded-full shadow-md hover:bg-orange-700 focus:outline-none focus:ring focus:ring-violet-400 focus:ring-opacity-75 block mx-auto">登録</button>
        </form>
      </div>
      <div>
        @foreach ($options as $option)
          
        @endforeach
        オプション内容表示
      </div>
    </div>
  </div>
</x-admin-layout>