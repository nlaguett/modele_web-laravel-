@php
    /**
     * Helper function pour générer le HTML des blocs CMS
     * À placer dans app/Helpers/BlockHelper.php
     */

    if (!function_exists('generateBlockHtml')) {
        /**
         * Génère le HTML d'un bloc CMS
         *
         * @param array $block - Tableau contenant les données du bloc
         * @return string - HTML généré
         */
        function generateBlockHtml(array $block) :string {
            // Valeurs par défaut
            $id = $block['id'] ?? 'block-' . uniqid();
            $type = $block['type'] ?? 'text';
            $classes = $block['classes'] ?? '';
            $styles = $block['styles'] ?? '';
            $content = $block['content'] ?? '';

            // Début du bloc
            $html = '<div class="cms-block block-' . e($type) . ' ' . e($classes) . '"
                          data-type="' . e($type) . '"
                          data-id="' . e($id) . '"
                          draggable="true"
                          style="' . e($styles) . '">';

            // Contrôles du bloc
            $html .= '<div class="block-controls">
                        <button onclick="moveBlock(this.closest(\'.cms-block\'), \'up\')" title="Déplacer vers le haut">⬆️</button>
                        <button onclick="moveBlock(this.closest(\'.cms-block\'), \'down\')" title="Déplacer vers le bas">⬇️</button>
                        <button onclick="openBlockSettings(this.closest(\'.cms-block\'))" title="Réglages">⚙️</button>
                        <button onclick="removeBlock(this.closest(\'.cms-block\'))" title="Supprimer">🗑️</button>';

            // Bouton supplémentaire pour les conteneurs
            if (in_array($type, ['container', 'two-columns', 'three-columns'])) {
                $html .= '<button onclick="openAddBlockModal(this.closest(\'.cms-block\'))" title="Ajouter un bloc">➕</button>';
            }

            $html .= '</div>';

            // Contenu selon le type de bloc
            switch ($type) {
                case 'text':
                    $html .= '<p class="editable" contenteditable="false">' . $content . '</p>';
                    break;

                case 'heading':
                    $html .= '<h2 class="editable" contenteditable="false" style="margin:0;">' . $content . '</h2>';
                    break;

                case 'heading3':
                    $html .= '<h3 class="editable" contenteditable="false" style="margin:0;">' . $content . '</h3>';
                    break;

                case 'image':
                    $url = $block['url'] ?? 'https://via.placeholder.com/800x400?text=Image';
                    $caption = $block['caption'] ?? 'Légende de l\'image';
                    $html .= '<img src="' . e($url) . '" alt="' . e($caption) . '" style="max-width:100%; height:auto; border-radius:8px;">';
                    $html .= '<p class="image-caption editable" contenteditable="false" style="text-align:center; font-style:italic; color:#64748b; margin-top:10px;">' . $caption . '</p>';
                    break;

                case 'list':
                    $html .= '<ul class="editable" contenteditable="false" style="padding-left: 20px;">';
                    if (!empty($content)) {
                        $html .= $content;
                    } else {
                        $html .= '<li>Premier élément</li>
                                 <li>Deuxième élément</li>
                                 <li>Troisième élément</li>';
                    }
                    $html .= '</ul>';
                    break;

                case 'quote':
                    $html .= '<blockquote class="editable" contenteditable="false" style="border-left: 4px solid #3b82f6; padding-left: 20px; margin: 0; font-style: italic; color: #475569;">';
                    $html .= $content ?: 'Citation inspirante ici...';
                    $html .= '</blockquote>';
                    break;

                case 'divider':
                    $html .= '<hr style="border: none; border-top: 2px solid #e2e8f0; margin: 20px 0;">';
                    break;

                case 'spacer':
                    $height = $block['height'] ?? '50px';
                    $html .= '<div style="height: ' . e($height) . '; background: repeating-linear-gradient(45deg, #f1f5f9, #f1f5f9 10px, transparent 10px, transparent 20px);"></div>';
                    break;

                case 'container':
                    $containerStyle = 'display:flex; gap:20px; flex-wrap:wrap; background:#f8fafc; padding:20px; border-radius:8px;';
                    $html .= '<div style="' . $containerStyle . '">';

                    if (!empty($block['children']) && is_array($block['children'])) {
                        foreach ($block['children'] as $child) {
                            $html .= generateBlockHtml($child);
                        }
                    } else {
                        $html .= '<p class="editable" contenteditable="false" style="flex:1; min-width:200px; background:white; padding:15px; border-radius:6px;">Conteneur flexible. Ajoutez des blocs ici.</p>';
                    }

                    $html .= '</div>';
                    break;

                case 'two-columns':
                    $html .= '<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; background:#f8fafc; padding:20px; border-radius:8px;">';

                    if (!empty($block['children']) && is_array($block['children'])) {
                        foreach ($block['children'] as $child) {
                            $html .= generateBlockHtml($child);
                        }
                    } else {
                        $html .= '<div class="editable" contenteditable="false" style="background:white; padding:15px; border-radius:6px;">Colonne 1</div>';
                        $html .= '<div class="editable" contenteditable="false" style="background:white; padding:15px; border-radius:6px;">Colonne 2</div>';
                    }

                    $html .= '</div>';
                    break;

                case 'three-columns':
                    $html .= '<div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:15px; background:#f8fafc; padding:20px; border-radius:8px;">';

                    if (!empty($block['children']) && is_array($block['children'])) {
                        foreach ($block['children'] as $child) {
                            $html .= generateBlockHtml($child);
                        }
                    } else {
                        $html .= '<div class="editable" contenteditable="false" style="background:white; padding:15px; border-radius:6px;">Colonne 1</div>';
                        $html .= '<div class="editable" contenteditable="false" style="background:white; padding:15px; border-radius:6px;">Colonne 2</div>';
                        $html .= '<div class="editable" contenteditable="false" style="background:white; padding:15px; border-radius:6px;">Colonne 3</div>';
                    }

                    $html .= '</div>';
                    break;

                default:
                    // Type de bloc personnalisé ou non reconnu
                    $html .= '<div class="editable" contenteditable="false">' . $content . '</div>';
                    break;
            }

            // Fermeture du bloc
            $html .= '</div>';

            return $html;
        }
    }

    /**
     * Helper pour encoder en HTML sécurisé (alias de htmlspecialchars)
     */
    if (!function_exists('e')) {
        function e($value) :string {
            return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
        }
    }
    /**
     * Exemple d'utilisation dans un contrôleur:
     *
     * public function edit($id)
     * {
     *     $post = Post::findOrFail($id);
     *
     *     // Décoder le JSON si nécessaire
     *     if (is_string($post->content_blocks)) {
     *         $post->content_blocks = json_decode($post->content_blocks, true);
     *     }
     *
     *     return view('posts.modif', ['post' => $post]);
     * }
     *
     * public function saveAllModifications(Request $request)
     * {
     *     $validated = $request->validate([
     *         'id' => 'required|integer|exists:posts,id',
     *         'content_blocks' => 'required|array'
     *     ]);
     *
     *     $post = Post::findOrFail($validated['id']);
     *     $post->content_blocks = json_encode($validated['content_blocks']);
     *     $post->save();
     *
     *     return response()->json([
     *         'success' => true,
     *         'message' => 'Page sauvegardée avec succès !'
     *     ]);
     * }
     */
@endphp
