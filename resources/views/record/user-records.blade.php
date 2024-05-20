<x-app-layout>
  <p class="mt-10 text-2xl text-center"><i class="fa-regular fa-clipboard"></i>&nbsp;&nbsp;サロン履歴一覧</p>
  @foreach ($contents as $content)
    <x-record :content="$content" />
  @endforeach
</x-app-layout>