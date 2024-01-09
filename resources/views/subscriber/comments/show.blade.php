<div class="comments-content">
    @foreach ($comments as $comment)
    <div class="comments-body">
            <span class="comment-head">{{$comment->user->name}} &nbsp; &nbsp; {{$comment->value}}⭐ </span>
            <p class="comment-description line">{{$comment->description}}</p>
            <span class="comment-date"><b>Realizado: </b> {{$comment->created_at->diffForHumans()}} </span>
    </div>
    <hr>
    @endforeach
    <div class="links-paginate">
            {{ $comments->links() }}
    </div>
</div>