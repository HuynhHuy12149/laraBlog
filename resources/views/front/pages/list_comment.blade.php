
@foreach($comments as $comment)
    
<hr>
<div class="media" >
    <a href="" class="pull-left mr-2">
        <img width="60"
            src="/back/dist/img/author/default-img.png"
            alt="Image" class="media-object">
    </a>
    <div class="media-body">
        <h4 class="media-heading">{{ $comment->user->name }}</h4>
        <p>{{ $comment->content }}</p>
        <p>
            @if (session()->has('user'))
            <a href="" class="btn btn-xs btn-show-reply-form btn-danger" data-id="{{ $comment->id }}"> Trả lời</a>
        @else
            <button class="btn btn-xs" disabled>Trả lời</button>    
        
        @endif
            
        </p>
        <form action="" style="display: none;" method="post" class="formReply form-reply-{{ $comment->id }}">
            

            <div class="form-group">
                
                
                <textarea name="" id="content-reply-{{ $comment->id }}" class="form-control"  placeholder="Nhập nội dung bình luận...."></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-send-comment-reply" data-id="{{ $comment->id }}">Trả lời bình luận</button>
        </form>


        {{-- bình luận cấp 2  --}}
        @foreach($comment->replies as $child)
        <div class="media">
            <a href="" class="pull-left mr-2">
                <img width="60"
                    src="/back/dist/img/author/default-img.png"
                    alt="Image" class="media-object">
            </a>
            <div class="media-body">
                <h4 class="media-heading">{{ $child->user->name }}</h4>
                <p>{{ $child->content }}</p>
               
            </div>
        </div>
        @endforeach
    
    </div>
    
</div>
@endforeach

