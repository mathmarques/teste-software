<?php
// DIC configuration

$container = $app->getContainer();

//Smarty
$container['view'] = function ($container) {
    $settings = $container->get('settings');
    $view = new \Slim\Views\Smarty($settings['view']['template_path'], $settings['view']['smarty']);

    // Add Slim specific plugins
    $smartyPlugins = new \Slim\Views\SmartyPlugins($container['router'], $container['request']->getUri());
    $view->registerPlugin('function', 'path_for', [$smartyPlugins, 'pathFor']);
    $view->registerPlugin('function', 'base_url', [$smartyPlugins, 'baseUrl']);

    // Logged User set null
    $view['loggedUser'] = null;

    return $view;
};

$container['notFoundHandler'] = function ($container) {
    return function ($request, $response) use ($container) {
        return $container->get('view')->render($response, '404.tpl')->withStatus(404);
    };
};
