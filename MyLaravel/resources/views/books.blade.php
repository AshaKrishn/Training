<x-layout>
   @if($books->isNotEmpty())
        @foreach ($books as $book)
            <article>
                <h2><a href="/books/{{$book->id}}"> {{$book->title }}</a> </h2>
                <h4>By <a  class='author' href="/authors/{{$book->author->slug}}">  {{$book->author->name }}</a> in 
                    <a href="/categories/{{$book->category->slug}}"> {{$book->category->name }}</a> 
                </h4>
                    {!! $book->excerpt !!}
                    <p class="mt-4 float-end"><a href="/books/{{$book->id}}">Read More >></a><p>
            </article>
        @endforeach
    @else
        <h2>No Books to display !!</h2>
    @endif
</x-layout>