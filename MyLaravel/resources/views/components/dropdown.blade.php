<?php //$url = $_SERVER['PATH_INFO']; ?>
<div class="dropdown">
  <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
      Select a Genre...
  </button>
  <div class="dropdown-menu" id="itemlist">
    @foreach (\App\Models\Category::all() as $category)
      <a class="dropdown-item" href="/categories/{{$category->slug}}" class="hover:bg-gray-300 focus:bg-gray-300">{{$category->name}}</a>
    @endforeach
  </div>
</div>

