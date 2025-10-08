@props(['items'])

@if($items->hasPages())
    <div class="footer_list">
        <div class="pagination-container">
            <div class="pagination-info">
                <span class="pagination-text">
                    Affichage de
                    <strong>{{ $items->firstItem() }}</strong>
                    à
                    <strong>{{ $items->lastItem() }}</strong>
                    sur
                    <strong>{{ $items->total() }}</strong>
                    résultats
                </span>
            </div>

            <nav class="pagination-nav" role="navigation" aria-label="Pagination">
                <ul class="pagination-list">
                    {{-- Bouton Première Page --}}
                    @if ($items->currentPage() > 1)
                        <li class="pagination-item">
                            <a href="#" class="pagination-link ajax-pagination" data-page="1" title="Première page">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="11 17 6 12 11 7"></polyline>
                                    <polyline points="18 17 13 12 18 7"></polyline>
                                </svg>
                            </a>
                        </li>
                    @else
                        <li class="pagination-item disabled">
                            <span class="pagination-link" title="Première page">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="11 17 6 12 11 7"></polyline>
                                    <polyline points="18 17 13 12 18 7"></polyline>
                                </svg>
                            </span>
                        </li>
                    @endif

                    {{-- Bouton Précédent --}}
                    @if ($items->onFirstPage())
                        <li class="pagination-item disabled">
                            <span class="pagination-link">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="15 18 9 12 15 6"></polyline>
                                </svg>
                            </span>
                        </li>
                    @else
                        <li class="pagination-item">
                            <a href="#" class="pagination-link ajax-pagination" data-page="{{ $items->currentPage() - 1 }}" rel="prev">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="15 18 9 12 15 6"></polyline>
                                </svg>
                            </a>
                        </li>
                    @endif

                    {{-- Seulement 3 pages autour de la page courante --}}
                    @php
                        $start = max($items->currentPage() - 1, 1);
                        $end = min($items->currentPage() + 1, $items->lastPage());

                        // Ajuster pour toujours avoir 3 pages si possible
                        if ($end - $start < 2) {
                            if ($items->currentPage() <= 2) {
                                $end = min(3, $items->lastPage());
                            } else {
                                $start = max($items->lastPage() - 2, 1);
                            }
                        }
                    @endphp

                    @for($page = $start; $page <= $end; $page++)
                        @if ($page == $items->currentPage())
                            <li class="pagination-item active">
                                <span class="pagination-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="pagination-item">
                                <a href="#" class="pagination-link ajax-pagination" data-page="{{ $page }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endfor

                    {{-- Bouton "..." pour aller à une page personnalisée --}}
                    <li class="pagination-item">
                        <button type="button" class="pagination-link goto-page-btn" title="Aller à une page">
                            ...
                        </button>
                    </li>

                    {{-- Bouton Suivant --}}
                    @if ($items->hasMorePages())
                        <li class="pagination-item">
                            <a href="#" class="pagination-link ajax-pagination" data-page="{{ $items->currentPage() + 1 }}" rel="next">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </a>
                        </li>
                    @else
                        <li class="pagination-item disabled">
                            <span class="pagination-link">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </span>
                        </li>
                    @endif

                    {{-- Bouton Dernière Page --}}
                    @if ($items->currentPage() < $items->lastPage())
                        <li class="pagination-item">
                            <a href="#" class="pagination-link ajax-pagination" data-page="{{ $items->lastPage() }}" title="Dernière page">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="13 17 18 12 13 7"></polyline>
                                    <polyline points="6 17 11 12 6 7"></polyline>
                                </svg>
                            </a>
                        </li>
                    @else
                        <li class="pagination-item disabled">
                            <span class="pagination-link" title="Dernière page">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="13 17 18 12 13 7"></polyline>
                                    <polyline points="6 17 11 12 6 7"></polyline>
                                </svg>
                            </span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>

    {{-- Modal pour saisir le numéro de page --}}
    <div class="goto-page-modal" id="gotoPageModal" style="display: none;">
        <div class="goto-page-modal-content">
            <div class="goto-page-modal-header">
                <h3>Aller à la page</h3>
                <button type="button" class="close-modal" aria-label="Fermer">×</button>
            </div>
            <div class="goto-page-modal-body">
                <label for="pageNumberInput">Numéro de page (1-{{ $items->lastPage() }})</label>
                <input
                    type="number"
                    id="pageNumberInput"
                    class="page-number-input"
                    min="1"
                    max="{{ $items->lastPage() }}"
                    value="{{ $items->currentPage() }}"
                    placeholder="Ex: {{ $items->lastPage() }}"
                >
            </div>
            <div class="goto-page-modal-footer">
                <button type="button" class="btn-cancel">Annuler</button>
                <button type="button" class="btn-goto">Aller à la page</button>
            </div>
        </div>
    </div>

    <style>
        .footer_list {
            margin-top: 2rem;
            padding: 1.5rem 0;
            border-top: 1px solid #e5e7eb;
        }

        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .pagination-info {
            color: #6b7280;
            font-size: 0.875rem;
        }

        .pagination-text {
            display: inline-block;
        }

        .pagination-text strong {
            color: #111827;
            font-weight: 600;
        }

        .pagination-nav {
            display: flex;
        }

        .pagination-list {
            display: flex;
            list-style: none;
            gap: 0.5rem;
            margin: 0;
            padding: 0;
            align-items: center;
        }

        .pagination-item {
            display: inline-flex;
        }

        .pagination-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            background-color: #ffffff;
            color: #374151;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
            min-width: 40px;
            justify-content: center;
        }

        .pagination-link:hover {
            background-color: #f9fafb;
            border-color: #d1d5db;
            color: #111827;
        }

        .pagination-item.active .pagination-link {
            background-color: var(--primary, #3b82f6);
            border-color: var(--primary, #3b82f6);
            color: #ffffff;
            font-weight: 600;
        }

        .pagination-item.active .pagination-link:hover {
            background-color: var(--primary-dark, #2563eb);
            border-color: var(--primary-dark, #2563eb);
        }

        .pagination-item.disabled .pagination-link {
            background-color: #f9fafb;
            border-color: #e5e7eb;
            color: #9ca3af;
            cursor: not-allowed;
            pointer-events: none;
        }

        .pagination-link svg {
            width: 16px;
            height: 16px;
            stroke-width: 2;
        }

        /* Bouton "..." */
        .goto-page-btn {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            font-weight: 700;
            letter-spacing: 2px;
        }

        .goto-page-btn:hover {
            background-color: #f0f9ff;
            border-color: var(--primary, #3b82f6);
            color: var(--primary, #3b82f6);
        }

        /* Modal */
        .goto-page-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .goto-page-modal-content {
            background-color: #ffffff;
            border-radius: 0.75rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            width: 90%;
            max-width: 400px;
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .goto-page-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .goto-page-modal-header h3 {
            margin: 0;
            font-size: 1.125rem;
            font-weight: 600;
            color: #111827;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 1.75rem;
            color: #9ca3af;
            cursor: pointer;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.375rem;
            transition: all 0.2s;
        }

        .close-modal:hover {
            background-color: #f3f4f6;
            color: #111827;
        }

        .goto-page-modal-body {
            padding: 1.5rem;
        }

        .goto-page-modal-body label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
        }

        .page-number-input {
            width: 100%;
            padding: 0.625rem 0.875rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .page-number-input:focus {
            outline: none;
            border-color: var(--primary, #3b82f6);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .goto-page-modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            padding: 1rem 1.5rem;
            border-top: 1px solid #e5e7eb;
        }

        .btn-cancel,
        .btn-goto {
            padding: 0.5rem 1.25rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
        }

        .btn-cancel {
            background-color: #ffffff;
            color: #374151;
            border: 1px solid #d1d5db;
        }

        .btn-cancel:hover {
            background-color: #f9fafb;
        }

        .btn-goto {
            background-color: var(--primary, #3b82f6);
            color: #ffffff;
        }

        .btn-goto:hover {
            background-color: var(--primary-dark, #2563eb);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .pagination-container {
                flex-direction: column;
                align-items: center;
            }

            .pagination-info {
                order: 2;
                text-align: center;
            }

            .pagination-nav {
                order: 1;
            }

            .pagination-link {
                padding: 0.4rem 0.75rem;
                font-size: 0.8125rem;
            }
        }

        @media (max-width: 480px) {
            .pagination-list {
                gap: 0.25rem;
            }

            .pagination-link {
                padding: 0.375rem 0.625rem;
                font-size: 0.75rem;
            }

            .pagination-link svg {
                width: 14px;
                height: 14px;
            }

            .goto-page-modal-content {
                width: 95%;
            }
        }
    </style>
@endif
