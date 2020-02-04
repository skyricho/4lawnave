<?php 
include ("dbaccess.php");
ini_set('display_errors', 1);

$request = $fm->newFindAllCommand('collection');
$result = $request->execute();

$collection = array();
foreach($records as $record) {
    $collection[] = array(
        'iD' => $record->getField('iD'),
        'collection' => $record->getField('collection'),
    );
}

echo '<pre>'; print_r($collection); echo '</pre>';
?>