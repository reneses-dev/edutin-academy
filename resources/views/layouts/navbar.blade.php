<div class="category-container">
    <ul>
        <li class="nav-item {{ Request::routeIs('home.index') ? 'active' : ''}}"><a href="{{route('home.index')}}">Todo</a></li>         
            
        @foreach ($navbar as $category)
            <li class="nav-item {{!! Request::path() == '$category/'. $category->slug ? 'active' : ''!!}}">
                <a href="{{route('categories.detail', $category->slug)}}">{{$category->name}}</a>
            </li>
        @endforeach


        <li class="nav-item {{ Request::routeIs('home.all') ? 'active' : ''}}">
            <a href="{{route('home.all')}}">Todas las categorias</a>
        </li>

    </ul>
</div>