<?php
/*
Template name: Full Width
*/
get_header(); ?>

<div class="clear"></div>

<div class="container-fluid">
	<div class="row">
		<div class="content col-md-12">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<article <?php post_class(); ?>>
					<?php the_content(); ?>
				</article>
			<?php endwhile; ?>			
			<?php else: ?>
				<?php get_404_template(); ?>
			<?php endif; ?>
		</div><!--Content-->
	</div>
</div><!--Container-->

<?php get_footer(); ?>