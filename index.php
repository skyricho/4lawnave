<?php 
include ("dbaccess.php");
ini_set('display_errors', 1);

$request = $fm->newFindAllCommand('collection');
$result = $request->execute();


$records = $result->getRecords();
foreach($records as $record) {
    echo $record->getField('iD') . ':<br>';
}

// or as an array
$collection = array();
foreach($records as $record) {
    $collection[] = array(
        'iD' => $record->getField('iD'),
        'collection' => $record->getField('collection'),
    );
}


// print array
echo '<pre>'; print_r($collection); echo '</pre>';
?>