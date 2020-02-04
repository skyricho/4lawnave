<?php
include ("dbaccess.php");
require 'vendor/autoload.php';
ini_set('display_errors', 1);

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);
$template = $twig->load('list.html.twig');


$collectionName = $_GET['c'];

// Dropdown
$request = $fm->newFindAllCommand('collectionPHP');
$result = $request->execute();

$records = $result->getRecords();
$collectionList = array();
foreach($records as $record) {
    $collectionList[] = array(
        'collection' => $record->getField('collection')
    );
}

// Image gallery
$request = $fm->newFindCommand('inventoryPHP');
$request->addFindCriterion('cCollection', str_replace('-', ' ', $collectionName)); 
//$request->addSortRule('field', 'value');
$result = $request->execute();

$records = $result->getRecords();
$collectionItems = array();
foreach($records as $record) {
    $collectionItems[] = array(
        'itemId' => $record->getField('itemId'),
        'isClaimed' => $record->getField('isClaimed')
    );
}

/*$collectionsItems = array();
$collectionItems[] = array(
	'itemId' => 'foo',
	'isClaimed' => 'bar'
);*/

// Render template
echo $template->render(array(
        'collectionName' => $collectionName,
        'collections' => $collectionList,
        'collectionItems' => $collectionItems
        )
    );

?>