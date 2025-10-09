@extends('posts.layout')

@section('content')
    <div class="pages-container">
        <!-- Tout votre contenu actuel du dashboard -->
        <div class="main-content">
            <div class="page-header">
                <h1>Dashboard Posts</h1>
            </div>

            <div class="content-card">
                <!-- Votre tableau de posts -->
                <table class="table">
                    <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Auteur</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


{{--<div style="width:100%;display:flex;flex-direction:column;align-content:center;justify-content:center;align-items:center;">--}}
{{--    <h1>Mes pages</h1>--}}
{{--</div>--}}

{{--<div class="main-content">--}}
{{--    <div class="list">--}}
{{--         Header--}}
{{--        <div class="list-item">--}}
{{--            <span>Header</span>--}}
{{--            <div>--}}
{{--                <a href="{{ url('/header') }}"><button class="blue-btn">Voir</button></a>--}}
{{--                <a href="{{ route('posts.edit', 'header') }}"><button class="yellow-btn">Modifier</button></a>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--         Footer--}}
{{--        <div class="list-item">--}}
{{--            <span>Footer</span>--}}
{{--            <div>--}}
{{--                <a href="{{ url('/footer') }}"><button class="blue-btn">Voir</button></a>--}}
{{--                <a href="{{ route('posts.edit', 'footer') }}"><button class="yellow-btn">Modifier</button></a>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--         Posts dynamiques--}}
{{--        @foreach ($posts as $post)--}}
{{--            <div class="list-item">--}}
{{--                <span>{{ $post->title }}</span>--}}
{{--                <div>--}}
{{--                    <a href="{{ url('/' . $post->slug) }}"><button class="blue-btn">Voir</button></a>--}}
{{--                    <a href="{{ route('posts.edit', $post->id) }}"><button class="yellow-btn">Modifier</button></a>--}}
{{--                    <div action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display: inline;">--}}
{{--                        @csrf--}}
{{--                        @method('DELETE')--}}
{{--                        <button type="submit" class="red-btn" onclick="return confirm('Supprimer ?')">Supprimer</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        @endforeach--}}

{{--         Bouton Ajouter--}}
{{--        <div class="list-item">--}}
{{--            <span>&nbsp;</span>--}}
{{--            <div>--}}
{{--                <a href="{{ route('posts.create') }}"><button class="green-btn">Ajouter</button></a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

