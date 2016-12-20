<?php
    require_once __DIR__.'/vendor/autoload.php';

    $app = new Silex\Application();
    $app->register(new Silex\Provider\UrlGeneratorServiceProvider());
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
            'twig.path' => __DIR__.'/templates',
            'twig.options' => array(
                "cache" => __DIR__.'/run/cache',
                "debug" => true,
            )
    ));
    $image_descr = file(__DIR__."/data/image_descr.txt", FILE_IGNORE_NEW_LINES);

    $pages = array(
        array("name"=>'home', "url"=>'/', "title"=>"Наша компания"),
        array("name"=>'portfolio', "url"=>'/portfolio/', "title"=>"Выполненные работы"),
        array("name"=>'price', "url"=>'/price/', "title"=>"Услуги и цены"),
        array("name"=>'partner', "url"=>'/partner/', "title"=>"Партнёрам"),
        array("name"=>'job', "url"=>'/job/', "title"=>"Вакансии"),
        array("name"=>'contacts', "url"=>'/contacts/', "title"=>"Контакты"),
    );

    foreach( $pages as $page )
    {
        $app->get($page["url"], function () use ($app, $page, $pages, $image_descr) {
            return $app['twig']->render($page["name"].'.html', array(
                "pages" => $pages,
                "current" => $page,
                "image_descr" => $image_descr,
            ));
        })->bind($page["name"]);
    }

    $app->run();
?>
