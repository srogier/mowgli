<?php

require_once __DIR__ . '/../vendor/Mowgli/vendor/Symfony/Component/ClassLoader/UniversalClassLoader.php';
require_once __DIR__ . '/../vendor/Twig/lib/Twig/Autoloader.php';

Twig_Autoloader::register();

$loader = new Symfony\Component\ClassLoader\UniversalClassLoader();
$loader->registerNamespaces(array(
    'Symfony'   => __DIR__ . '/../vendor/Mowgli/vendor',
    'Mowgli'      => __DIR__ . '/../vendor',
    'sro\Mowgli'  => __DIR__ ,
));

$loader->registerPrefixes(array(
    'Pimple' => __DIR__.'/../vendor/Mowgli/vendor/Pimple/lib',
));

$loader->register();



