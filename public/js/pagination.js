// // public/js/pagination.js
//
// const Pagination = {
//     currentPage: 1,
//     perPage: 10,
//     totalPages: 1,
//     currentUrl: null,
//
//     init: function() {
//         // Charger la config
//         if (typeof PaginationConfig !== 'undefined') {
//             this.currentPage = PaginationConfig.currentPage;
//             this.perPage = PaginationConfig.perPage;
//             this.totalPages = PaginationConfig.totalPages;
//         }
//
//         console.log('Pagination initialisée:', this.currentPage, '/', this.totalPages);
//
//         this.setupEventListeners();
//     },
//
//     setupEventListeners: function() {
//         const self = this;
//
//         // ✅ Clic sur les liens de pagination AJAX
//         $(document).on('click', '.ajax-pagination', function(e) {
//             e.preventDefault();
//
//             const page = $(this).data('page');
//             console.log('Pagination cliquée - Page:', page);
//
//             if (page) {
//                 self.loadPage(page);
//             }
//         });
//
//         // ✅ Bouton "..." pour aller à une page spécifique
//         $(document).on('click', '.goto-page-btn', function(e) {
//             e.preventDefault();
//             self.showPageInput();
//         });
//
//         // ✅ Fallback pour les liens standards de pagination Laravel
//         $(document).on('click', '.pagination-link:not(.ajax-pagination):not(.goto-page-btn)', function(e) {
//             e.preventDefault();
//             const url = $(this).attr('href');
//             if (url && url !== '#') {
//                 self.loadPageByUrl(url);
//             }
//         });
//     },
//
//     loadPage: function(page) {
//         console.log('Chargement de la page:', page);
//
//         // Construire l'URL avec le paramètre page
//         const currentPath = window.location.pathname;
//         const url = `${currentPath}?page=${page}`;
//
//         this.loadPageByUrl(url);
//     },
//
//     loadPageByUrl: function(url) {
//         console.log('Chargement URL:', url);
//
//         $("#contentArea").fadeOut(200, function() {
//             const contentArea = $(this);
//
//             $.ajax({
//                 url: url,
//                 method: 'GET',
//                 success: function(response) {
//                     try {
//                         const data = JSON.parse(response);
//                         if (data.redirect) {
//                             window.location.href = data.redirect;
//                             return;
//                         }
//                     } catch (e) {
//                         // Ce n'est pas du JSON, continuer
//                     }
//
//                     contentArea.html(response).fadeIn(200);
//                     console.log('✅ Page chargée avec succès');
//                 },
//                 error: function(xhr, status, error) {
//                     console.error('❌ Erreur de chargement:', error);
//                     contentArea.html('<h1>Erreur</h1><p>Impossible de charger le contenu demandé.</p>').fadeIn(200);
//                 }
//             });
//         });
//     },
//
//     showPageInput: function() {
//         const page = prompt(`Aller à la page (1-${this.totalPages}):`);
//
//         if (page) {
//             const pageNum = parseInt(page);
//             if (pageNum >= 1 && pageNum <= this.totalPages) {
//                 this.loadPage(pageNum);
//             } else {
//                 alert(`Veuillez entrer un numéro entre 1 et ${this.totalPages}`);
//             }
//         }
//     },
//
//     changePage: function(page) {
//         if (page < 1 || page > this.totalPages) {
//             console.warn('Page hors limites:', page);
//             return;
//         }
//
//         this.loadPage(page);
//     }
// };
//
// // Exposer globalement
// window.Pagination = Pagination;
// window.changePage = function(page) {
//     Pagination.changePage(page);
// };
//
// // Auto-initialisation
// $(document).ready(function() {
//     Pagination.init();
// });
