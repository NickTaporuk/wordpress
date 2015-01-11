<?php
/**
 * @package WordPress
 * @subpackage Chocolate
 */
?>

<?php if(!is_page_template('home-static.php')) : ?>
	</div>
<?php endif; ?>

</div>

<?php
if (!defined('GAL_HOME') || is_page_template('home-3d.php') )
   get_template_part( 'bottom' );
?>

<?php get_template_part('demo');  ?>
<?php wp_footer(); ?>
</body>
</html>
