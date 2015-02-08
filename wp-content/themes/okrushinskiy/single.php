<?php get_header(); ?>
<?php get_sidebar(); ?>
    <ul class="breatcrubs">
<!--        --><?php //the_breadcrumb()?>
    </ul>
    <!-- Content -->
    <div id="content">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <div class="post" id="post-<?php the_ID(); ?>">
                    <div class="post-title">
                        <div class="post-date">
                            <span><?php the_time('d') ?></span>
                            <?php the_time('M') ?>
                        </div>
                        <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                        Автор: <?php the_author() ?> &nbsp;// &nbsp;Рубрика: <?php the_category(', ') ?>
                    </div>
                    <div class="post-entry">
                        <?php the_content('Читать далее...'); ?>
                        <?php wp_link_pages(array('before' => '<p><strong>Страницы:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
                        <?php the_tags( '<p>Теги: ', ', ', '</p>'); ?>
                        <?php edit_post_link('Править','',''); ?>
                    </div>
                    <?php comments_template(); ?>
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