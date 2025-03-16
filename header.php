<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Oil & Gas Company</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <style>
    

        .swiper-slide video {
            @apply object-cover w-full h-96;
        }

        .swiper-slide:hover video {
            @apply cursor-pointer;
        }

        .swiper-button-next,
        .swiper-button-prev {
            @apply text-white;
        }

        @media (max-width: 768px) {
            .swiper-slide {
                @apply h-64;
            }
        }
    </style>
</head>

<body <?php body_class(); ?> class="bg-gray-100 text-gray-800">

<header class="bg-blue-600 p-4">
    <div class="container mx-auto flex justify-between items-center relative">
        <a href="<?php echo home_url(); ?>" class="text-white text-lg font-bold">Oil & Gas Company</a>

        <!-- Hamburger Button -->
        <button id="menu-toggle" class="block md:hidden p-2 text-white focus:outline-none">
            ☰
        </button>

        <!-- Navigation Menu -->
        <nav id="mobile-menu" class="fixed inset-x-0 bg-blue-600 z-50 p-16 md:p-4 transform -translate-y-full opacity-0 transition-all duration-300 md:relative md:translate-y-0 md:opacity-100 md:flex md:flex-row md:space-x-4">
        <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'menu_class' => 'flex flex-col md:flex-row md:space-x-4',
                'container' => false,
                'walker' => new Tailwind_Walker_Nav_Menu(),
            ]);
            ?>
        </nav>
    </div>
</header>

        
    
    <?php if(!is_front_page()) custom_breadcrumbs(); ?>