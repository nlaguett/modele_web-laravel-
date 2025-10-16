<div class="main-content">
<div class="container_vignette">
        <div class="header_vignette">
            <h1 class="theme-categories">Gestion des Catégories</h1>
            <p>Organisez et gérez vos catégories d'articles efficacement</p>
        </div>

        <div class="stats-bar">
            <div class="stat-card">
                <div class="stat-number" style="color: var(--primary-color);">{{ $Categories_Count }}</div>
                <div class="stat-label">Catégories Total</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: var(--success);">38</div>
                <div class="stat-label">Catégories Actives</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: var(--warning);">247</div>
                <div class="stat-label">Articles Liés</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: var(--info);">4</div>
                <div class="stat-label">Catégories Vides</div>
            </div>
        </div>

        {{-- resources/views/categories/index.blade.php --}}

        <x-searchbar
            search-id="searchCategories"
            target-grid="categoriesGrid"
            placeholder="Rechercher une catégorie..."
            create-route="{{ route('gestion.create', ['type' => 'categories']) }}"
            create-label="Nouvelle catégorie"
            item-label="catégories"
            :show-export="false"
        />



        <div id="resultatsCategories" class="resultatsClient"></div>


        {{-- Liste des catégories --}}
        <div class="items-grid" id="categoriesGrid">
            @foreach($categories as $categorie)
                <x-item-card
                    theme="categories"
                    :title="$categorie->libelle ?? 'Sans titre'"
                    :description="$categorie->Description_categorie_article"
                    :showStatus="false">
                    {{-- Pas de subtitle, pas de status pour les catégories --}}

                    {{-- Slot pour les détails (1 seul champ) --}}
                    <x-slot:details>
                        <div class="detail-item">
                            <div class="detail-label">Articles Liés</div>
                            <div class="detail-value value-articles-count">
                                {{-- {{ $categorie->articles->count() ?? 0 }} articles --}}
                                0 articles {{-- À remplacer quand tu auras la relation --}}
                            </div>
                        </div>
                    </x-slot:details>

                    {{-- Slot pour les actions (différentes des articles) --}}
                    <x-slot:actions>
                        <button class="btn btn-outline btn-sm">
                            <i data-lucide="eye"></i>
                            Voir Articles
                        </button>
                        <button class="btn btn-outline btn-sm">
                            <a href="{{ route('gestion.edit', ['categories', $categorie->IDcategorie_article]) }}">
                                Modifier
                            </a>
                        </button>

                    </x-slot:actions>
                </x-item-card>
            @endforeach
        </div>


</div>
    {{--    pagination--}}
    {{ $categories->links() }}
</div>

