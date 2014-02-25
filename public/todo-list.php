
	<?php

	// echo "<p>GET:</p>";
	// var_dump($_GET);

	// echo "<p>POST:</p>";
	// var_dump($_POST);

	echo "<p>_FILES:</p>";
	var_dump($_FILES);
	?>

 



	<ul>

		<?php 
			
			
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
				header ("Location: todo-list.php");
			}


			if(isset($_GET['remove'])){
				$NoItem = $_GET['remove'];
				unset($items[$NoItem]);
				write_file($items, $filename);
				header ("Location: todo-list.php");
				exit(0);
			}

			// Verify there were uploaded files and no errors
			if (count($_FILES) > 0 && $_FILES['UploadFile']['error'] == 0) {
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
			if (isset($saved_filename)) {
			    // If we did, show a link to the uploaded file
			    echo "<p>Here's your file:  <a href='/uploads/{$uploadedFile}'>Download it</a>.</p>";
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
			<?php foreach ($items as $key => $item) { ?>
				<li><?php echo $item?>
				<a href='?remove=<?php echo $key; ?>'> (Remove) </a>
				</li>
			<?php } ?>
				
				
	</ul>		


	<h3>Add a new item to the list</h3>
	    <form method="POST" enctype="multipart/form-data" action="">
	        <p>
	            <label for="NewItem">New Item</label>
	            <input id="NewItem" name="NewItem" placeholder="new item here." type="text" autofocus='autofocus' >
	        <br>
	        <br>

	            <label for="UploadFile">Upload File</label>
	            <input id="UploadFile" name="UploadFile" type="file">

	        </p>

	        <p>
	        	<input type="submit" value="Add new item">
	        </p>



</body>

