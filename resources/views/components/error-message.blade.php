<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative text-center" role="alert">
  <ul>
    @foreach ($errors->all() as $error)
      <li>
        {{$error}}
      </li>
    @endforeach
  </ul>
</div>