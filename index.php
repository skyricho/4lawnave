<?php
include ("dbaccess.php");
require 'vendor/autoload.php';
ini_set('display_errors', 1);

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);
$template = $twig->load('index.html.twig');

$request = $fm->newFindAllCommand('collection');
$result = $request->execute();

$records = $result->getRecords();
$collection = array();
foreach($records as $record) {
    $collection[] = array(
        'iD' => $record->getField('iD'),
        'collection' => $record->getField('collection'),
    );
}

echo $template->render(array(
        'collections' => $collection
        )
    );

?>