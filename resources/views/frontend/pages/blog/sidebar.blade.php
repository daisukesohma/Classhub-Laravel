<!-- Starts : Recent posts -->
<div class="recent-posts list-links">
    <dl>
        <dt>Recent Posts</dt>
        @foreach(\App\Http\Controllers\PostController::recentPosts() as $post)
            <dd><a href="{{ route('page.blog.post', $post->slug) }}">{{ $post->title }}</a></dd>
        @endforeach
    </dl>
</div>
<!-- End : Recent posts -->

<!-- Starts : archives posts -->
<div class="archives list-links">
    <dl>
        <dt>Archives</dt>
        @foreach( \App\Http\Controllers\PostController::archiveLists() as $list)
            <dd><a href="{{ route('page.blog.archive', $list) }}">{{ \Carbon\Carbon::parse($list)->format('F Y') }}</a>
            </dd>
        @endforeach
    </dl>
</div>
<!-- End : Recent posts -->

<!-- Starts : categories posts -->
<div class="categories list-links">
    <dl>
        <dt>Categories</dt>
        @foreach( \App\Http\Controllers\PostController::categoryLists() as $category)
            <dd><a href="{{ route('page.blog.category', $category->slug) }}">{{ $category->name }}</a></dd>
        @endforeach
    </dl>
</div>
<!-- End : categories posts -->

<!-- Starts : tags posts -->
{{--<div class="tags list-links">
    <dl>
        <dt>tags</dt>
    </dl>
</div>--}}
<!-- End : tags posts -->
