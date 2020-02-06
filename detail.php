<?php
include ("dbaccess.php");
require 'vendor/autoload.php';
ini_set('display_errors', 1);

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);
$template = $twig->load('detail.html.twig');



$itemId = $_GET['id'];


// Get item
$request = $fm->newFindCommand('inventoryPHP');
$request->addFindCriterion('itemId', $itemId); 
$result = $request->execute();

$records = $result->getRecords();
$record = $records[0];
$isClaimed = $record->getField('isClaimed');


// Get claims
$request = $fm->newFindCommand('claimPHP');
$request->addFindCriterion('itemId', $itemId); 
$result = $request->execute();

if (FileMaker::isError($result)) {
    if (! isset($result->code) || strlen(trim($result->code)) < 1) {
        echo 'A System Error Occured';
    } else {
        //echo 'No claim records found for ' . $_POST['userFullName'] . ' (Error Code: '. $result->code. ')';
    }
} else {
    $records = $result->getRecords();
    $claims = array();
    foreach($records as $record) {
        $claims[] = array(
            'userFullName' => $record->getField('fullName')
        );
    }
}



//$cookieId = '1'; //$_COOKIE['userId'];
$userFullName = 'Sky Richardson'; //$_COOKIE['userFullName'];
$userMobile = '123'; //$_COOKIE['userMobile'];

// Render template
echo $template->render(array(
        'itemId' => $itemId,
        'isClaimed' => $isClaimed,
        'cookieId' => $_COOKIE['cookieId'],
        'userFullName' => $_COOKIE['userFullName'],
        'userMobile' => $_COOKIE['userMobile'],
        'claims' => $claims,
        'msg' => $_GET['msg'] 
        )
    );

//New browser? Create cookie
if(!isset($_COOKIE['cookieId'])) {
    $request = $fm->createRecord('cookiePHP');
    $request->setField('userAgent', $_SERVER['HTTP_USER_AGENT']);
    $result=$request->commit();

    // see https://stackoverflow.com/questions/34757462/filemaker-php-api-get-id-of-newly-created-record
    $request = $request->getRecordID();
    //echo $request . '<br>';
    $record = $fm->getRecordByID('cookiePHP', $request);

    //echo 'Record ' . $record->getField('id') . ' has been inserted. First Name: ' . $record->getField('firstName');
    setcookie('cookieId', $record->getField('iD'), time() + (86400 * 365), "/"); // 86400 = 1 day
}

?>