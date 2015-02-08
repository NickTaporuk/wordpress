<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Пожалуйста, не загружайте эту страницу напрямую. Спасибо!');

	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
			?>

			<p class="nocomments">Эта публикация защищена паролем. Пожалуйста, введите его для просмотра комментариев.</p>

			<?php
			return;
		}
	}

	/* This variable is for alternating comment background */
	$oddcomment = 'class="alt" ';
?>

<!-- You can start editing here. -->

<?php if ($comments) : ?>


				<h3 id="comments"><?php comments_number('Отзывов нет', 'Один отзыв', 'Отзывов: %' );?> на &#8220;<?php the_title(); ?>&#8221;</h3>
				<div class="comments">
					<ol class="comments_list">
					<?php foreach ($comments as $comment) : ?>
					
						<li <?php echo $oddcomment; ?>id="comment-<?php comment_ID() ?>">
							<cite><?php comment_author_link() ?></cite> пишет:
								<?php if ($comment->comment_approved == '0') : ?>
								<em>Спасибо! Ваш комментарий ожидает проверки.</em>
								<?php endif; ?>
								<br />
							<small class="commentmetadata"><a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date('d.m.Y') ?> в <?php comment_time() ?></a> <?php edit_comment_link('править','&nbsp;&nbsp;',''); ?></small>
							<?php comment_text() ?>
						</li>
						<?php
							/* Changes every other comment to a different class */
							$oddcomment = ( empty( $oddcomment ) ) ? 'class="alt" ' : '';
						?>
					<?php endforeach; /* end for each comment */ ?>
					</ol>
</div>			
				
				 <?php else : // this is displayed if there are no comments so far ?>

				 	<?php if ('open' == $post->comment_status) : ?>
					 	<!-- If comments are open, but there are no comments. -->
				 
				 	 <?php else : // comments are closed ?>
					 	<!-- If comments are closed. -->
					 	<p class="nocomments">Комментарии закрыты.</p>
				 
				 	<?php endif; ?>
				 <?php endif; ?>
				
				<?php if ('open' == $post->comment_status) : ?>

				
				<h3 id="respond">Оставьте свой отзыв</h3>
				
<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<div class="navigation-next">Вы должны <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">войти</a>, чтобы оставлять комментарии.</div>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

<div class="navigation-next">Вы вошли как <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Выйти с этого аккаунта">Выйти &raquo;</a></div>
	
<?php else : ?>

<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
<label for="author"><b>Имя</b> <?php if ($req) echo "*"; ?></label></p>

<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
<label for="email"><b>Почта</b> (скрыта) <?php if ($req) echo "*"; ?></label></p>

<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
<label for="url"><b>Сайт</b></label></p>

<?php endif; ?>


<p><textarea name="comment" id="comment" cols="50" rows="10" tabindex="4"></textarea></p>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="Добавить отзыв" />
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
</p>
<?php do_action('comment_form', $post->ID); ?>

</form>

<?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>