<div class="list-inbox">
    @if( count($chats) == 0)
        <div class="emptyState text-center p-t-60 p-b-60">
            <i class="fa fa-envelope-open-o p-b-20"></i>
            <h4>You have no messages yet</h4>
        </div>
    @else
        @foreach($chats as $chat)
            <a href="{{ route('educator.inbox.message', $chat->id) }}" style="text-decoration: none">

                <div class="list {{ $chat->unread_count ? 'tag-unread' : 'tag-read'}}
                {{ $chat->id  == $activeChatId ? 'active' : ''}}">
                    <div class="name">{{ optional($chat->chat_with)->name }}</div>
                    <div class="class">{{ optional($chat->lesson)->name  }}</div>
                    <button class="btn btn-secondary btn-text-red shadow-v4">
                        <span class="btn__text v1">REPLY</span>
                    </button>
                    @if($chat->unread_count  > 0 )
                        <span class="badge">{{ $chat->unread_count }}</span>
                    @endif
                </div>
            </a>
        @endforeach
    @endif
</div>
