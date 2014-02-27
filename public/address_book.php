<?php

	// echo "<p>GET:</p>";
	// var_dump($_GET);

	// echo "<p>POST:</p>";
	// var_dump($_POST);

$address_book = [];
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

function addItem($NewList) {
		$NewItem = $_POST;
		$NewList[] = $NewItem;
		return $NewList;		
		}
		
function saveFile($NewList, $filename) {
		$handle = fopen($filename, 'w');
		foreach ($NewList as $fields) {
			if ($fields != "") {
				fputcsv($handle, $fields);
			}
		}
		fclose($handle);
	}
	
	$NewList = open_file($filename);
	$NewList = addItem($NewList);
	
// var_dump($NewList);
	saveFile($NewList, $filename)
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
<? foreach ($NewList as $key => $value) : ?> 
	<tr>
		<!-- Double check this!! -->
		<? if ($value != null ) : ?>   
			<? foreach ($value as $item) : ?>
			<td><?= htmlspecialchars(strip_tags($item)) ?></td>
			<? endforeach; ?>
		<? endif; ?>
					
				</tr>
			<? endforeach; ?>

</tr>

</table>

<h1 align="center">Add a new entry to the Address Book</h1>
				

	    <form align="center" method="POST" enctype="multipart/form-data" action="">
	        <p
	            <input id="Name" name="Name" placeholder="Name" type="text" autofocus='autofocus' required>
	       
	            <input id="Address" name="Address" placeholder="Address" type="text" required>
	        
	            <input id="City" name="City" placeholder="City" type="text" required>
	      
	            <input id="State" name="State" placeholder="State" type="text" required>
	       
	            <input id="ZipCode" name="ZipCode" placeholder="ZipCode" type="text" required>
	    
	            <input id="Phone" name="Phone" placeholder="Phone" type="text" >
	    
	        	<input type="submit" value="Add new entry" >
	        </p>

	    </form>

</body>
<footer>
	<!-- <p>&copy 2014 Jaime Velasco</p> -->
</footer>
</html>