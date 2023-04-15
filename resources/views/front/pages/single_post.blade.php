@extends('front.layouts.pages-layout')
@section('pageTitle', @isset($pageTitle) ? $pageTitle : 'Welcome to Blog ')
@section('meta_tags')
    <meta name="title" content="{{ Str::ucfirst($post->post_title) }}" />
    <meta name="robots" content="index, follow, max-snippet:-1,max-image-preview:large, max-video-preview:-1" />
    <meta name="description" content="{{ Str::ucfirst(words($post->post_content, 120)) }}" />
    <meta name="author" content="{{ $post->author->username }}" />
    <link rel="canonical" href="{{ route('read_post', $post->post_slug) }}">
    <meta property="og:title" content="{{ Str::ucfirst($post->post_title) }}" />
    <meta property="og:type" content="article" />
    <meta property="og:description" content="{{ Str::ucfirst(words($post->post_content, 120)) }}" />
    <meta property="og:url" content="{{ route('read_post', $post->post_slug) }}" />
    <meta property="og:image" content="asset(/storage/images/post_images/thumbnails/resized_{{ $post->featured_image }})" />
    <meta property="twitter:domain" content="{{ Request::getHost() }}" />
    <meta property="twitter:card" content="summary" />
    <meta property="twitter:title" content="{{ Str::ucfirst($post->post_title) }}" />
    <meta property="twitter:description" content="{{ Str::ucfirst(words($post->post_content, 120)) }}" />
    <meta property="twitter:image" content="/storage/images/post_images/thumbnails/resized_{{ $post->featured_image }}" />

@endsection
@section('content')
    <div class="row">
        <div class="col-lg-8 mb-5 mb-lg-0">
            <article>
                <img loading="lazy" decoding="async"
                    src="/storage/images/post_images/thumbnails/resized_{{ $post->featured_image }}" alt="Post Thumbnail"
                    class="w-100">
                <ul class="post-meta mb-2 mt-4">
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            style="margin-right:5px;margin-top:-4px" class="text-dark" viewBox="0 0 16 16">
                            <path d="M5.5 10.5A.5.5 0 0 1 6 10h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z"></path>
                            <path
                                d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z">
                            </path>
                            <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4z">
                            </path>
                        </svg> <span>{{ date_formatter($post->created_at) }}</span>
                    </li>
                </ul>
                <h1 class="my-3">{{ $post->post_title }}</h1>
                <ul class="post-meta mb-4">
                    <li> <a
                            href="{{ route('category_posts', $post->subcategory->slug) }}">{{ $post->subcategory->subcategory_name }}</a>
                    </li>
                </ul>
                <div class="content text-left">
                    <p>{!! $post->post_content !!}</p>


                </div>
                @if ($post->post_tags)

                    @php
                        $tagsString = $post->post_tags;
                        $tagsArray = explode(',', $tagsString);
                    @endphp
                    <div class="tag-container mt-4">
                        <ul class="post-meta">
                            @foreach ($tagsArray as $tag)
                                <li><a href="{{ route('tag_posts', $tag) }}">#{{ $tag }}</a></li>
                            @endforeach

                        </ul>
                    </div>
                @endif
            </article>

            {{-- <div class="widget-list mt-5" >

                <h2 class="mb-2">Related posts</h2>
                <a class="media align-items-center" href="article.html">
                  <img loading="lazy" decoding="async" src="front/images/post/post-2.jpg" alt="Post Thumbnail" class="w-100">
                  <div class="media-body ml-3">
                    <h3 style="margin-top:-5px">These Are Making It Easier To Visit</h3>
                    <p class="mb-0 small">Heading Here is example of hedings. You can use …</p>
                  </div>
                </a>
                
              </div> --}}
            {{-- comment posts --}}

            <div class="container">

                <h3>Bình Luận</h3>
                <form role="form" action="" method="post">
                    @csrf
                    <legend>Xin chào bạn </legend>

                    <div class="form-group">
                        <label for="">Nội dung bình luận</label>
                        <input type="hidden" value="{{ $post->id }}" name="post_id">
                        <textarea id="comment-content" name="content" class="form-control" placeholder="Nhập nội dung bình luận...."></textarea>
                        <span class="text-danger" id="text-danger"></span>
                    </div>
                    @if (session()->has('user'))
                        <button type="submit" id="btn-comment" class="btn btn-primary">Gửi bình luận</button>
                    @else
                        <button disabled type="submit" id="btn-comment" class="btn btn-primary">Gửi bình luận</button>
                    @endif
                    
                </form>
                <br>
                <h3>Các bình luận</h3>
                <div id="comment">



                    @include('front.pages.list_comment', ['comments' => $post->comments])


                </div>
            </div>

            {{-- relate post --}}
            @if (count($related_posts) > 0)
                <div class="widget-list mt-5">

                    <h2 class="mb-2">Related posts</h2>
                    @foreach ($related_posts as $item)
                        <a class="media align-items-center" href="{{ route('read_post', $item->post_slug) }}">
                            <img loading="lazy" decoding="async"
                                src="/storage/images/post_images/thumbnails/thumb_{{ $item->featured_image }}"
                                alt="Post Thumbnail" class="w-100">
                            <div class="media-body ml-3">
                                <h3 style="margin-top:-5px">{{ $item->post_title }}</h3>
                                <p class="mb-0 small">{!! Str::ucfirst(words($item->post_content, 25)) !!}</p>
                            </div>
                        </a>
                    @endforeach


                </div>

            @endif


            <div class="mt-5">

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
                    @if (all_tags() != null)
                        @php
                            $allsString = all_tags();
                            $allTagsArray = explode(',', $allsString);
                        @endphp
                        <div class="widget">
                            <h2 class="section-title mb-3">Tags</h2>
                            <div class="widget-body">
                                <ul class="widget-list">
                                    @foreach (array_unique($allTagsArray) as $item)
                                        <li><a href="{{ route('tag_posts', $item) }}">{{ $item }}</span></a>
                                        </li>
                                    @endforeach


                                </ul>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection

@push('stylesheets')
    <link rel="stylesheet" href="/share_post/jquery.floating-social-share.min.css">
@endpush
@php
    $user_id = optional(session('user'))['id'] ?? 0;
@endphp
@push('scripts')
    <script src="/share_post/jquery.floating-social-share.min.js"></script>
    <script>
        $("body").floatingSocialShare({
            buttons: [
                "facebook", "linkedin", "telegram", "twitter"
            ],
            text: "Share with: ",
            url: "{{ route('read_post', $post->post_slug) }}"
        });
    </script>
    <script>
        

        let _commentUrl = '{{ route('comment', [$user_id, $post->id]) }}';



        var _csrf = '{{ csrf_token() }}';
        $('#btn-comment').click(function(ev) {
            ev.preventDefault();
            let content = $('#comment-content').val();



            $.ajax({
                url: _commentUrl,
                type: 'POST',
                data: {
                    content: content,

                    _token: _csrf,

                },
                success: function(response) {

                    $('#comment-content').val('');
                    $('#comment').html(response);
                },
                error: function(response) {
                    $('#text-danger').html(response.responseJSON.errors.content[0]);

                }

            });
        });

        // bắt sự kiện hiện form trả lời bình luận
        $(document).on('click', '.btn-show-reply-form', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var content_reply_id = '#content-reply-' + id;
            var contentReply = $(content_reply_id).val();
            var form_reply = '.form-reply-' + id;
            $('.formReply').slideUp();
            $(form_reply).slideDown();
            // alert(form_reply);
        });

        $(document).on('click', '.btn-send-comment-reply', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var content_reply_id = '#content-reply-' + id;
            var contentReply = $(content_reply_id).val();
            var form_reply = '.form-reply-' + id;


            // alert(contentReply);
            $.ajax({
                url: _commentUrl,
                type: 'POST',
                data: {
                    content: contentReply,
                    reply_id: id,

                    _token: _csrf,

                },
                success: function(response) {

                    $('#comment-content').val('');
                    $('#comment').html(response);
                },
                error: function(response) {
                    $('#text-danger').html(response.responseJSON.errors.content[0]);

                }

            });
        });
    </script>
@endpush
