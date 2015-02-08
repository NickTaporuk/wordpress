		<!-- Sidebar -->
		<div class="sidebar sidebar-right">
		
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(2) ) : ?>
				<h3>Рубрики</h3>
			<ul>
				<?php wp_list_categories('title_li='); ?>	
	    </ul>
	    
			<?php endif; ?>
			
		

			</ul>

			
			<h3>Ссылки</h3>
			<ul>
			</ul>
					
		</div>
		<!-- Sidebar -->
		
		<div class="clear"></div>
	
	</div></div></div>
	<!-- /Main -->

	
	<!-- Footer -->
	<div id="footer">
	
		<!-- Copyright -->
		<div id="copyright">
			<br>
Все права защищены &copy; <?php the_time('Y'); ?> <a href="/"><strong><?php bloginfo('name'); ?></strong></a>. <?php bloginfo('description'); ?>
<a href="http://tablethelp.ru/model-3q_qoo_surf_tablet_pc_tu1102t_1gb_ddr2_32gb_ssd">Выбор планшетов для сравнения</a>
</div>

		<!-- /Copyright -->
	
	</div>
	<!-- Footer -->

</div>
<!-- /Page -->


<?php wp_footer(); ?>
</body>

</html>