<?php
$custom_logo_id = \get_theme_mod('custom_logo');
$title = \get_bloginfo('name');
?>
<?php if ( $custom_logo_id ) : ?>
    <?php 
        $logo_img_attr = [
            'class' => 'h-32 w-auto rounded-xl border-2 border-gray-200',
        ];
        $logo_image = wp_get_attachment_image($custom_logo_id, 'full', false, $logo_img_attr);
    ?>
    <div class="flex lg:flex-1">
        <a 
            href="<?php echo esc_url( home_url('/') ); ?>"
            class="-m-1.5 p-1.5"
            rel="home"
        >
            <?php echo $logo_image; ?>
        </a>
    </div>
<?php endif; ?>


