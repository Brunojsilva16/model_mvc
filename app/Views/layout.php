<?php

use App\Core\Auth;

// Garante que a sessão está iniciada para verificar o login
Auth::init();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Clínica Assista' ?></title>

    <!-- Favicon -->
    <link rel="icon" href="<?= defined('URL_BASE') ? URL_BASE : '' ?>/assets/img/favicon.png" sizes="32x32">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Ícones Lucide -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Fontes -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-5px); box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1); }
    </style>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }
    </style>

    <?php if (isset($pageStyles) && is_array($pageStyles)): ?>
        <?php foreach ($pageStyles as $style): ?>
            <link href="<?= defined('URL_BASE') ? URL_BASE : '' ?>/<?= $style ?>" rel="stylesheet">
        <?php endforeach; ?>
    <?php endif; ?>
</head>

<!-- Verifica via Auth se está logado para definir a classe do body -->

<body class="bg-gray-50 text-gray-800 antialiased">

    <?php if (Auth::isLogged()): ?>

        <!-- Navbar Superior (Se existir o arquivo) -->
        <?php
        $profiss = $_SESSION['user']['id_profissional'] ?? Null;
        // echo $profiss . ' - ' . $_SESSION['user']['name'] . ' - ' . $_SESSION['user']['level'];

        $navbarPath = __DIR__ . '/partials/navbar.phtml';
        if (file_exists($navbarPath)) {
            require $navbarPath;
        }

        $headerPath = __DIR__ . '/partials/header.phtml';
        if (file_exists($headerPath)) {
            require $headerPath;
        }
        ?>

        <!-- Wrapper Flexbox para Sidebar e Conteúdo -->
        <div class="d-flex" id="wrapper">

            <!-- Sidebar -->
            <?php require __DIR__ . '/partials/sidebar.phtml'; ?>

            <!-- Área Principal de Conteúdo -->
            <!-- <main id="iniciativas" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 -mt-16 relative z-20"> -->

            <!-- Container fluido para padding interno -->
            <div class="container-fluid p-3">

                <!-- Botão Toggle Mobile (caso a sidebar suma em telas pequenas) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3 mb-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Conteúdo da View -->
                <?= $content ?>
            </div>

            <!-- </main> -->
        </div>

    <?php else: ?>

        <?php
        // Definir quais partials carregar baseado na view atual usando SWITCH
        $navbarPartial = null;
        $headerPartial = null;
        $footerPartial = null;

        if (isset($view)) {
            // Nota: Os "cases" abaixo devem ser exatamente os nomes que você passa 
            // no seu Controller em $data['view'] = 'nome_da_view';
            switch ($view) {
                case 'home':
                    $navbarPartial = 'navbar_home.phtml';
                    $headerPartial = 'header_home.phtml';
                    $footerPartial = 'footer_home.phtml';
                    break;
                case 'comunidade':
                    $navbarPartial = 'navbar_comunidade.phtml';
                    $headerPartial = 'header_comunidade.phtml';
                    $footerPartial = 'footer_comunidade.phtml';
                    break;
                case 'psi_empreendedor':
                    $navbarPartial = 'navbar_psi.phtml';
                    $headerPartial = 'header_psi.phtml';
                    $footerPartial = 'footer_psi.phtml';
                    break;
                case 'regulacao_emocional':
                    $navbarPartial = 'navbar_regulacao.phtml';
                    $headerPartial = 'header_regulacao.phtml';
                    $footerPartial = 'footer_regulacao.phtml';
                    break;
                case 'te_experience':
                    $navbarPartial = 'navbar_te.phtml';
                    $headerPartial = 'header_te.phtml';
                    $footerPartial = 'footer_te.phtml';
                    break;
                case 'papo_familia':
                    $navbarPartial = 'navbar_familia.phtml';
                    $headerPartial = 'header_familia.phtml';
                    $footerPartial = 'footer_familia.phtml';
                    break;
                case 'login':
                    // A página de login normalmente não possui a navbar/footer das landing pages
                    $navbarPartial = null;
                    $headerPartial = null;
                    $footerPartial = null;
                    break;
            }
        }
        ?>

        <?php
        // Injeta a Navbar específica se ela foi definida no switch
        if ($navbarPartial) {
            include __DIR__ . '/partials/' . $navbarPartial;
        }
        ?>

        <?php
        // Injeta o Header específico se ele foi definido no switch
        if ($headerPartial) {
            include __DIR__ . '/partials/' . $headerPartial;
        }
        ?>

        <!-- Conteúdo Público / Login / Landing Pages -->
        <?= $content ?>

        <?php
        // Injeta o Footer específico se ele foi definido no switch
        if ($footerPartial) {
            include __DIR__ . '/partials/' . $footerPartial;
        }
        ?>

    <?php endif; ?>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script para Toggle do Sidebar (Importante para Mobile) -->
    <script>
        (function($) {
            "use strict";
            // Alternar sidebar
            $("#sidebarToggle, #sidebarToggleTop").on('click', function(e) {
                $("body").toggleClass("sidebar-toggled");
                $(".sidebar").toggleClass("toggled");
                if ($(".sidebar").hasClass("toggled")) {
                    $('.sidebar .collapse').collapse('hide');
                };
            });
        })(jQuery);
    </script>

    <?php if (isset($pageScripts) && is_array($pageScripts)): ?>
        <?php foreach ($pageScripts as $script): ?>
            <script src="<?= defined('URL_BASE') ? URL_BASE : '' ?>/<?= $script ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Inicializar ícones -->
    <script>
        lucide.createIcons();
    </script>
</body>

</html>