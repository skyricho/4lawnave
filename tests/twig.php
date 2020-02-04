<?php
require '../vendor/autoload.php';
ini_set('display_errors', 1);

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader);
$template = $twig->load('test.html.twig');


$h = 'hello';
$w = 'world';

echo $template->render(array(
        'h' => $h,
        'w' => $w,
        )
    );

?>
