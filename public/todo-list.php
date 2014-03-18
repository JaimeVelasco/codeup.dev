
<!-- 	<?php

	echo "<p>GET:</p>";
	var_dump($_GET);

	echo "<p>POST:</p>";
	var_dump($_POST);

	echo "<p>FILES:</p>";
	var_dump($_FILES);

	?> -->






<?php 			
require_once 'file_store.php';	
$list = new Filestore("assets/Data/todo_list.txt");
$items = $list->read();
$archiveFile = new Filestore('assets/Data/archives.txt');
$archives = $archiveFile->read();
$error = '';

class InvaidInputException extends Exception{}




if(isset($_POST['NewItem'])){
	try {
		if (strlen($_POST['NewItem']) >240 ) {
			throw new InvaidInputException('Please enter something smaller than 240 characters');
		}elseif (empty($_POST['NewItem'])) {
			throw new InvaidInputException ('Please enter an item');
		}else{
			array_push($items, $_POST['NewItem']);
			$list->save($items);}
	}catch(InvaidInputException $e){		
		$InvalidInputMessage = $e->getMessage();
		}				
	}


if (isset($_GET['remove'])) {
	$archiveItem = array_splice($items, $_GET['remove'], 1);
	$archives = array_merge($archives, $archiveItem);
	$archiveFile->save($archives);
	$list->save($items);
	header("Location: todo-list.php");
	exit(0);
}


// Verify there were uploaded files and no errors
if (count($_FILES) > 0 && $_FILES['UploadFile']['error'] == 0 && $_FILES['UploadFile']['type'] == 'text/plain' ){
 	if($_FILES['UploadFile']['error'] != 0) {
		$error = 'ERROR UPLOADING FILE.';
	} elseif ($_FILES['UploadFile']['type'] != 'text/plain') {
		$error = 'ERROR: INVALID FILE TYPE.';
	} else {
		$upload_dir = '/vagrant/sites/codeup.dev/public/uploads/';
		$filename = basename($_FILES['UploadFile']['name']);
		$saved_filename = $upload_dir . $filename;
		move_uploaded_file($_FILES['UploadFile']['tmp_name'], $saved_filename);
		$uploadedList = new Filestore($saved_filename);
		$fileContents = $uploadedList->read();	

	if (isset($_POST['submit'])) {
		$items = $fileContents;
	} else {
		$items = array_merge($items, $fileContents);
	}
	$list->save($items);	
	}
}			
?>
	


	

<!DOCTYPE html>

<head>

<meta charset="utf-8">
<link rel="stylesheet" href="/css/todo.css">



<title>TODO List</title>

</head>

<body>

<h1>TODO LIST</h1>
		
<ul>

	<? foreach ($items as $key => $item): ?>
		<li><?= htmlspecialchars(strip_tags($item)); ?>
		<a href='?remove=<?= $key; ?>'> (Remove) </a>
		</li>
	<? endforeach; ?>
</ul>	
			
		



	

<h3>Add a new item to the list</h3>
<form method="POST" enctype="multipart/form-data" action="">
    <p>
        <label for="NewItem">New Item</label>
        <input id="NewItem" name="NewItem" placeholder="new item here." type="text" autofocus='autofocus' >
    
    <p>
		<? if (!empty($InvalidInputMessage)) : ?>
		! <?= $InvalidInputMessage; ?> !
		<? endif; ?>
	</p>    

    <p>
    	<input type="submit" value="Add new item">
    </p>

<h3>Upload a new file</h3>  
	<p>      
        <label for="UploadFile">Upload File</label>
        <input id="UploadFile" name="UploadFile" type="file">

        <label for="overwrite">Want to overwrite the original list?</label>
        <input id="overwrite" name="overwrite" type="checkbox" value="true">
    </p>

    <p>
    	<input type="submit" value="Upload File">
    </p>
</form>



</body>

<footer>
	<br>
	<br>
	<br>
	<br>
	<!-- <p>&copy 2014 Jaime Velasco</p> -->

</footer>

</html>
