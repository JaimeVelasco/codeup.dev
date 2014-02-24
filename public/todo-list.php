
<!-- 	<?php

	echo "<p>GET:</p>";
	var_dump($_GET);

	echo "<p>POST:</p>";
	var_dump($_POST);

	?>

 -->

<!DOCTYPE html>

<head>

    <meta charset="utf-8">
    <title>TODO List</title>

</head>

<body>

	<h1>TODO List</h1>

	<h3>Add a new item to the list</h3>
	    <form method="POST" action="todo-list.php">
	        <p>
	            <label for="item">New Item</label>
	            <input id="item" name="item" placeholder="new item here." type="text" >
	        </p>

	        <p>
	        	<input type="submit" value="Add new item">
	        </p>


	<ul>

		<?php 
			
			$items = [];



			function open_file($file){
			    $filename = $file;
			    $handle = fopen($filename, "r");
			    $contents = fread($handle, filesize($filename));
			    fclose($handle);
			    return explode("\n", $contents);
			}

			$items = open_file ("Data/todo_list.txt");

			
			

			foreach ($items as $item) {
				echo "<li>$item</li>";

			}


			function write_file ($items, $file){
		        $filename = $file;
		        $handle = fopen($filename, "w");
		        $item = implode("\n", $items);
		        fwrite($handle, $item);
		        fclose($handle);
		    }

		    

		?>


	</ul>        




</body>






