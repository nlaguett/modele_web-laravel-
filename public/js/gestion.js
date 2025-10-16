// public/js/gestion.js

const Gestion = {
    init: function () {
        console.log('Gestion initialisée');
        this.setupAjax();
        this.setupEventListeners();
        this.setupNavigation();
    },

    setupAjax: function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': AppConfig.csrfToken
            }
        });
    },

    setupEventListeners: function () {
        // Menu Toggle
        $("#toggleNav").on('click', () => {
            $("nav").toggle();
        });

        // Sidebar Toggle
        $("#toggleMenu").on('click', () => {
            $(".nav-menu").toggleClass("collapsed");
        });

        // Submenu
        $(document).on('click', '.has-submenu > a', function (e) {
            e.preventDefault();
            console.log("clic .has-submenu > a");
            $(this).parent().toggleClass('open');
        });

        // Bouton ajouter
        $(document).on("click", ".btn-add", function () {
            console.log("btn-add");
            let url = $(this).data("url");
            console.log(url);
            Gestion.loadContent(url);
        });

        // Liens AJAX
        $(document).on("click", ".ajax-link", function (e) {
            console.log("ajax-link");
            e.preventDefault();
            let pageUrl = $(this).attr("href");
            console.log(pageUrl);
            Gestion.loadContent(pageUrl);
        });

        // Liens dynamiques
        $('#contentArea').on('click', 'a.dynamic-link', function (e) {
            e.preventDefault();
            const url = $(this).attr('href');
            Gestion.loadContent(url);
        });
    },


    loadContent: function (url) {
        $("#contentArea").fadeOut(200, function () {
            const contentArea = $(this);

            $.get(url, function (response) {
                try {
                    const data = JSON.parse(response);
                    if (data.redirect) {
                        window.location.href = data.redirect;
                        return;
                    }
                } catch (e) {
                    // Pas du JSON, continuer
                }

                contentArea.html(response).fadeIn(200);
            }).fail(function () {
                contentArea.html('<h1>Erreur</h1><p>Impossible de charger le contenu.</p>').fadeIn(200);
            });
        });
    },
}

// Auto-initialisation
    $(document).ready(function () {
        Gestion.init();
    })

