<?php 
include ("../dbaccess.php");
ini_set('display_errors', 1);

$request = $fm->newFindAllCommand('collection');
$result = $request->execute();


$records = $result->getRecords();
foreach($records as $record) {
    echo $record->getField('iD') . ': ' . $record->getField('collection') . '<br>';
}

?>