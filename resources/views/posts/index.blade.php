
{{--<div style="width:100%;display:flex;flex-direction:column;align-content:center;justify-content:center;align-items:center;">--}}
{{--    <h1>Mes pages</h1>--}}
{{--</div>--}}

{{--<div class="main-content">--}}
{{--    <div class="list">--}}
{{--        --}}{{-- Header --}}
{{--        <div class="list-item">--}}
{{--            <span>Header</span>--}}
{{--            <div>--}}
{{--                <a href="{{ url('/header') }}"><button class="blue-btn">Voir</button></a>--}}
{{--                <a href="{{ route('posts.edit', 'header') }}"><button class="yellow-btn">Modifier</button></a>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        --}}{{-- Footer --}}
{{--        <div class="list-item">--}}
{{--            <span>Footer</span>--}}
{{--            <div>--}}
{{--                <a href="{{ url('/footer') }}"><button class="blue-btn">Voir</button></a>--}}
{{--                <a href="{{ route('posts.edit', 'footer') }}"><button class="yellow-btn">Modifier</button></a>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        --}}{{-- Posts dynamiques --}}
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

{{--        --}}{{-- Bouton Ajouter --}}
{{--        <div class="list-item">--}}
{{--            <span>&nbsp;</span>--}}
{{--            <div>--}}
{{--                <a href="{{ route('posts.create') }}"><button class="green-btn">Ajouter</button></a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}


    <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pages - Gestion</title>
    <style>
        :root {
            /* Couleurs principales */
            --primary-color: #0458A7;
            --primary-light: #edf0fb;
            --primary-dark: #0f2a65;
            --secondary-color: #3b3f5c;
            --gray-light: #f5f7ff;
            --gray-medium: #e6e9f4;
            --gray-dark: #828795;
            --danger: #f36c6c;
            --success: #2dbf78;
            --white: #ffffff;
            --text-primary: #262a39;
            --text-secondary: #6c7380;
            --card-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            --sidebar-width: 280px;
            --header-height: 80px;
            --border-radius: 18px;
            --warning: #fbbf24;
            --info: #3b82f6;
            --background: #f8fafc;
            --surface: #ffffff;
            --border: #e2e8f0;
            --btn-primary: #111111;
            --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --purple: #8b5cf6;
            --text-muted: #9ca3af;
            --background-alt: #f3f4f6;
            --border-light: #f3f4f6;
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --transition: all 0.2s ease;
            --transition-slow: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: var(--background);
            color: var(--text-primary);
        }

        .pages-container {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 2rem;
            padding: 2rem;
            max-width: 1800px;
            margin: 0 auto;
        }

        @media (max-width: 1200px) {
            .pages-container {
                grid-template-columns: 1fr;
            }

            .edit-sidebar {
                position: fixed;
                right: -400px;
                top: 0;
                bottom: 0;
                width: 380px;
                background: var(--surface);
                box-shadow: var(--shadow-xl);
                transition: var(--transition-slow);
                z-index: 100;
                overflow-y: auto;
            }

            .edit-sidebar.active {
                right: 0;
            }

            .close-btn {
                display: block !important;
            }
        }

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-header h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .search-box {
            position: relative;
            width: 100%;
            max-width: 400px;
        }

        .search-box input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 3rem;
            border: 1px solid var(--border);
            border-radius: 12px;
            font-size: 0.95rem;
            background: var(--surface);
            transition: var(--transition);
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(4, 88, 167, 0.1);
        }

        .search-box svg {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            width: 1.25rem;
            height: 1.25rem;
            color: var(--text-secondary);
        }

        .main-content {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .content-card {
            background: var(--surface);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            padding: 1.5rem;
        }

        .content-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .content-header h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .btn-new {
            padding: 0.75rem 1.5rem;
            background: var(--primary-color);
            color: var(--white);
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-new:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .pages-table {
            width: 100%;
            border-collapse: collapse;
        }

        .pages-table thead {
            border-bottom: 2px solid var(--border);
        }

        .pages-table th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .pages-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-light);
        }

        .pages-table tbody tr {
            transition: var(--transition);
            cursor: pointer;
        }

        .pages-table tbody tr:hover {
            background: var(--gray-light);
        }

        .pages-table tbody tr.selected {
            background: var(--primary-light);
        }

        .page-checkbox {
            width: 1.25rem;
            height: 1.25rem;
            cursor: pointer;
            accent-color: var(--primary-color);
        }

        .page-title {
            font-weight: 500;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .page-icon {
            width: 1.25rem;
            height: 1.25rem;
            color: var(--text-secondary);
        }

        .page-author {
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        .page-status {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 999px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .page-status.published {
            background: rgba(45, 191, 120, 0.15);
            color: var(--success);
        }

        .page-status.draft {
            background: rgba(251, 191, 36, 0.15);
            color: var(--warning);
        }

        .pagination {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-light);
        }

        .pagination-btn {
            padding: 0.5rem;
            border: 1px solid var(--border);
            background: var(--surface);
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
        }

        .pagination-btn:hover:not(:disabled) {
            background: var(--gray-light);
            border-color: var(--primary-color);
        }

        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .pagination-btn svg {
            width: 1.25rem;
            height: 1.25rem;
            color: var(--text-primary);
            display: block;
        }

        .pagination-info {
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        .page-preview {
            background: var(--gray-light);
            border-radius: 12px;
            padding: 2rem;
            border: 1px solid var(--border);
        }

        .preview-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border);
            margin-bottom: 2rem;
        }

        .preview-title {
            font-weight: 600;
            color: var(--text-primary);
        }

        .preview-menu {
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 8px;
            transition: var(--transition);
        }

        .preview-menu:hover {
            background: var(--gray-medium);
        }

        .preview-content h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .preview-content p {
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .preview-btn {
            padding: 0.75rem 1.5rem;
            background: var(--primary-color);
            color: var(--white);
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .preview-btn:hover {
            background: var(--primary-dark);
        }

        .edit-sidebar {
            background: var(--surface);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            padding: 1.5rem;
            height: fit-content;
            position: sticky;
            top: 2rem;
        }

        .edit-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border);
        }

        .edit-header h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .close-btn {
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 8px;
            transition: var(--transition);
            display: none;
        }

        .close-btn:hover {
            background: var(--gray-light);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 0.95rem;
            transition: var(--transition);
            background: var(--surface);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(4, 88, 167, 0.1);
        }

        .page-settings-title {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1rem;
            font-size: 1rem;
        }

        .layout-options {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .layout-option {
            aspect-ratio: 1;
            border: 2px solid var(--border);
            border-radius: 10px;
            background: var(--surface);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .layout-option:hover {
            border-color: var(--primary-color);
            background: var(--primary-light);
        }

        .layout-option.active {
            border-color: var(--primary-color);
            background: var(--primary-color);
        }

        .layout-option svg {
            width: 2rem;
            height: 2rem;
            color: var(--text-secondary);
        }

        .layout-option.active svg {
            color: var(--white);
        }

        .flexbox-controls {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .flexbox-btn {
            padding: 0.75rem;
            border: 1px solid var(--border);
            background: var(--surface);
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .flexbox-btn:hover {
            background: var(--gray-light);
            border-color: var(--primary-color);
        }

        .flexbox-btn.active {
            background: var(--primary-light);
            border-color: var(--primary-color);
        }

        .flexbox-btn svg {
            width: 1.25rem;
            height: 1.25rem;
            color: var(--text-primary);
        }

        .preview-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 2rem;
        }

        .preview-card h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .preview-card p {
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .preview-card-btn {
            padding: 0.75rem 1.5rem;
            background: var(--primary-color);
            color: var(--white);
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .preview-card-btn:hover {
            background: var(--primary-dark);
        }

        .action-buttons {
            display: flex;
            gap: 0.75rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border);
        }

        .btn-save {
            flex: 1;
            padding: 0.875rem 1.5rem;
            background: var(--primary-color);
            color: var(--white);
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-save:hover {
            background: var(--primary-dark);
        }

        .btn-cancel {
            padding: 0.875rem 1.5rem;
            background: var(--surface);
            color: var(--text-primary);
            border: 1px solid var(--border);
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-cancel:hover {
            background: var(--gray-light);
        }
    </style>
</head>
<body>
<div class="pages-container">
    <!-- Contenu principal -->
    <div class="main-content">
        <!-- En-tête avec recherche -->
        <div class="page-header">
            <h1>Pages</h1>
            <div class="search-box">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" placeholder="Search..." id="searchPages">
            </div>
        </div>

        <!-- Card principale -->
        <div class="content-card">
            <div class="content-header">
                <h2>Home</h2>
                <a href="#" class="btn-new">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    New Page
                </a>
            </div>

            <!-- Tableau des pages -->
            <table class="pages-table">
                <thead>
                <tr>
                    <th style="width: 40px;">
                        <input type="checkbox" class="page-checkbox">
                    </th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                <tr class="selected" onclick="selectRow(this)">
                    <td>
                        <input type="checkbox" class="page-checkbox" onclick="event.stopPropagation()">
                    </td>
                    <td>
                        <div class="page-title">
                            <svg class="page-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Home
                        </div>
                    </td>
                    <td class="page-author">admin</td>
                    <td>
                        <span class="page-status published">Published</span>
                    </td>
                </tr>
                <tr onclick="selectRow(this)">
                    <td>
                        <input type="checkbox" class="page-checkbox" onclick="event.stopPropagation()">
                    </td>
                    <td>
                        <div class="page-title">
                            <svg class="page-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            About
                        </div>
                    </td>
                    <td class="page-author">admin</td>
                    <td>
                        <span class="page-status published">Published</span>
                    </td>
                </tr>
                <tr onclick="selectRow(this)">
                    <td>
                        <input type="checkbox" class="page-checkbox" onclick="event.stopPropagation()">
                    </td>
                    <td>
                        <div class="page-title">
                            <svg class="page-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Services
                        </div>
                    </td>
                    <td class="page-author">admin</td>
                    <td>
                        <span class="page-status published">Published</span>
                    </td>
                </tr>
                <tr onclick="selectRow(this)">
                    <td>
                        <input type="checkbox" class="page-checkbox" onclick="event.stopPropagation()">
                    </td>
                    <td>
                        <div class="page-title">
                            <svg class="page-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Portfolio
                        </div>
                    </td>
                    <td class="page-author">admin</td>
                    <td>
                        <span class="page-status published">Published</span>
                    </td>
                </tr>
                <tr onclick="selectRow(this)">
                    <td>
                        <input type="checkbox" class="page-checkbox" onclick="event.stopPropagation()">
                    </td>
                    <td>
                        <div class="page-title">
                            <svg class="page-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Contact
                        </div>
                    </td>
                    <td class="page-author">admin</td>
                    <td>
                        <span class="page-status published">Published</span>
                    </td>
                </tr>
                <tr onclick="selectRow(this)">
                    <td>
                        <input type="checkbox" class="page-checkbox" onclick="event.stopPropagation()">
                    </td>
                    <td>
                        <div class="page-title">
                            <svg class="page-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Blog
                        </div>
                    </td>
                    <td class="page-author">admin</td>
                    <td>
                        <span class="page-status draft">Apr 24:24</span>
                    </td>
                </tr>
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="pagination">
                <button class="pagination-btn" disabled>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button class="pagination-btn">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path>
                    </svg>
                </button>
                <span class="pagination-info">1 of 1</span>
                <button class="pagination-btn" disabled>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Prévisualisation -->
        <div class="content-card">
            <div class="page-preview">
                <div class="preview-header">
                    <span class="preview-title">Home</span>
                    <button class="preview-menu">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
                <div class="preview-content">
                    <h2>Welcome to Our Website</h2>
                    <p>Lorem ipsum dolor amet, consecrer tuttua.</p>
                    <button class="preview-btn">Learn More</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar d'édition -->
    <div class="edit-sidebar" id="editSidebar">
        <div class="edit-header">
            <h3>Edit Page</h3>
            <button class="close-btn" onclick="closeSidebar()">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form>
            <div class="form-group">
                <label class="form-label">Title</label>
                <input type="text" class="form-input" value="Home" name="title">
            </div>

            <div class="form-group">
                <label class="page-settings-title">Page Settings</label>
                <div class="layout-options">
                    <button type="button" class="layout-option" onclick="selectLayout(this)">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path>
                        </svg>
                    </button>
                    <button type="button" class="layout-option active" onclick="selectLayout(this)">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                        </svg>
                    </button>
                    <button type="button" class="layout-option" onclick="selectLayout(this)">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V5z"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label class="page-settings-title">Flexbox</label>
                <div class="flexbox-controls">
                    <button type="button" class="flexbox-btn" onclick="selectFlexbox(this)">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <button type="button" class="flexbox-btn active" onclick="selectFlexbox(this)">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8M4 18h16"></path>
                        </svg>
                    </button>
                    <button type="button" class="flexbox-btn" onclick="selectFlexbox(this)">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                    <button type="button" class="flexbox-btn" onclick="selectFlexbox(this)">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M8 12h8M4 18h16"></path>
                        </svg>
                    </button>
                    <button type="button" class="flexbox-btn" onclick="selectFlexbox(this)">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6M12 9v6"></path>
                        </svg>
                    </button>
                    <button type="button" class="flexbox-btn" onclick="selectFlexbox(this)">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="preview-card">
                <h3>Welcome to Our Website</h3>
                <p>Lorem ipsum dolor amet, consecrer tuttua.</p>
                <button type="button" class="preview-card-btn">Learn More</button>
            </div>

            <div class="action-buttons">
                <button type="button" class="btn-save">Save Changes</button>
                <button type="button" class="btn-cancel" onclick="closeSidebar()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    function selectRow(row) {
        document.querySelectorAll('.pages-table tbody tr').forEach(r => {
            r.classList.remove('selected');
        });
        row.classList.add('selected');

        if (window.innerWidth <= 1200) {
            document.getElementById('editSidebar').classList.add('active');
        }
    }

    function closeSidebar() {
        document.getElementById('editSidebar').classList.remove('active');
    }

    function selectLayout(btn) {
        document.querySelectorAll('.layout-option').forEach(b => {
            b.classList.remove('active');
        });
        btn.classList.add('active');
    }

    function selectFlexbox(btn) {
        document.querySelectorAll('.flexbox-btn').forEach(b => {
            b.classList.remove('active');
        });
        btn.classList.add('active');
    }

    // Recherche
    document.getElementById('searchPages').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('.pages-table tbody tr');

        rows.forEach(row => {
            const title = row.querySelector('.page-title').textContent.toLowerCase();
            if (title.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
</body>
</html>
