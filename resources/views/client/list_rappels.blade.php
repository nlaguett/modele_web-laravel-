@php
/**
 * Modèle Rappels crée dans Models/RappelsModels mais la table Rappels n'existe pas dans ma database.
 * Corriger les routes a la ligne 54 et 70
 * Il faut aussi changer le design de la liste avec le nouveau design v2
 *
 */
@endphp



<div class="container">
    <div class="body-dashboard-container">
        <div class="dashboard-container-client">
            <h1>Liste des Rappels</h1>
            <div class="button-container">
                <div class="background-table">

                    {{-- En-tête du tableau --}}
                    <div class="client-card header">
                        <div class="icon"></div>
                        <div class="info">
                            <div class="info-line">
                                <div class="line">
                                    <span class="name"><strong>Nom Prénom</strong></span>
                                    <span class="company"><strong>Société</strong></span>
                                </div>
                                <div class="line">
                                    <span class="email"><strong>Email<br>Téléphone</strong></span>
                                    <span class="city"><strong>Code Postal<br>Ville</strong></span>
                                </div>
                            </div>
                        </div>
                        Action
                    </div>

                    {{-- Liste des rappels --}}
{{--                    @if(!empty($rappels) && count($rappels) > 0)--}}
{{--                        @foreach($rappels as $element)--}}
{{--                            <div class="client-card">--}}
{{--                                <div class="icon"></div>--}}
{{--                                <div class="info">--}}
{{--                                    <div class="info-line">--}}
{{--                                        <div class="line">--}}
{{--                                            <span class="name">{{ $element->nom ?? '' }} {{ $element->prenom ?? '' }}</span>--}}
{{--                                            <span class="company">{{ $element->nom_societe ?? '' }}</span>--}}
{{--                                        </div>--}}
{{--                                        <div class="line">--}}
{{--                                            <span class="email">{{ $element->email ?? '' }}<br>{{ $element->telephone ?? '' }}</span>--}}
{{--                                            <span class="city">{{ $element->code_postal ?? '' }} {{ $element->ville ?? '' }}</span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <a href="{{ route('rappels.edit', $element->id) }}" class="ajax-link">--}}
{{--                                    <div class="menu"></div>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        @endforeach--}}
{{--                    @else--}}
{{--                        <div class="no-data">--}}
{{--                            <p>Aucun rappel trouvé</p>--}}
{{--                        </div>--}}
{{--                    @endif--}}

                    {{-- Footer avec pagination --}}
{{--                    <div class="footer_list">--}}
{{--                        <div class="pagination-container">--}}
{{--                            {{ $rappels->links() }}--}}
{{--                        </div>--}}
{{--                        <button type="button" class="btn btn-add" data-url="{{ route('rappels.create') }}">--}}
{{--                            Ajouter--}}
{{--                        </button>--}}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


