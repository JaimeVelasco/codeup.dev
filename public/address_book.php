<!DOCTYPE=HTML>

<?php

class AddressDataStore {

    public $filename = '';

    function __construct($filename = 'Data/address_book.csv') {
    	$this->filename = $filename;
    }

    function read_address_book()
    {
        // Code to read file $this->filename
        $handle = fopen($this->filename, "r");
        if (filesize($this->filename) == 0) {
        	$contents = [];
        } else {
        	while (!feof($handle)) {
        		$contents[] = fgetcsv($handle);
        	}
        	foreach ($contents as $key => $value) {
        		if ($value == false) {
        			unset($contents[$key]);
        		}
        	}
        }
        fclose($handle);
        return $contents;
    }

    function write_address_book($addresses_array) 
    {
        // Code to write $addresses_array to file $this->filename
        $handle = fopen($this->filename, "w+");
        foreach($addresses_array as $fields) {
        	fputcsv($handle, $fields);
        }
        fclose($handle);
    }

}

function new_array($items) {
    $new_items = [];
    foreach ($items as $key => $data) {
       	$new_items[] = $data;
    }
    return $new_items;
}

//create object
$book = new AddressDataStore();
$book_array = $book->read_address_book();
$error = '';


if (!empty($_POST['Name']) && !empty($_POST['Address']) && !empty($_POST['City']) && !empty($_POST['State']) && !empty($_POST['ZipCode'])) {
	// Define new entry to the array
		$newEntry = [$_POST['Name'], $_POST['Address'], $_POST['City'], $_POST['State'], $_POST['ZipCode'], $_POST['Phone']];
		array_push($book_array, $newEntry);
		// Write new array new file
		$book_array = new_array(array_values($book_array));
		$book->write_address_book($book_array);
	} elseif (isset($_POST['submit'])) {
		$error = 'You forgot something!!';
	} elseif (isset($_GET['key'])) {
		foreach ($book_array as $key => $data) {
			if ($_GET['key'] == $key) {
				unset($book_array[$key]);
				$book_array = new_array(array_values($book_array));
			}
			$book->write_address_book($book_array);
		}
}

if (count($_FILES) > 0 && $_FILES['file1']['error'] == 0) {
	// Set the destination directory for uploads
	$upload_dir = '/vagrant/sites/codeup.dev/public/uploads';
	// Grab the filename from the uploaded file by using basename
	$filename = basename($_FILES['file1']['name']);
	// Create the saved filename using the file's original name and our upload directory
	$saved_filename = $upload_dir . $filename;
	// Move the file from the temp location to our uploads directory
	move_uploaded_file($_FILES['file1']['tmp_name'], $saved_filename);


//creating a new instance of $book
	$newBook = new AddressDataStore($saved_filename);
	$new = $newBook->read_address_book();




	if(isset($_POST['overwrite'])) {
	$book_array = $new;
	} else {
	    foreach ($new as $key => $data) {
	    	array_push($book_array, $new[$key]);
	    }
	    $book_array = new_array($book_array);
	}

	$book->write_address_book($book_array);
}

// var_dump($_POST);	

?>

<!DOCTYPE HTML>
<html>
<head>
	<title>Adress Book</title>
</head>
<body>

<h1 align="center">ADDRESS BOOK</h1>
<hr>	

<table border="3px" style="width:800px" align="center">
<colgroup>
   <col span='7' style="background-color:gray">
 </colgroup>
<tr>
  <th>Name</th>
  <th>Address</th> 
  <th>City</th>
  <th>State</th>
  <th>ZipCode</th> 
  <th>Phone</th>
  <th></th>

</tr>

<tr>
<? foreach($book_array as $key => $address): ?>
					<tr>
						<? foreach($address as $data): ?>
							<td><?= htmlspecialchars(strip_tags("{$data}")) ?></td>
						<? endforeach; ?>
						<td><?="<a id='remove' name='remove' href='address_book.php?key=$key'> Remove </a>" ?></td>
					</tr>
				<? endforeach; ?>
			

</tr>



 


</table>



<h1 align="center">Add a new entry to the Address Book</h1>
				
	
	    <form align="center" method="POST" action="address_book.php">
	        <p>
	            <input id="Name" name="Name" placeholder="Name" type="text"  value="<?if(isset($_POST['Name']) && isset($error)){echo htmlspecialchars($_POST['Name'], ENT_QUOTES);}?>" autofocus='autofocus' required>
	       
	            <input id="Address" name="Address" placeholder="Address" value="<?if(isset($_POST['Address']) && isset($error)){echo htmlspecialchars($_POST['Address'], ENT_QUOTES);}?>" type="text" required>
	        
	            <input id="City" name="City" placeholder="City" value= "<?if(isset($_POST['City']) && isset($error)){echo htmlspecialchars($_POST['City'], ENT_QUOTES);}?>" type="text" required>
	      
	            <input id="State" name="State" placeholder="State" value="<?if(isset($_POST['State']) && isset($error)){echo htmlspecialchars($_POST['State'], ENT_QUOTES);}?>" type="text" required>
	       
	            <input id="ZipCode" name="ZipCode" placeholder="ZipCode" value= "<?if(isset($_POST['ZipCode']) && isset($error)){echo htmlspecialchars($_POST['ZipCode'], ENT_QUOTES);}?>" type="text" required>
	    
	            <input id="Phone" name="Phone" placeholder="Phone" type="text" >
	   
				<button class="btn btn-success btn-md" type="submit" id="submit" name="submit">Submit</button>

				<? if(isset($error)): ?>
					<p>
						<?= "{$error}" ?>
					</p>
				<? endif; ?>
				
	        </p>

		</form>

		<form align="center" method="POST" enctype="multipart/form-data" action="address_book.php">
	    	<p>
	    	    <label for="file1"><h2>File to upload: </h2></label>
	    	    <input type="file" id="file1" name="file1">
	    	</p>
	    	<p>
	    	    <input class="btn btn-success btn-md" type="submit" value="Upload">
	    		<form method="POST">
	    		<label><input type="checkbox" name="overwrite" id="overwrite" value="yes">Overwrite Current List</label>
	    		</form>
	    	</p>
	    

	    </form> 

</body>
<hr>
<footer>
	<!-- <p>&copy 2014 Jaime Velasco</p> -->
</footer>
</html>	