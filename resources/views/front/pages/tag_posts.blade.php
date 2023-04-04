@extends('front.layouts.pages-layout')
@section('pageTitle', @isset($pageTitle) ? $pageTitle : 'Welcome to Blog ')
@section('content')
    <div class="row">
        <div class="col-12">
            {{-- $category lay du lieu tu controller thông qua data --}}
            <h1 class="mb-4 border-bottom border-primary d-inline-block">{{ $pageTitle}}</h1>
        </div>
        <div class="col-lg-8 mb-5 mb-lg-0">
            <div class="row">
                @forelse ($posts as $post)
                    <div class="col-md-6 mb-4">
                        <article class="card article-card article-card-sm h-100">
                            <a href="{{ route('read_post', $post->post_slug) }}">
                                <div class="card-image">
                                    <div class="post-info"> <span
                                            class="text-uppercase">{{ date_formatter($post->created_at) }}</span>
                                        <span
                                            class="text-uppercase">{{ readDuration($post->post_title, $post->post_content) }}
                                            @choice('min|mins', readDuration($post->post_title, $post->post_content)) read</span>
                                    </div>
                                    <img loading="lazy" decoding="async"
                                        src="/storage/images/post_images/thumbnails/resized_{{ $post->featured_image }}"
                                        alt="Post Thumbnail" class="w-100" width="420" height="280">
                                </div>
                            </a>
                            <div class="card-body px-0 pb-0">
                                {{-- <ul class="post-meta mb-2">
                                <li> 
                                    <a href="#!">travel</a>
                                    
                                </li>
                            </ul> --}}
                                <h2><a class="post-title"
                                        href="{{ route('read_post', $post->post_slug) }}">{{ $post->post_title }}</a></h2>
                                <p class="card-text">{{ Str::ucfirst(words($post->post_content, 25)) }}</p>
                                <div class="content"> <a class="read-more-btn"
                                        href="{{ route('read_post', $post->post_slug) }}">Read Full
                                        Article</a>
                                </div>
                            </div>
                        </article>
                    </div>
                @empty
                    <span class="text-danger">No Post(s) found for this category</span>
                @endforelse
                {{-- <div class="col-md-6 mb-4">
                    <article class="card article-card article-card-sm h-100">
                        <a href="article.html">
                            <div class="card-image">
                                <div class="post-info"> <span class="text-uppercase">03 Jun 2021</span>
                                    <span class="text-uppercase">2 minutes read</span>
                                </div>
                                <img loading="lazy" decoding="async" src="/front/images/post/post-2.jpg" alt="Post Thumbnail"
                                    class="w-100" width="420" height="280">
                            </div>
                        </a>
                        <div class="card-body px-0 pb-0">
                            <ul class="post-meta mb-2">
                                <li> <a href="#!">travel</a>
                                </li>
                            </ul>
                            <h2><a class="post-title" href="article.html">An
                                    Experiential Guide to Explore This Kingdom</a></h2>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna …</p>
                            <div class="content"> <a class="read-more-btn" href="/articles/travel/post-2/">Read Full
                                    Article</a>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="col-md-6 mb-4">
                    <article class="card article-card article-card-sm h-100">
                        <a href="article.html">
                            <div class="card-image">
                                <div class="post-info"> <span class="text-uppercase">01 Jan 2021</span>
                                    <span class="text-uppercase">2 minutes read</span>
                                </div>
                                <img loading="lazy" decoding="async" src="/front/images/post/post-6.jpg" alt="Post Thumbnail"
                                    class="w-100" width="420" height="280">
                            </div>
                        </a>
                        <div class="card-body px-0 pb-0">
                            <ul class="post-meta mb-2">
                                <li> <a href="#!">travel</a>
                                    <a href="#!">news</a>
                                </li>
                            </ul>
                            <h2><a class="post-title" href="article.html">Eight
                                    Awesome Places to Visit in Montana This Summer</a></h2>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna …</p>
                            <div class="content"> <a class="read-more-btn" href="/articles/travel/post-3/">Read Full
                                    Article</a>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="col-md-6 mb-4">
                    <article class="card article-card article-card-sm h-100">
                        <a href="article.html">
                            <div class="card-image">
                                <div class="post-info"> <span class="text-uppercase">01 Jun 2020</span>
                                    <span class="text-uppercase">2 minutes read</span>
                                </div>
                                <img loading="lazy" decoding="async" src="/front/images/post/post-8.jpg" alt="Post Thumbnail"
                                    class="w-100" width="420" height="280">
                            </div>
                        </a>
                        <div class="card-body px-0 pb-0">
                            <ul class="post-meta mb-2">
                                <li> <a href="#!">website</a>
                                    <a href="#!">website</a>
                                    <a href="#!">hugo</a>
                                </li>
                            </ul>
                            <h2><a class="post-title" href="article.html">Portugal and France Now Allow Unvaccinated
                                    Tourists</a></h2>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna …</p>
                            <div class="content"> <a class="read-more-btn" href="/articles/travel/post-4/">Read Full
                                    Article</a>
                            </div>
                        </div>
                    </article>
                </div> --}}
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            {{ $posts->appends(request()->input())->links('custom_pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="widget-blocks">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="widget">
                            <div class="widget-body">
                                <img loading="lazy" decoding="async" src="/front/images/author.jpg" alt="About Me"
                                    class="w-100 author-thumb-sm d-block">
                                <h2 class="widget-title my-3">Hootan Safiyari</h2>
                                <p class="mb-3 pb-2">Hello, I’m Hootan Safiyari. A Content writter, Developer and Story
                                    teller. Working as a Content writter at CoolTech Agency. Quam nihil …</p> <a
                                    href="about.html" class="btn btn-sm btn-outline-primary">Know
                                    More</a>
                            </div>
                        </div>
                    </div>

                    {{-- latest post --}}
                    @include('front.layouts.inc.latest_sidebar_posts')



                    @if (categories())
                    <div class="col-lg-12 col-md-6">
                        <div class="widget">
                            <h2 class="section-title mb-3">Categories</h2>
                            <div class="widget-body">
                                <ul class="widget-list">
                                    @include('front.layouts.inc.categories_list')
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
