@extends('layouts.app')

@section('title', 'Gestion Société')

@section('content')
    <div class="container">
        <h1>Liste des sociétés</h1>

        @foreach($societe as $item)
            <div class="societe-item">
                {{ $item->nom_societe }}
            </div>
        @endforeach

        {{ $societe->links() }}
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('style/custom-societe.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/societe.js') }}"></script>
@endpush
