<x-app-layout>
  <div class="container my-10 mx-auto">
    <h2 class="text-center text-2xl">{{$reserve_content['user_name']}}<small>様</small>&nbsp;の本日のサロン内容</h2>
    <hr class="w-1/2 mx-auto">
    <div class="mt-10 p-6 w-1/2 shadow-xl mx-auto">
      <form action="{{route('checkout.update')}}" method="post">
        @csrf
        @method('put')
        <input type="hidden" name="reserve_id" value="{{$reserve_content['reserve_id']}}">
        <input type="hidden" name="user_id" value="{{$reserve_content['user_id']}}">
        <label class="block mx-auto mb-6">
          <span class="block text-sm font-medium text-slate-700">コース選択</span>
          <select name="course_id" id="" class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm shadow-sm placeholder-slate-400
          focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500
          disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none
          invalid:border-pink-500 invalid:text-pink-600
          focus:invalid:border-pink-500 focus:invalid:ring-pink-500">
            <option value="" disabled selected>コースを選択してください</option>
            @foreach ($courses as $course)
              <option value="{{$course->id}}" @if($course->id == $reserve_content['course_id']) selected @endif>{{$course->course_name}}</option>
            @endforeach
          </select>
        </label>
        
        <label class="block mx-auto mb-6">
          <p class="font-medium my-2 text-slate-700 text-sm">オプション</p>
          <div class="flex">
            @foreach ($options as $option)
              <div class="me-4">
                <input type="checkbox" id="{{$option->name}}" name="reserve_option[{{$option->id}}]" value="{{$option->id}}" class="mt-1 border border-slate-300 rounded-md text-sm shadow-sm placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500
              " 
              @foreach ($reserve_content['options'] as $reserve_option)
                @if ($reserve_option->reserve_option_id == $option->id)
                  checked
                @endif
              @endforeach
              />
                <label for="{{$option->name}}">{{$option->name}}</label>
              </div>              
            @endforeach
          </div>
        </label>
        <button type="submit" class="block bg-teal-600 text-white py-2 px-6 rounded mx-auto">確定</button>
      </form>
    </div>
  </div>
</x-app-layout>