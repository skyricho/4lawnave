<?php
include ("dbaccess.php");
require 'vendor/autoload.php';
ini_set('display_errors', 1);

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);
$template = $twig->load('collection.html.twig');


$collectionName = $_GET['c'];

// Dropdown
$request = $fm->newFindAllCommand('collection');
$result = $request->execute();

$records = $result->getRecords();
$collectionList = array();
foreach($records as $record) {
    $collectionList[] = array(
        'collection' => $record->getField('collection')
    );
}

echo $template->render(array(
        'collectionName' => $collectionName,
        'collections' => $collectionList
        )
    );

?>