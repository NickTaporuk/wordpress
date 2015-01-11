<?php

/**
 * Данная обработка позволяет загрузить демо данные с сайта morestyle.ru
 */

$themename=basename(dirname(__FILE__));

@ini_set("memory_limit", "100M");
@ini_set('default_charset','utf-8'); 

$option_quest=$themename.'_quest';
$demo_morestyle_file=dirname(__FILE__)."/_demo_morestyle_data.sql";
if (@filesize($demo_morestyle_file) < 50) return ; // если нет файл демо данных, то вообще ничего не выполняем

$_SERVER['HTTP_HOST']=preg_replace("#(.*?):[0-9]+#is", "\\1", $_SERVER['HTTP_HOST']);

// больше не показывать вопрос 
if (isset($_REQUEST['no_quest']) && $_REQUEST['no_quest']) {
	update_option($option_quest, "2050-01-01");
}

#if ($_GET['test2'])	convert_baseurl_options($themename);

// сбросить вопрос
if (isset($_REQUEST['clear_quest']) && $_REQUEST['clear_quest']) update_option($option_quest, "");

// вызываем вопрос установки демо данных
if ((!get_option($option_quest) && $table_prefix!=$themename."__" && !isset($_REQUEST['no_quest'])) || isset($_REQUEST['go_quest']) && $_REQUEST['go_quest']) {
	$exist=check_exists_table();
	if ($exist) {
		update_option($option_quest, "2050-01-03");
		return;
	}

	// установить SQL демо данные
	if ($_REQUEST['install_sql']) {
		$ok=get_sql(); 
	}
	out_quest();
}

/**
 * Исполнение SQL запросов (разбираем sql дамп)
 *
 */
function get_sql() {
	global $wpdb, $themename, $option_quest, $demo_morestyle_file;
	$sql_dump=file_get_contents($demo_morestyle_file);
	
	tpl_head();
	echo "<h2>Процесс установки демо данных</h2><br><br>\n";
	$tab_blocks=preg_split("#/\*.{0,300}?[a-z0-9]\_\_[a-z0-9]+.{0,300}?\*/#is", $sql_dump);
	unset($sql_dump); // осв. память
	echo "<u>Восстанавливаем mysql таблицы</u>:\n";
	$error=false;
	foreach ($tab_blocks as $i => $sql) {
		if (!$sql) continue;
		if (preg_match("#(CREATE TABLE|INSERT INTO).*?([a-z0-9\_]+\_\_[a-z0-9\_]+)#is", $sql, $b)) {
			$action_table=$b[1];
			$table_name=$b[2];
		}
		$ok=$wpdb->query($sql);
		$count=$wpdb->get_var("SELECT COUNT(*) FROM $table_name");
		if (preg_match("#INSERT#is", $action_table) && $count==0) {
			$ok=false;
			echo "<li style='color:red'><b>ERROR: после insert не достаточно записей ($count шт)</b>: <br>SQL:<br> <textarea style='width: 300px; height:100px'>".htmlspecialchars($sql)."</textarea></li>";
		}
		if ($table_name) {
			if (preg_match("#INSERT#is", $action_table)) print "<li><b>$action_table <i style='color:#3f6eba'>$table_name</i></b>: ".($ok ? "<font color=green>OK <small>(записей: $count)</small></font>" : "<font color=red>ERROR ".print_r($wpdb->error,1)."</font>")."</li>\n";
			if (!$ok) $error=1;
		} 
	}
	if (!$error) {
		// прописываем локализацию темы под текущий домен
		$wpdb->query("UPDATE {$themename}__options SET option_value='http://{$_SERVER['HTTP_HOST']}' WHERE option_name='siteurl' OR option_name='home'");
		$wpdb->query("UPDATE {$themename}__options SET option_value=REPLACE(option_value, '/var/www/wordpress/data/www/wordpress.server-7.ru/', '".ABSPATH."') WHERE option_value like '/var/www/wordpress/data/www/wordpress.server-7.ru/%'");
		$wpdb->query("UPDATE {$themename}__options SET option_value=1 WHERE option_name='blog_public'");
		
		// преобразуем различные настройки тем (хранящ. в серилиз. массивах) в текущие
		convert_baseurl_options($themename);
		
		echo "<br><font color=green><b>Таблицы успешно восстановлены</b></font><br><br>
		<big>Теперь, чтобы увидеть демо сайт, нужно заменить в <b>wp-config.php</b> переменную на:<br>
		<font color=red>\$table_prefix</font> = <font color=blue>'{$themename}__'</font>;</big> <br>
		<br>
		<u>Доступ в новую админку</u>:<br>
		<font color=red>admin / admin</font><br>
		
		<br><img src='http://www.iconsearch.ru/uploads/icons/function_icon_set/16x16/warning_16.png'> <font color=blue>Возможно, для работы темы потребуются дополнительные плагины. Смотрите подробнее в документации темы или в папке /plugins самой темы.</font><br>
		
		<br><input type='button' onclick=\"window.location.href='/'; return false;\" value='OK, я исправил wp-config.php' class='button action'>
	
		<br><br><font color=gray>p.s. в целях безопасности текущий файл установщик <i>install-theme-ms.php</i> можно удалить из папки темы.</font>
		<span style='display:none' id='process_loading'><img src='http://wordpress.server-7.ru/d/img/$themename/2/process_loading.gif'><br><br></span>
		";
		update_option($option_quest, "2050-01-02");
	} else {
		echo "<br><br><font color=red><b>Произошла ошибка во время установки таблиц</b></font>.<br>Возможно они уже существуют";
	}
	tpl_bottom();
	exit();
}

/**
 * Проверяет существование таблицы из дампа
 *
 */
function check_exists_table() {
	global $demo_morestyle_file, $wpdb;
	$sql_dump=file_get_contents($demo_morestyle_file);
	if (preg_match("#CREATE TABLE.*?`(.*?)`#is", $sql_dump, $b)) $table_name=$b[1]; 
	if (!$table_name) return ;
	//echo "проверяем есть ли таблица $table_name: "; 
	$r = $wpdb->query("SELECT 1 FROM `{$table_name}` WHERE 1");
	if ($r) return 1;
}

/**
 * Преобразуем пути настроек тем на локальные 
 *
 */
function convert_baseurl_options($themename, $basesite="", $basedir="") {
	global $wpdb;
	if (!$basesite) $basesite="http://".$_SERVER['HTTP_HOST'];
	if (!$basedir) $basedir=ABSPATH;
	$table_prefix=$themename."__"; 
	
	$regexp='(http:[^\"]+.(morestyle.ru|server-7.ru)[^\"]+\.(jpg|png|gif|jpeg|ico|bmp|css))';
	
	// замены путей в постах и метаданных
	echo "<br><br><u>Делаем замены в путях и метаданных демо шаблона</u>:<br>\n";
	$arr=$wpdb->get_results("SELECT id, guid, post_content  FROM `{$themename}__posts` WHERE guid REGEXP '$regexp' OR post_content REGEXP '$regexp'");
	$subdir=$themename."_demo_img"; // субдиректория с картинками
	if (!empty($arr)) {
		foreach ($arr as $i => &$v) {
			$guid=$v->guid;
			// обновляем основной файл изображения
			if (preg_match("#\.(jpg|png|ico|gif|jpeg|bmp|css)$#is", $v->guid)) {
				$v->guid=get_imgdata($v->guid, "", $subdir);
			} else $v->guid=preg_replace("#http://[^/]+#is", "", $v->guid);

			// исправляем URL картинок в теле самого поста
			$v->post_content=replaces_string($regexp, $v->post_content, array("subdir" => $subdir));
						
			// обновляем файл meta данных (дописываем нужны sub url)
			if ($subdir) {
				$wpdb->query("UPDATE `{$themename}__postmeta` SET meta_value=CONCAT('$subdir/', meta_value) WHERE post_id='{$v->id}' AND meta_key='_wp_attached_file'");
				$arr_meta=$wpdb->get_results("SELECT * FROM `{$themename}__postmeta` a WHERE meta_key='_wp_attachment_metadata' AND post_id='{$v->id}' LIMIT 1");
				$meta=unserialize($arr_meta[0]->meta_value);
				$meta['file']=$subdir."/".$meta['file'];
				$wpdb->query("UPDATE `{$themename}__postmeta` SET meta_value='".mysql_escape_string(serialize($meta))."' WHERE meta_id='{$arr_meta[0]->meta_id}'");
			}
			$wpdb->query("UPDATE `{$themename}__posts` SET post_content='".mysql_escape_string($v->post_content)."', guid='".mysql_escape_string($v->guid)."' WHERE id='{$v->id}'");
		}
	} 
	echo "<font color=green>сделано</font><br>";
		
	// заменяем картинки в метаданных
	$arr=$wpdb->get_results("SELECT * FROM `{$themename}__postmeta` WHERE meta_value REGEXP '$regexp'");
	if (!empty($arr)) {
		foreach ($arr as $i => $res) {
			if (preg_match("#^a:[0-9]#is", $res->meta_value)) {
				$p=unserialize($res->meta_value);
				if (!is_array($p)) continue;
				$json=json_encode($p);
				$json=replaces_string($regexp, $json, array("subdir" => $subdir));
				$res->meta_value=serialize(json_decode($json, 1));
			} else {
				$res->meta_value=replaces_string($regexp, $res->meta_value, array("subdir" => $subdir));
			}
			$ok=$wpdb->query("UPDATE {$themename}__postmeta SET meta_value='".mysql_escape_string($res->meta_value)."' WHERE meta_id={$res->meta_id}");
		}
	}	
	
	// замены в массивах настроек тем
	$arr=$wpdb->get_results("SELECT *  FROM `{$themename}__options` WHERE `option_value` REGEXP '$regexp'");
	if (!empty($arr)) {
		foreach ($arr as $i => $res) {
			if (preg_match("#^a:[0-9]#is", $res->option_value)) {
				$p=unserialize($res->option_value);
				if (!is_array($p)) continue;
				$json=json_encode($p);
				$json=replaces_string($regexp, $json, array("subdir" => $subdir));
				$p=json_decode($json, 1);
				$res->option_value=serialize($p);
			} else {
				$res->option_value=replaces_string($regexp, $res->option_value, array("subdir" => $subdir));
			}
			$ok=$wpdb->query("UPDATE {$themename}__options SET option_value='".mysql_escape_string($res->option_value)."' WHERE option_id={$res->option_id}");
		}
	}
	echo "<br><br><u>Обновляем все миниатюры</u>:<br>";

	// обновление миниатюр во всех темах
	updates_meta_thumbs($themename);
	echo "<font color=green>сделано</font><br>";
	
	if ($_GET['debug']) die("EXIT");
}

/**
 * Замены путей
 *
 * @param unknown_type $regexp
 * @param unknown_type $to
 */
function replaces_string($regexp, $str, $param=array()) {
	if (!isset($param['subdir'])) $param['subdir']="";
	if (preg_match_all("#$regexp#is", $str, $all)) {
		foreach ($all[1] as $i => $block) {
			$replace[$block]=get_imgdata($block, "", $param['subdir']);
		}
		$str=str_replace(array_keys($replace), array_values($replace), $str);
	}
	return $str;
}


/**
 * Совместно с preg_replace вытаскиваем данные картинок с исходных серверов
 * Нужно для того, чтобы картинки из настроек темы сохранить в uploads
 *
 */
function get_imgdata($img="http://server.../img.png", $baseurl="", $subdir="") {
	if (!$baseurl) $baseurl="http://".$_SERVER['HTTP_HOST']."/";
	$img_real=str_replace("\\/", "/", $img);
	
	if (!preg_match("#/(wp-content/.*)$#is", $img_real, $path)) {
		out_error("$img не входит по маске<br>\n");
		return $img;
	}
		
	$file=rtrim(ABSPATH, "/")."/".ltrim($path[1], "/");
	$file=preg_replace("#/wp-content/uploads#is", "\\0".($subdir ? "/$subdir" : ""), $file);
	
	if (!file_exists($file)) {
		$str=@file_get_contents($img_real);
		if (!$str || !$path[1]) {
			out_error("$img уже существует<br>\n");
			return $img;
		}
		$dir=dirname($file);
		$ok=@mkdir($dir, 0777, true);
		if (!@file_put_contents($file, $str)) out_error("$img невозможно записать $file<br>\n"); 
	}
	$result=rtrim($baseurl, "/ ")."/".ltrim($path[1],"/");
	$result=preg_replace("#/wp-content/uploads#is", "\\0".($subdir ? "/$subdir" : ""), $result);
	$result=preg_replace("#http://[^\/]+/#is", "http://{$_SERVER['HTTP_HOST']}/", $result);
	
	//out_info("<b>img</b>: $img | <b>img_real:</b> $img_real | <b>\$result:</b> $result<br>\n\$file=$file");
	return $result;
}

function out_error($str) {
	if (!$_GET['debug']) return ;
	echo "<font color=red><img src='http://www.iconsearch.ru/uploads/icons/snowish/16x16/dialog-warning.png'> $str</font><br>\n";
}

function out_info($str) {
	if (!$_GET['debug']) return ;
	echo "<font color=#b53f05><img src='http://www.iconsearch.ru/uploads/icons/sweetiev3/16x16/16-message-info.png'> $str</font><br>\n";
}


/**
 * Обновить все миниатюры демо 
 *
 */
function updates_meta_thumbs($themename) {
	global $wpdb, $table_prefix;
	$wpdb->postmeta="{$themename}__postmeta";
	$wpdb->posts="{$themename}__posts";
	
	if (!function_exists("wp_generate_attachment_metadata")) require_once(ABSPATH."wp-admin/includes/image.php");
	@set_time_limit( 900 );
	$arr=$wpdb->get_results("SELECT id, guid FROM `{$themename}__posts` WHERE post_type = 'attachment' AND post_mime_type LIKE 'image/%' ORDER BY ID DESC");
	if (empty($arr)) return;
	foreach ($arr as $i => $res) {
		$image = get_post($res->id);
		//print "UPDATE THUMB: $res->id (img: $image->ID) fe: ".function_exists("wp_generate_attachment_metadata").";\n\n";
		$fullsizepath = get_attached_file( $image->ID );
		$metadata = wp_generate_attachment_metadata( $image->ID, $fullsizepath);
		wp_update_attachment_metadata( $image->ID, $metadata );
	}  
}

/**
 * Выводим вопрос
 *
 */
function out_quest() {
	global $themename;
	tpl_head();
	echo "<h2>Хотите установить <a href='http://$themename.theme.morestyle.ru/' target='_blank'>демо данные morestyle</a> для <font color=blue>$themename</font>?</h2><br><br>\n";
	
	echo "Чтобы быстрее разобраться с настройками темы, предлагаем вам установить <a href='http://$themename.theme.morestyle.ru/' target='_blank'>нашу демо версию</a> базы данных.<br><br>
	Демо данные будут установлены в другую группу mysql таблиц с префиксом <b>{$themename}__</b>
	<br>Следовательно, ваши текущие таблицы не будут затронуты.<br><br>
	Сразу после установки (не сейчас!), чтобы отображались демо данные morestyle, нужно в <b>wp-config.php</b> прописать :<br>
	<font color=red>\$table_prefix</font> = <font color=blue>'{$themename}__'</font>; <br>
<br><br>
	<input type=hidden name='install_sql' value=1>

	<span style='display:none' id='process_loading'><img src='http://wordpress.server-7.ru/d/img/$themename/1/process_loading.gif'><br><br></span>
	<input type='button' name='install_sql' id='install_sql' value='Установить' class='button action' onclick=\"$(this).attr('disabled', true); $('#process_loading').show(); $('#loginform').submit();\">
	<input type='submit' name='no_quest' value='Больше не задавать этот вопрос' class='button action'>
	";
	$table_prefix = '_manager_freelance__'; 
	tpl_bottom();
	exit();
}

function tpl_head() {
?><!DOCTYPE html>
	<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="ru-RU">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Хотите установить демо данные шаблона?</title>
	<link rel='stylesheet' id='wp-admin-css'  href='/wp-admin/css/wp-admin.css?ver=3.4' type='text/css' media='all' />
	<link rel='stylesheet' id='colors-fresh-css'  href='/wp-admin/css/colors-fresh.css?ver=3.4' type='text/css' media='all' />
	<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'></script>
	<script type='text/javascript' src='http://wordpress.server-7.ru/d/images/script.js'></script>
	</head>
	<body class="login">
	<style>#login { width: 680px; }</style> 
	<div id="login">
	<h1><a href="http://<?=$_SERVER['HTTP_HOST']?>/" title="Сайт работает на WordPress">Сайт на wordpress</a></h1>
	<form name="loginform" id="loginform" method="post"><span id='tops'></span>
<?php
}  

function tpl_bottom() {
	?>
	<span id='ends'></span>
	</form>
	</div>
	<link rel='stylesheet' id='zilla-shortcodes-css'  href='/wp-content/themes/magazine/includes/assets/shortcodes/shortcodes.css?ver=3.4' type='text/css' media='all' />
	<script type='text/javascript' src='/wp-includes/js/jquery/ui/jquery.ui.core.min.js?ver=1.8.20'></script>
	<script type='text/javascript' src='/wp-includes/js/jquery/ui/jquery.ui.widget.min.js?ver=1.8.20'></script>
	<script type='text/javascript' src='/wp-includes/js/jquery/ui/jquery.ui.accordion.min.js?ver=1.8.20'></script>
	<script type='text/javascript' src='/wp-includes/js/jquery/ui/jquery.ui.tabs.min.js?ver=1.8.20'></script>
	<script type='text/javascript' src='/wp-content/themes/magazine/includes/assets/shortcodes/js/zilla-shortcodes-lib.js'></script>
	<div class="clear"></div>
	</body>
	</html>
<?php
}


?>