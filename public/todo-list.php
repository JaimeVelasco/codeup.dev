<?php

echo "<p>GET:</p>";
var_dump($_GET);

echo "<p>POST:</p>";
var_dump($_POST);

?>


<!DOCTYPE html>
<html lang="eng">

<head>
    <meta charset="utf-8">
    <title>TODO List</title>
</head>

<body>
	<h1>TODO List</h1>
	<ul>
		<li>Complete all the challenges</li>
		<li>Finish my personal website</li>
		<li>Bootstrap my wordpress</li>
		<li>Learn JavaScript</li>
	</ul>

	<h3>Add a new item to the list</h3>
	    <form method="POST" action="">
	        <p>
	            <label for="item">New Item</label>
	            <input id="item" name="item" placeholder="new item here." type="text" >
	        </p>
	        <p>
	        	<input type="submit" value="Add new item">
	        </p>


</body>




