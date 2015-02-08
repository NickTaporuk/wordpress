<?php get_header(); ?>
<?php get_sidebar(); ?>
		
		<!-- Content -->
		<div id="content">
		
			<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
			<!-- Post -->
			<div class="post" id="post-<?php the_ID(); ?>">
				<div class="post-title">
					<div class="post-date">
						<span><?php the_time('d') ?></span>
						<?php the_time('M') ?>
					</div>
					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
					Автор: <?php the_author() ?>
				</div>
				<div class="post-entry">
					<?php the_content('Читать <span>далее...</span>'); ?>
					<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
					<?php edit_post_link('Править', '<p>', '</p>'); ?>
				</div>
			</div>
			<!-- /Post -->
			<?php endwhile; ?>
			<?php else : ?>
			<!-- Post -->
			<div class="post">
				<div class="post-title">
					<h2>Не найдено</h2>
				</div>
				<div class="post-entry">
					<p>К сожалению, по вашему запросу ничего не найдено.</p>
				</div>
			</div>
			<!-- /Post -->
			<?php endif; ?>
			
			<div class="clear"></div>
		
		</div>
		<!-- /Content -->
		
<?php get_footer(); ?>