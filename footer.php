
</main>

<?php do_action( 'mattvanderpol_com_2024_content_end' ); ?>

</div>

<?php do_action( 'mattvanderpol_com_2024_content_after' ); ?>

<footer id="colophon" class="site-footer border-t border-subtle bg-white dark:bg-black mt-12" role="contentinfo">
	<?php get_template_part('template-parts/footer/footer-widgets'); ?>

	<?php do_action( 'mattvanderpol_com_2024_footer' ); ?>

    <div class="border-t border-subtle">
        <div class="page-wrapper w-full flex justify-between py-7 items-center">
            <span class="text-xs"><?php $customizer = new TailCraft\Theme\Customizer(); echo $customizer->copyright(); ?></span>
            <div class="flex space-x-3">
            </div>
        </div>
    </div>
</footer>

</div>

<?php wp_footer(); ?>

</body>
</html>
