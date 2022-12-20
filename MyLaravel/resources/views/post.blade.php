<x-layout>
    <article>
        <h2>{{ $posts->title }}</h2>
            {!! $posts->body !!}
    </article>
    <p class="mt-4"><a href="/"><< Back </a></p>
 </x-layout>