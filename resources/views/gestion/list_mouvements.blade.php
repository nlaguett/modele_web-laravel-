
    <div class="container_vignette">
        <div class="header_vignette">
            <h1 class="theme-mouvements">Gestion des Mouvements</h1>
            <p>Suivez et gérez tous les mouvements de stock</p>
        </div>


        <div class="stats-bar">
            <div class="stat-card" data-filter="all" onclick="filterMouvements('all')">
                <div class="stat-number" style="color: var(--primary);">{{ $mouvements_Count ?? 324 }}</div>
                <div class="stat-label">Mouvements Total</div>
            </div>
            <div class="stat-card" data-filter="entrees" onclick="filterMouvements('entrees')">
                <div class="stat-number" style="color: var(--success);">{{ $entreesCount ?? 156 }}</div>
                <div class="stat-label">Entrées Stock</div>
            </div>
            <div class="stat-card" data-filter="sorties" onclick="filterMouvements('sorties')">
                <div class="stat-number" style="color: var(--warning);">{{ $sortiesCount ?? 89 }}</div>
                <div class="stat-label">Sorties Stock</div>
            </div>
            <div class="stat-card" data-filter="aujourdhui" onclick="filterMouvements('aujourdhui')">
                <div class="stat-number" style="color: var(--info);">{{ $aujourdhuiCount ?? 12 }} </div>
                <div class="stat-label">Aujourd'hui</div>
            </div>
        </div>



        <x-searchbar
            search-id="searchMouvements"
            target-grid="itemsGrid"
            placeholder="Rechercher un mouvement..."
            create-route="{{ route('gestion.create', ['type' => 'mouvements']) }}"
            create-label="Nouveeau mouvement"
            item-label="mouvements"
        />

        <div id="resultatsMouvements" class="resultatsClient"></div>

        <div class="items-grid" id="itemsGrid">
            @foreach($mouvements as $mouvement)
                <div class="item-card theme-mouvements"
                     data-type="{{ $mouvement->IDtype_mouvement_stock ?? 0 }}"
                     data-date="{{ $mouvement->DateMouvement ?? '' }}"
                     data-quantite="{{ $mouvement->Quantite ?? 0 }}">

                    <div class="item-header">
                        <div>
                            <div class="item-title">{{ $mouvement->reference }}</div>
                            <div class="item-reference">
                                {{ !empty($mouvement->Ref_fournisseur) ? 'Ref: ' . $mouvement->Ref_fournisseur : 'Mouvement interne' }}
                            </div>
                        </div>
                        <div class="movement-badge movement-{{ (!empty($mouvement->IDtype_mouvement_stock) && $mouvement->IDtype_mouvement_stock == 1) ? 'in' : 'out' }}">
                            {{ (!empty($mouvement->IDtype_mouvement_stock) && $mouvement->IDtype_mouvement_stock == 1) ? 'Entrée' : 'Sortie' }}
                        </div>
                    </div>

                    <div class="item-description">
                        {{ !empty($mouvement->Observations) ? $mouvement->Observations : 'Mouvement de stock - ' . $mouvement->reference }}
                    </div>

                    <div class="movement-info">
                        <div class="info-row">
                            <div class="info-item">
                                <i data-lucide="package" class="info-icon"></i>
                                <span><strong>{{ number_format($mouvement->Quantite, 0, ',', ' ') }}</strong> unités</span>
                            </div>
                            @if(!empty($mouvement->PrixAchatHT))
                                <div class="info-item">
                                    <i data-lucide="euro" class="info-icon"></i>
                                    <span><strong>{{ number_format($mouvement->PrixAchatHT, 2, ',', ' ') }}€</strong> HT</span>
                                </div>
                            @endif
                        </div>
                        @if(!empty($mouvement->DateMouvement))
                            <div class="info-row">
                                <div class="info-item">
                                    <i data-lucide="calendar" class="info-icon"></i>
                                    <span>{{ \Carbon\Carbon::parse($mouvement->DateMouvement)->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="item-details full-width">
                        @if(!empty($mouvement->IDEntreeStock))
                            <div class="detail-item">
                                <div class="detail-label">Entrée Stock</div>
                                <div class="detail-value value-entry-stock">
                                    {{ $mouvement->IDEntreeStock }}
                                </div>
                            </div>
                        @endif

                        @if(!empty($mouvement->IDemplacement))
                            <div class="detail-item">
                                <div class="detail-label">Emplacement</div>
                                <div class="detail-value value-location">
                                    {{ $mouvement->IDemplacement }}
                                </div>
                            </div>
                        @endif

                        @if(!empty($mouvement->SaisiPar))
                            <div class="detail-item">
                                <div class="detail-label">Saisi Par</div>
                                <div class="detail-value value-user">
                                    {{ $mouvement->SaisiPar }}
                                </div>
                            </div>
                        @endif

                        @if(!empty($mouvement->ModifiePar))
                            <div class="detail-item">
                                <div class="detail-label">Modifié Par</div>
                                <div class="detail-value value-user">
                                    {{ $mouvement->ModifiePar }}
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="item-actions">
                        <button class="btn btn-outline btn-sm">
                            <i data-lucide="eye"></i>
                            Voir Détails
                        </button>
                        <button  class="btn btn-outline btn-sm">
                            <a href="{{ route('gestion.edit', ['mouvements', $mouvement->IDtype_mouvement_stock]) }}">
                                Modifier
                            </a>
                        </button>
                        <button class="btn btn-outline btn-sm">
                            <i data-lucide="printer"></i>
                            Imprimer
                        </button>
                    </div>
                </div>

            @endforeach
        </div>
    </div>

    <!-- FOOTER / PAGINATION -->
    <x-pagination-item :items="$mouvements" />

