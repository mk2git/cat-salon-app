<x-app-layout>
  @if (session('message'))
    <x-alert-message :message="session('message')" :type="session('type')" />
  @endif
  @if ($errors->any())
    <x-error-message />
  @endif
  
  <p class="text-right me-10 mt-5 md:text-base lg:text-xl">{{$content['date']}}</p>
  <div class="border-8 border-orange-800 my-8 sm:w-11/12 md:w-10/12 lg:w-3/4 mx-1 md:mx-auto py-md-3 px-md-4 py-lg-6 px-lg-10">
    <h2 class="text-center text-4xl mt-6 mb-4">Cat Salon</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:text-sm lg:text-base">
      <div class="px-4 pt-2">
        <div class="grid grid-cols-2 gap-5 mb-6">
          <div>
            <p><i class="fa-solid fa-paw"></i>&nbsp;&nbsp;名前：</p>
            <p class="border-b text-center">{{$content['cat_name']}}<small>ちゃん</small></p>
          </div>
          <div>
            <p><i class="fa-solid fa-paw"></i>&nbsp;&nbsp;猫種：</p>
            <p class="border-b text-center">{{$content['cat_species']}}</p>
          </div>
        </div>
        <p class="mb-2">
          <i class="fa-solid fa-paw"></i>&nbsp;&nbsp;本日の体重：
          <span class="border-b">&nbsp;&nbsp;{{$content['weight']}}&nbsp;&nbsp;</span>&nbsp;&nbsp;kg
        </p>
        <p><i class="fa-solid fa-paw"></i>&nbsp;&nbsp;ボディチェック内容：</p>
        <div class="grid grid-cols-3">
          <div class="text-right">耳：</div>
          <div class="col-span-2 border-b text-center">{{$content['ear']}}</div>
        </div>
        <div class="grid grid-cols-3">
          <div class="text-right">目：</div>
          <div class="col-span-2 border-b text-center">{{$content['eye']}}</div>
        </div>
        <div class="grid grid-cols-3">
          <div class="text-right">抜け毛：</div>
          <div class="col-span-2 border-b text-center">{{$content['hair_loss']}}</div>
        </div>
        <div class="grid grid-cols-3">
          <div class="text-right">毛玉：</div>
          <div class="col-span-2 border-b text-center">{{$content['hair_ball']}}</div>
        </div>
        <div class="grid grid-cols-3">
          <div class="text-right">その他：</div>
          <div class="col-span-2 border-b text-center">{{$content['others']}}</div>
        </div>
        <p class="mt-5"><i class="fa-solid fa-paw"></i>&nbsp;&nbsp;担当グルーマーからのメッセージ</p>
        <p class="border-2 mt-2 p-2">{{$content['message']}}</p>
      </div>
      <div class="mt-6">
        <p class="text-center border-b-4">料金詳細</p>
        <div class="grid grid-cols-2 mt-4 text-center border-b">
          <div>{{$content['course_name']}}</div>
          <div>&yen;{{$content['course_fee']}}</div>
        </div>
        @foreach ($content['options'] as $option)
          <div class="grid grid-cols-2 mt-4 text-center border-b">
            <div>{{$option->reserve_option->name}}</div>
            <div>&yen;{{number_format($option->reserve_option->fee)}}</div>
          </div>
        @endforeach
        <p class="mt-6 text-center"><span class="border-b-2 border-solid border-black inline-block w-1/2 float-right me-10">subTotal：&nbsp;&nbsp;&nbsp;&nbsp;&yen;{{$content['subTotal']}}</span></p><br>
        <p class="mt-6 text-center"><span class="border-b-2 border-solid border-black inline-block w-1/3 float-right me-10">Tax：&nbsp;&nbsp;&nbsp;&nbsp;&yen;{{$content['onlyTax']}}</span></p><br>
        <p class="mt-8 text-center"><span class="border-b-4 border-double border-black inline-block w-3/4 float-right text-2xl me-2 mb-2">Total：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&yen;{{$content['total']}}</span></p>
     </div>
    </div>

    <div class="text-center mx-auto">
      <form action="{{route('checkout.updateCheckout')}}" method="post">
        @csrf
        @method('put')
        <input type="hidden" name="reserve_id" value="{{$content['reserve_id']}}">
        <input type="hidden" name="user_id" value="{{$content['user_id']}}">
        <p class="mt-6 mb-3">支払い方法</p>
        <input type="radio" name="payment" value="cash" id="cash">
        <label for="cash" class="mr-6">現金</label>
        <input type="radio" name="payment" value="card" id="card">
        <label for="card">カード</label>
        <button type="submit" class="block py-2 px-6 bg-teal-600 text-white rounded mx-auto my-4">会計</button>
      </form>
     </div>
  </div>
</x-app-layout>