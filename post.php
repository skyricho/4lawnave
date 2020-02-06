<?php
include ("dbaccess.php");
//ini_set('display_errors', 1);

// Claim item
if ($_POST['submit'] === 'claim') {
    //Insert record to claim
    $request = $fm->createRecord('claimPHP');
    $request->setField('itemId', $_POST['itemId']);
    $request->setField('cookieId', $_COOKIE['cookieId']);
    $request->setField('fullName', $_POST['userFullName']);
    $request->setField('mobileNumber', $_POST['userMobile']);
    $result=$request->commit();

    // Find inventory record ID
    $request = $fm->newFindCommand('inventoryPHP');
    $request->addFindCriterion('itemId', $_POST['itemId']); 
    $result = $request->execute();

    $records = $result->getRecords();
    $record = $records[0];
    $iD = $record->getField('iD');

    // Update inventory record
    $request = $fm->newEditCommand('inventoryPHP', $iD);
    $request->setField('isClaimed', 'yes');
    $request->execute();
    $_GET['id'] = $_POST['itemId']; //


    //Update cookies
    setcookie('userFullName', $_POST['userFullName'], time() + (86400 * 365), "/"); // 86400 = 1 day
    setcookie('userMobile', $_POST['userMobile'], time() + (86400 * 365), "/"); // 86400 = 1 day


    // Message
    //echo 'Claimed by ' . $_POST['userFullName'];
    // this does not pickup bootstrap ccc! echo '<div class=\"alert alert-light alert-dismissible fade show\" role=\"alert\">Claimed by ' . $_POST['userFullName'] . 
      '<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
        <span aria-hidden=\"true\">&times;</span>
      </button>
    </div>';

    // Redirect used prior to intercoolerjs
    header("Location: detail.php?id=" . $_POST['itemId'] . '&msg=success');

}

// Unclaim item
if ($_POST['submit'] == 'unclaim') {
    // Delete claim
    $record = $fm->getRecordById('claimPHP', $_POST['iD']);
    $record->delete();

    // Find claim if record ID not known
	$request = $fm->newFindCommand('claimPHP');
	$request->addFindCriterion('itemId', $_POST['itemId']);
	$request->addFindCriterion('fullName', $_POST['userFullName']); 
	$result = $request->execute();
    
    if (FileMaker::isError($result)) {
	    if (! isset($result->code) || strlen(trim($result->code)) < 1) {
	        echo 'A System Error Occured';
	    } else {
	        echo 'No claim records found for ' . $_POST['userFullName'] . ' (Error Code: '. $result->code. ')';
	    }
	} else {
	    // Delete claim or claims
		$records = $result->getRecords();
	    foreach($records as $record) {
	        $rec = $fm->getRecordById('claimPHP', $record->getField('iD'));
	        $rec->delete();
	    }
    }
    
    // Update inventory record
	$request = $fm->newFindCommand('claimPHP');
	$request->addFindCriterion('itemId', $_POST['itemId']);
	$result = $request->execute();

    if (FileMaker::isError($result)) {
	    if (! isset($result->code) || strlen(trim($result->code)) < 1) {
	        echo 'A System Error Occured';
	    } else {
	        // No claims found so get inventory record ID
	        $request = $fm->newFindCommand('inventoryPHP');
			$request->addFindCriterion('itemId', $_POST['itemId']);
			$result = $request->execute();

	        $records = $result->getRecords();
	        $record = $records[0];
	        $iD = $record->getField('iD');
	        //echo $_POST['itemId'] . ' ' . $iD . '<br>';

	        // Update inventory record
		    $request = $fm->newEditCommand('inventoryPHP', $iD);
			$request->setField('isClaimed', '');
			$request->execute();	        
	        //echo 'No Records Found ssss(Error Code: '. $result->code. ')';
	    }
	}

    // Message
    //echo 'Claim deleted';

}


/*$itemId = $_POST['itemId'];
$cookieId = $_POST['cookieId'];
$userFullName = $_POST['userFullName'];
$userMobile = $_POST['userMobile'];
$userAction = $_POST['submit'];*/

//echo $cookieId . "<br>" . $userFullName . "<br>" . $userMobile . "<br>" . $itemId . "<br>" . $userAction


?>