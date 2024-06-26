<p class="text-right me-10 md:text-base lg:text-xl">{{$content['date']}}</p>
<div class="border-8 border-teal-700 my-8 md:w-10/12 lg:w-3/4 mx-2 md:mx-auto py-md-3 px-md-4 py-lg-6 px-lg-10">
  <h2 class="text-center text-4xl mt-6 mb-4">Cat Salon</h2>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:text-sm lg:text-base">
    
    <div class="px-6 pt-2">
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
      <p class="border-2 m-2 p-3">{{$content['message']}}</p>
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
      <p class="mt-8 text-center"><span class="border-b-4 border-double border-black inline-block w-3/4 float-right text-2xl mb-2 me-2">Total：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&yen;{{$content['total']}}</span></p>
   </div>
  </div>
</div>