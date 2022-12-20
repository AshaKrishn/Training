<x-layout>
    <article>
        <h2>{{ $books->title }}</h2>
        <h4>By <a class='author' href="/authors/{{$books->author->slug}}">  {{$books->author->name }}</a> in
            <a href="/categories/{{$books->category->slug}}"> ({{$books->category->name }})</a>
        </h4>
            {!! $books->body !!}
    </article>
    <p class="mt-4"><a href="/"><< Back </a></p>
 </x-layout>