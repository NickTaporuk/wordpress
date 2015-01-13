<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 13.01.15
 * Time: 22:19
 */
?>
<?php get_header(); ?>
    <div class="main-heading">
        <h1><?php the_title(); ?></h1>
    </div>
    <section>
        <?php if (have_posts()): while (have_posts()): the_post(); ?>
            <?php the_content(); ?>
        <?php endwhile; endif; ?>
    </section>
<?php get_footer(); ?>