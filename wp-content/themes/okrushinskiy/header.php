<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 13.01.15
 * Time: 9:59
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />

    <meta name='yandex-verification' content='662c8dfa90260437' />

<!--    <title>Адвокатская компания Okrushinskiy</title>-->

    <meta name="description" content="Главная страница | Адвокатская компания IMG Partners" />

    <meta name="keywords" content="Аграрне та земельне право Судова практика Податки Банкрутство та реструктуризація Оцінка та моніторинг майна Цінні папери Міжнародне та європейське право M&A Злиття та поглинання Корпоративне та комерційне право Трудове право " />

    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/style.css"/>
    <link rel="stylesheet" href="/css/nivo-slider.css">

    <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon" />

    <script type="text/javascript" src="/js/jquery-1.6.1.min.js"></script>
    <script src="/js/jquery.nivo.slider.pack.js"></script>

    <script type="text/javascript">
        $(window).load(function() {
            $('#slider').nivoSlider({
                effect:'fade', //Specify sets like: 'fold,fade,sliceDown'
                slices:15,
                animSpeed:500,
                pauseTime:3000,
                pauseOnHover:false,
                startSlide:0, //Set starting Slide (0 index)
                captionOpacity:0.8, //Universal caption opacity
                controlNav: true, // 1,2,3... navigation
                controlNavThumbs: true, // Use thumbnails for Control Nav
                controlNavThumbsFromRel: true, // Use image rel for thumbs
                controlNavThumbsSearch: '.png', // Replace this with...
                controlNavThumbsReplace: 'bullets.png', // ...this in thumb Image src
            });
            $('#slider2').nivoSlider({
                effect:'sliceDown', //Specify sets like: 'fold,fade,sliceDown'
                slices:10,
                animSpeed:500,
                pauseTime:3000,
                pauseOnHover:false,
                startSlide:0, //Set starting Slide (0 index)
                captionOpacity:1.8, //Universal caption opacity
                controlNav: true, // 1,2,3... navigation
                controlNavThumbs: true, // Use thumbnails for Control Nav
                controlNavThumbsFromRel: true, // Use image rel for thumbs
                controlNavThumbsSearch: '.png', // Replace this with...
                controlNavThumbsReplace: 'bullets.png', // ...this in thumb Image src
            });
        });
    </script>

    <link href="https://plus.google.com/103330142912450765769" rel="publisher" />

    <script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-29871207-1']);
        _gaq.push(['_trackPageview']);

        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

    </script>
    <title><?php wp_title('«', true, 'right'); ?> <?php bloginfo('name'); ?></title>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
