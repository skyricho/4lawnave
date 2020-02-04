<?php
include ("dbaccess.php");
require 'vendor/autoload.php';
ini_set('display_errors', 1);

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);
$template = $twig->load('detail.html.twig');


$itemId = $_GET['id'];

/*// Get item
$request = $fm->newFindCommand('inventoryPHP');
$request->addFindCriterion('itemId', $itemId); 
//$request->addSortRule('field', 'value');
$result = $request->execute();

$records = $result->getRecords();
$collectionItems = array();
foreach($records as $record) {
    $collectionItems[] = array(
        'itemId' => $record->getField('itemId'),
        'isClaimed' => $record->getField('isClaimed')
    );
}*/

/*$collectionsItems = array();
$collectionItems[] = array(
	'itemId' => 'foo',
	'isClaimed' => 'bar'
);*/

// Render template
echo $template->render(array(
        //'collectionName' => $collectionName,
        //'collections' => $collectionList,
        //'collectionItems' => $collectionItems
        'itemId' => $itemId
        )
    );

?>