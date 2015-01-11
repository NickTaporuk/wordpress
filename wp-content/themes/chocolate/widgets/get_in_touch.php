<?php

	function widget_sakura_Feedback($args) {

		// "$args is an array of strings that help widgets to conform to
		// the active theme: before_widget, before_title, after_widget,
		// and after_title are the array keys." - These are set up by the theme
		extract($args);

		// These are our own options
		$options = get_option('widget_sakura_Feedback');
		$curtag = $options['curtag'];  // Your Twitter account name
		$title = $options['title'];  // Title in sidebar for widget
		$text = $options['text'];  // # of Updates to show
		$en_captcha = (isset($options['en_captcha']) && $options['en_captcha'])?true:false;
		//$upd = $options['upd'];  // # of Updates to show

        // Output
		echo $before_widget ;
		
		echo ''
              .$before_title.$title.$after_title;

		// start
              
       	$captcha_id = 'widget_' . dt_generate_contact_id(); 
      ?>
      
        <!-- <p><?php echo $text; ?></p>  -->
      <form class="uniform get_in_touch ajax ajaxing" method="post"> 

            <?php wp_nonce_field('dt_contact_' . $captcha_id,'dt_contact_form_nonce'); ?>
            <input type="hidden" name="send_message" value="" />
            <input type="hidden" name="send_contacts" value="<?php echo $captcha_id; ?>" />
		
			<div class="i_h"><div class="l"><input id="your_name" name="f_name" type="text" placeholder="Ваше имя" value="" class="validate[required]" /></div></div> 
        	<div class="i_h"><div class="r"><input id="email" name="f_email" type="text" placeholder="E-mail" value="" class="validate[required,custom[email]" /></div></div> 
        	<div class="t_h"><textarea id="message" name="f_comment" placeholder="Сообщение" class="validate[required]"></textarea></div> 
		
            <?php do_action('dt_contact_form_captcha_place', array( 'whoami' => $captcha_id, 'enable' => $en_captcha ) ); ?>

			<a href="#" class="go_submit go_button" title="Submit"><span><i></i><?php echo __("Отправить", LANGUAGE_ZONE); ?></span></a> 
        	<a href="#" class="do_clear">Очистить</a> 
      </form> 

            
      <?php

		// echo widget closing tag
		echo $after_widget;
	}

	// Settings form
	function widget_sakura_Feedback_control() {

		// Get options
		$options = get_option('widget_sakura_Feedback');
		// options exist? if not set defaults
		if ( !is_array($options) )
			$options = array('curtag'=>'', 'title'=>'Get in touch!', 'text' => '');

        // form posted?
		if ( isset($_POST['sakura_Twitter70-submit']) && $_POST['sakura_Twitter70-submit'] ) {

			// Remember to sanitize and format use input appropriately.
			$options['title'] = strip_tags(stripslashes($_POST['sakura_Twitter40-title']));
			$options['text'] = strip_tags(stripslashes($_POST['sakura_Twitter40-show']));
			$options['en_captcha'] = isset($_POST['sakura_Twitter40-en_captcha']);
			update_option('widget_sakura_Feedback', $options);
		}

		// Get options for form fields to show
		$title = htmlspecialchars($options['title'], ENT_QUOTES);
		$text = htmlspecialchars($options['text'], ENT_QUOTES);
		$en_captcha = (isset($options['en_captcha']) && $options['en_captcha'])?true:false;

		// The form fields
		echo '<p>
				<label for="Twitter-title">' . __('Title:') . '<br />
				<input style="width: 100px;" id="Twitter-title" name="sakura_Twitter40-title" type="text" value="'.$title.'" />
				</label></p>';
?>
			 <p>
			 <label><?php _e('Enable captcha: ', LANGUAGE_ZONE); ?><input type="checkbox" name="sakura_Twitter40-en_captcha"<?php checked($en_captcha, true); ?> /></label>
			</p>		
<?php
		if (0) echo '<p>
				<label for="Twitter-show">' . __('Text:') . '<br />
				<textarea style="width: 200px;" id="Twitter-show" name="sakura_Twitter40-show" rows="7">'.$text.'</textarea>
				</label></p>';
		echo '<input type="hidden" id="sakura_Twitter0-submit" name="sakura_Twitter70-submit" value="1" />';
	}


   wp_register_sidebar_widget(9003, (THEME_TITLE.' Feedback'), 'widget_sakura_Feedback');
   wp_register_widget_control(9003, THEME_TITLE.' Feedback', "widget_sakura_Feedback_control");
   
?>
