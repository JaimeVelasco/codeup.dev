
	<?php

	echo "<p>GET:</p>";
	var_dump($_GET);

	echo "<p>POST:</p>";
	var_dump($_POST);

	echo "<p>_FILES:</p>";
	var_dump($_FILES);
	?>

 



	<ul>

		<?php 
			
			$MergedArray = [];
			$items = [];
			$filename = "Data/todo_list.txt";


			function open_file($file){
			    $filename = $file;
			    $handle = fopen($filename, "r");
			    $contents = fread($handle, filesize($filename));
			    fclose($handle);
			    return explode("\n", $contents);
			}



			function write_file ($items, $file){
		        $filename = $file;
		        $handle = fopen($filename, "w");
		        $item = implode("\n", $items);
		        fwrite($handle, $item);
		        fclose($handle);
		    }

		    

		    if(filesize($filename) > 0){
				$items = open_file ($filename);
			}

			if(isset($_POST['NewItem']) && !empty($_POST['NewItem'])){
				$item = $_POST['NewItem'];
				array_push($items, $item);
				write_file($items, $filename);
				// header ("Location: todo-list.php");
			}


			if(isset($_GET['remove'])){
				$NoItem = $_GET['remove'];
				unset($items[$NoItem]);
				write_file($items, $filename);
				// header ("Location: todo-list.php");
				// exit(0);
			}


			// Verify there were uploaded files and no errors
			if (count($_FILES) > 0 && $_FILES['UploadFile']['error'] == 0 && $_FILES['UploadFile']['type'] == 'text/plain' ){
			    // Set the destination directory for uploads
			    $upload_dir = '/vagrant/sites/codeup.dev/public/uploads/';
			    // Grab the filename from the uploaded file by using basename
			    $uploadedFile = basename($_FILES['UploadFile']['name']);
			    // Create the saved filename using the file's original name and our upload directory
			    $saved_filename = $upload_dir . $uploadedFile;
			    // Move the file from the temp location to our uploads directory
			    move_uploaded_file($_FILES['UploadFile']['tmp_name'], $saved_filename);

			}

			// Check if we saved a file
			if (isset($saved_filename)){
			    $handle = open_file($saved_filename);
			    $Merged = array_merge($items, $handle);
			   	// var_dump($Merged);
			    
			    write_file ($Merged, $filename);
			    header ("Location: todo-list.php");
				
			    
			}

		?>
	</ul>  


	

<!DOCTYPE html>

<head>

    <meta charset="utf-8">
    <title>TODO List</title>

</head>

<body>

	<h1>TODO List</h1>

	<ul>
			<? foreach ($items as $key => $item): ?>
				<li><?= htmlspecialchars ($item)  ?>
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
	        	<input type="submit" value="Add new item">
	        </p>
		
	<h3>Upload a new file</h3>  
			<p>      
	            <label for="UploadFile">Upload File</label>
	            <input id="UploadFile" name="UploadFile" type="file">
	            <label for="overwrite">Want to overwrite the original list?</label>
	            <input id="overwrite" type="checkbox">
	        </p>

	        <p>
	        	<input type="submit" value="Upload File">
	        </p>



</body>

