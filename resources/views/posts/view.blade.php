
Hello


<h1>{{ $post->title }}</h1>
<p>Auteur : {{ $post->content }}</p>


@php

/*
 * ## 🎯 Comment ça marche en pratique

### Exemple 1 : Page Technologies

**Base de données :**
```
id: 2
slug: technologies
title: Méthodologies
content: <div class="methodology-section">...</div>
```

**URLs :**
- 👁️ **Affichage public** : `modeleweb.com/posts/technologies`
- ✏️ **Mode édition** : `modeleweb.com/posts/technologies?action=edit`

### Exemple 2 : Page Accueil

**Base de données :**
```
id: 1
slug: accueil
title: Bienvenue
content: <h1>Bienvenue sur notre site</h1>...
```

**URLs :**
- 👁️ **Affichage public** : `modeleweb.com/posts/accueil`
- ✏️ **Mode édition** : `modeleweb.com/posts/accueil?action=edit`

---

## 🎨 Flux complet
```
Visiteur tape : modeleweb.com/posts/technologies
                     ↓
         Route catch-all : /{slug}
                     ↓
    Contrôleur show($request, 'technologies')
                     ↓
           Cherche Post où slug='technologies'
                     ↓
    ┌────────────────┴────────────────┐
    │                                 │
    │ ?action=edit présent ?          │
    │                                 │
    ├─ NON → Affiche posts.view      │
    │         (page publique)         │
    │                                 │
    └─ OUI → Est admin ?              │
            ├─ OUI → posts.modif      │
            │         (éditeur)       │
            └─ NON → Erreur 403       │
 */
@endphp
