<x-layout>
    @foreach ($posts as $post)
        <article>
            <h2><a href="/posts/{{$post->slug}}"> {{$post->title }}</a></h2>
                {!! $post->excerpt !!}
                <p class="mt-4 float-end"><a href="/posts/{{$post->slug}}">Read More >></a><p>
        </article>
    @endforeach
</x-layout>