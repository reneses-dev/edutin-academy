@extends('layouts.base')
@section('styles')
    <link href="{{ asset('css/manage_post/categories/css/article_category.css') }}" rel="stylesheet">
@endsection

@section('name', 'Blog')

@section('content')

@include('layouts.navbar')
    <div class="slogan">
        <div class="column1 my-3">
            <h2>BLOG</h2>
        </div>
        <div class="column2">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
    </div>

    <div class="article-container">
        <!-- Listar artículos -->
        @foreach ($articles as $article)        
            <article class="article">
                <img src="{{asset('storage/'.$article->image)}}" class="img">
                <div class="card-body">
                    <a href="{{route('articles.show', $article->slug)}}">
                        <h2 class="title">{{Str::limit($article->title, 50)}}</h2>
                    </a>
                    <p class="introduction">{{Str::limit($article->introduction, 100, '...')}}</p>
                </div>
            </article>
        @endforeach
    </div>
    <div class="links-paginate">
        {{ $articles->links() }}
    </div>
@endsection