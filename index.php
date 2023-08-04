<?php

get_header();

?>
	<main id="content">
		<?php if (have_posts()) { ?>
			<?php get_template_part('templates/parts/content', get_post_type()); ?>
		<?php } else { ?>
			<?php get_template_part('templates/parts/content', 'none'); ?>
		<?php } ?>
	</main><!-- #main -->
<?php
get_footer();