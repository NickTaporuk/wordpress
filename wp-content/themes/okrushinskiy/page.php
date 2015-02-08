<?php get_header();?>
<div class="content" style="float: right;width: 75%;">
    <div class="main-heading">
        <h1><?php the_title(); ?></h1>
    </div>
    <section>
        <?php if (have_posts()): while (have_posts()): the_post(); ?>
            <?php the_content(); ?>
        <?php endwhile; endif; ?>
    </section>
</div>
<?php get_sidebar(); ?>

<?php get_footer(); ?>