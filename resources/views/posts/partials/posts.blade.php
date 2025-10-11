<!-- posts/posts.blade.php -->
<div class="page-content">
    <h1>Posts</h1>
    <p>Liste des articles</p>

    @foreach($posts as $post)
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{ $post->title }}</h5>
            </div>
        </div>
    @endforeach
</div>
