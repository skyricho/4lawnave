<?php
include ("dbaccess.php");
require 'vendor/autoload.php';
ini_set('display_errors', 1);

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);
$template = $twig->load('my-items.html.twig');


$userFullName = $_GET['n']; // Use name and not cookieId as users may have more than one device

// Image gallery
$request = $fm->newFindCommand('claimPHP');
$request->addFindCriterion('fullName', str_replace('-', ' ', $userFullName)); 
$result = $request->execute();

if (FileMaker::isError($result)) {
    if (! isset($result->code) || strlen(trim($result->code)) < 1) {
        echo 'A System Error Occured';
    } else {
        echo 'No items found for ' . $_POST['userFullName'] . ' (Error Code: '. $result->code. ')';
    }
} else {
    $records = $result->getRecords();
    $myItems = array();
    foreach($records as $record) {
        $myItems[] = array(
            'iD' => $record->getField('iD'),
            'itemId' => $record->getField('itemId'),
            'isClaimed' => 'yes'
        );
    }
}



// Render template
echo $template->render(array(
        //'collectionName' => $collectionName,
        //'collections' => $collectionList,
        'myItems' => $myItems
        )
    );

?>