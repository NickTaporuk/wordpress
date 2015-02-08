		<!-- Sidebar -->
		<div class="sidebar">
		
			<h3>Страницы</h3>
			<ul>
				<?php wp_list_pages('title_li='); ?>
			</ul>
			
			<h3>Архивы</h3>
			<ul>
				<?php wp_get_archives('type=monthly'); ?>
			</ul>
			
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(1) ) : ?>
			
			<?php endif; ?>
		
		</div>
		<!-- Sidebar -->