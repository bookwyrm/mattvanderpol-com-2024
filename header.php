<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php wp_head(); ?>
    <script>
    // Navigation toggle
    window.addEventListener('load', function () {
          let main_navigation = document.querySelector('#primary-menu');
          document.querySelector('#primary-menu-toggle').addEventListener('click', function (e) {
                e.preventDefault();
            main_navigation.classList.toggle('max-lg:hidden');
          });
    });
    </script>
</head>

<body <?php body_class( 'font-sans font-light bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 text-base leading-snug antialiased' ); ?>>

<?php do_action( 'mattvanderpol_com_2024_site_before' ); ?>

<div id="page" class="min-h-screen flex flex-col">

<?php do_action( 'mattvanderpol_com_2024_header' ); ?>

    <?php
use TailCraft\Theme\Customizer;
use TailCraft\Theme\Util\ClassList;

$customizer = new Customizer();
$show_title = $customizer->showTitleAndTagline();
$title = \get_bloginfo('name');
$description = \get_bloginfo('description', 'display');
$title_classes = new ClassList('font-bold text-3xl md:text-6xl')
?>
<header 
    class="header z-40 w-full flex group border-b-4 border-slate-700 pb-6 relative"
>
    <div class="page-wrapper w-full flex justify-center pt-4">
        <div class="flex lg:justify-between lg:items-center w-full">
            <div class="flex justify-between items-center w-full lg:w-auto gap-10">
                <!-- Logo -->
                <div class="flex gap-5">
                    <div class="flex flex-col justify-center rounded-xl shadow-gray-600 shadow-lg hover:scale-105 hover:-rotate-1 transition-transform">
                        <?php get_template_part('template-parts/header/logo'); ?>
                    </div>
                </div>

                <!-- Mobile nav trigger -->
                <div class="lg:hidden">
                    <a href="#" aria-label="Toggle navigation" id="primary-menu-toggle">
                        <svg viewBox="0 0 20 20" class="inline-block w-6 h-6" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g stroke="none" stroke-width="1" fill="currentColor" fill-rule="evenodd">
                                <g id="icon-shape">
                                    <path d="M0,3 L20,3 L20,5 L0,5 L0,3 Z M0,9 L20,9 L20,11 L0,11 L0,9 Z M0,15 L20,15 L20,17 L0,17 L0,15 Z"
                                    id="Combined-Shape"></path>
                                </g>
                            </g>
                        </svg>
                    </a>
                </div>
            </div>

            <div 
                id="primary-menu" 
                class="max-lg:hidden absolute lg:static top-full inset-x-0 flex max-lg:flex-col lg:h-full bg-primary lg:mt-0 lg:p-0 lg:bg-transparent max-lg:p-4 items-center"
            >
                <?php
                wp_nav_menu(
                    array(
                        'container_id'    => '',
                        'container_class' => '',
                        'menu_class'      => '',
                        'menu_id'         => '',
                        'theme_location'  => 'primary',
                        'a_class'         => '',
                        'fallback_cb'     => false,
                    )
                );
                ?>
            </div>
        </div>
    </div>
</header>

<div id="content" class="site-content">


<?php do_action( 'mattvanderpol_com_2024_content_start' ); ?>

<main>
