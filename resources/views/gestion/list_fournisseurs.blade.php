
    <div class="container_vignette">
        <div class="header_vignette">
            <h1 class="theme-fournisseurs">Gestion des Fournisseurs</h1>
            <p>Gérez vos partenaires commerciaux et relations fournisseurs</p>
        </div>

        <div class="stats-bar">
            <div class="stat-card" data-filter="all" onclick="filterFournisseurs('all')">
                <div class="stat-number" style="color: var(--primary);">{{ $Fournisseurs_Count }}</div>
                <div class="stat-label">Fournisseurs Total</div>
            </div>
            <div class="stat-card" data-filter="actifs" onclick="filterFournisseurs('actifs')">
                <div class="stat-number" style="color: var(--success);">{{ $fournisseursActifs ?? 76 }}</div>
                <div class="stat-label">Fournisseurs Actifs</div>
            </div>
            <div class="stat-card" data-filter="commandes" onclick="filterFournisseurs('commandes')">
                <div class="stat-number" style="color: var(--warning);">23</div>
                <div class="stat-label">Commandes en cours</div>
            </div>
            <div class="stat-card" data-filter="nouveaux" onclick="filterFournisseurs('nouveaux')">
                <div class="stat-number" style="color: var(--info);">12</div>
                <div class="stat-label">Nouveaux ce mois</div>
            </div>
        </div>



        <x-searchbar
            search-id="searchFournisseurs"
            target-grid="itemsGrid"
            item-selector=".item-card"
            placeholder="Rechercher un fournisseur..."
            create-route="{{ route('gestion.create', ['type' => 'fournisseurs']) }}"
            create-label="Nouveau fournisseur"
            item-label="fournisseurs"
            :search-fields="[
        '.item-title',              // Nom complet (Civilité + Nom + Prénom)
        '.item-subtitle',           // SIRET ou Particulier
        '.contact-item span',       // Email, Téléphone, Mobile
        '.address-content',         // Adresse complète
        '.detail-value',            // Contact commercial, conditions, incoterm
        '.observations-content'     // Observations
    ]"
        />

        <div id="resultatsFournisseurs" class="resultatsClient"></div>

        <div class="items-grid" id="itemsGrid">
            @forelse($fournisseurs as $fournisseur)
                <x-item-card
                    theme="fournisseurs"
                    :title="$fournisseur->Civilite . ' ' . $fournisseur->Nom . ' ' . $fournisseur->Prenom"
                    :subtitle="!empty($fournisseur->siret) ? 'SIRET: ' . $fournisseur->siret : 'Particulier'"
                    :showStatus="true"
                    :status="$fournisseur->actif ?? 1"
                    data-actif="{{ $fournisseur->actif ?? 1 }}"
                    data-siret="{{ !empty($fournisseur->siret) ? 1 : 0 }}"
                    data-has-commercial="{{ !empty($fournisseur->contact_Commercial) ? 1 : 0 }}">

                    {{-- Slot Contact --}}
                    <x-slot:contact>
                        <div class="contact-item">
                            <i data-lucide="mail" class="contact-icon"></i>
                            <span>{{ $fournisseur->Email }}</span>
                        </div>
                        <div class="contact-item">
                            <i data-lucide="phone" class="contact-icon"></i>
                            <span>{{ $fournisseur->Telephone }}</span>
                        </div>
                        @if(!empty($fournisseur->Mobile))
                            <div class="contact-item">
                                <i data-lucide="smartphone" class="contact-icon"></i>
                                <span>{{ $fournisseur->Mobile }}</span>
                            </div>
                        @endif
                    </x-slot:contact>

                    {{-- Slot Adresse --}}
                    <x-slot:address>
                        <i data-lucide="map-pin" class="address-icon"></i>
                        <div class="address-content">
                            <div>{{ $fournisseur->Adresse }}</div>
                            @if(!empty($fournisseur->AdresseSuite))
                                <div>{{ $fournisseur->AdresseSuite }}</div>
                            @endif
                            <div>{{ $fournisseur->CodePostal }} {{ $fournisseur->Ville }}</div>
                            @if(!empty($fournisseur->Pays))
                                <div>{{ $fournisseur->Pays }}</div>
                            @endif
                        </div>
                    </x-slot:address>

                    {{-- Slot Détails (conditionnels) --}}
                    <x-slot:details>
                        <x-slot:fullWidth>true</x-slot:fullWidth>

                        @if(!empty($fournisseur->contact_Commercial))
                            <div class="detail-item">
                                <div class="detail-label">Contact Commercial</div>
                                <div class="detail-value value-commercial-contact">
                                    {{ $fournisseur->contact_Commercial }}
                                </div>
                            </div>
                        @endif

                        @if(!empty($fournisseur->Mail_commercial))
                            <div class="detail-item">
                                <div class="detail-label">Email Commercial</div>
                                <div class="detail-value value-commercial-email">
                                    {{ $fournisseur->Mail_commercial }}
                                </div>
                            </div>
                        @endif

                        @if(!empty($fournisseur->conditioPaiement))
                            <div class="detail-item">
                                <div class="detail-label">Conditions Paiement</div>
                                <div class="detail-value value-payment-conditions">
                                    {{ $fournisseur->conditioPaiement }}
                                </div>
                            </div>
                        @endif

                        @if(!empty($fournisseur->incoterm))
                            <div class="detail-item">
                                <div class="detail-label">Incoterm</div>
                                <div class="detail-value value-incoterm">
                                    {{ $fournisseur->incoterm }}
                                </div>
                            </div>
                        @endif
                    </x-slot:details>

                    {{-- Slot Observations --}}
                    @if(!empty($fournisseur->Observations))
                        <x-slot:observations>
                            <div class="observations-label">
                                <i data-lucide="message-square" class="obs-icon"></i>
                                Observations
                            </div>
                            <div class="observations-content">
                                {{ $fournisseur->Observations }}
                            </div>
                        </x-slot:observations>
                    @endif

                    {{-- Slot Actions --}}
                    <x-slot:actions>
                        <button  class="btn btn-outline btn-sm">
                            <a href="{{ route('gestion.edit', ['fournisseurs', $fournisseur->IDFournisseur]) }}">
                                Modifier
                            </a>
                        </button>
                        <button class="btn btn-outline btn-sm">
                            <i data-lucide="shopping-cart"></i>
                            Commandes
                        </button>
                    </x-slot:actions>
                </x-item-card>

            @empty
                <div class="no-results-content">
                    <div class="no-results-icon">🏢</div>
                    <h3>Aucun fournisseur</h3>
                    <p>Aucun fournisseur n'a été créé pour le moment.</p>
                    <button class="btn btn-primary">
                        {{-- data-url="{{ route('gestion.fournisseurs.create') }}" --}}
                        <i data-lucide="plus"></i>
                        Créer un fournisseur
                    </button>
                </div>
            @endforelse
        </div>
    </div>

    <x-pagination-item :items="$fournisseurs" />

