<?php

	// echo "<p>GET:</p>";
	// var_dump($_GET);

	// echo "<p>POST:</p>";
	// var_dump($_POST);


// changes!!!! renamed many variables for readability



$address_book = [];
$error = "";
$filename= 'Data/address_book.csv';


function open_file($filename) {
		$handle = fopen($filename, "r");
		$filesize = filesize($filename);
		$openfile = [];
		if($filesize != 0) {
			while(!feof($handle)) {
				$openfile[] = fgetcsv($handle);
			}
		} else {//do I really need this?
			$openfile = array();
		} 
		fclose($handle);
		return $openfile;
	}

function addItem($NewItemList, $error) {
		$NewItem = $_POST;
		if ($NewItem['Name'] == '' || $NewItem['Address'] == '' || $NewItem['City'] == '' || $NewItem['State'] == '' || $NewItem['ZipCode'] == '') {
			$error = "Please enter all information";
		} else {
			$NewItemList[] = $NewItem;
			$error = "";
		}
		return $NewItemList;
	}


function saveFile($NewItemList, $filename) {
		$handle = fopen($filename, 'w');
		foreach ($NewItemList as $fields) {
			if ($fields != "") {
				fputcsv($handle, $fields);
			}
		}
		fclose($handle);
	}
	

	$NewItemList = open_file($filename);
	$NewItemList = addItem($NewItemList, $error);
	

// var_dump($NewItemList);
	saveFile($NewItemList, $filename)
?>	





<!DOCTYPE HTML>
<html>
<head>
	<title>Adress Book</title>
</head>
<body>

<h1 align="center">ADDRESS BOOK</h1>

<table border="3px" style="width:800px" align="center">
<tr>
  <th>Name</th>
  <th>Address</th> 
  <th>City</th>
  <th>State</th>
  <th>ZipCode</th> 
  <th>Phone</th>
</tr>


<tr>
<? foreach ($NewItemList as $key => $value) : ?>
				<tr>
					<? if ($value != '') : ?>
						<? foreach ($value as $item) : ?>
							<td><?= htmlspecialchars(strip_tags($item)) ?></td>
							
						<? endforeach; ?>

						
					<? endif; ?>
					
				</tr>
			<? endforeach; ?>

</tr>






</table>




<h1 align="center">Add a new entry to the Address Book</h1>
				<p><?= $error; ?></p>

	    <form align="center" method="POST" enctype="multipart/form-data" action="">
	        <p>
	            <label for="Name">Name</label>
	            <input id="Name" name="Name" placeholder="Name" type="text" autofocus='autofocus' >
	        </p>
	        <p>
	            <label for="Address">Address</label>
	            <input id="Address" name="Address" placeholder="Address" type="text">
	        </p>
	        <p> 
	        	<label for="City">City</label>
	            <input id="City" name="City" placeholder="City" type="text">
	        </p>
	        <p>
	            <label for="State">State</label>
	            <input id="State" name="State" placeholder="State" type="text">
	        </p>
	        <p>
	        	<label for="ZipCode">ZipCode</label>
	            <input id="ZipCode" name="ZipCode" placeholder="ZipCode" type="text">
	        </p>
	     	<p>
	            <label for="Phone">Phone</label>
	            <input id="Phone" name="Phone" placeholder="Phone" type="text">
	        </p>
	        <p>
	        	<input type="submit" value="Add new entry">
	        </p>

	    </form>

</body>
<footer>
	<!-- <p>&copy 2014 Jaime Velasco</p> -->
</footer>
</html>