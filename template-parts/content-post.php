<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <header>
        <h1><?php the_title(); ?></h1>
    </header>
	<div class="entry-content prose prose-2xl dark:prose-invert max-w-none">
		<?php the_content(); ?>
	</div>

</article>
