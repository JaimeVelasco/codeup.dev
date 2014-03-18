<?php 

//connect to database
$mysqli = @new mysqli('127.0.0.1', 'codeup', 'password', 'ToDoList');

//Display error if failure to connect
if ($mysqli->connect_errno) 
{
    echo 'Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . PHP_EOL;
} 


$errorMessage = null;
$successMessage = null;



if (!empty($_POST))
{
	//check for new todo
	if(isset($_POST['todo']))
	{
		if ($_POST['todo'] != "")
		{
			$todo = substr($_POST['todo'], 0, 200);
			//add todo
			// Create a new prepared statement
			$stmt = $mysqli->prepare("INSERT INTO ToDoItems (Item) VALUES (?);");

			// Bind a new parameter to the ?
			$stmt->bind_param("s", $todo);
			$stmt->execute();

			$successMessage = "Todo item was added successfully.";
		}
		else
		{
			//show error message
			$errorMessage = "Please input a todo item.";
		}
			
	}	
	else if (!empty($_POST['remove'])) 
	{
		$stmt = $mysqli->prepare("DELETE FROM ToDoItems WHERE id = ?;");
		$stmt->bind_param("i", $_POST['remove']);
		$stmt->execute();

		$successMessage = "Todo item was removed successfully.";
	}
					
}



$itemsPerPage = 5;
$currentPage = !empty($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($currentPage -1) * $itemsPerPage;

$todos = $mysqli->query("SELECT * FROM ToDoItems LIMIT $itemsPerPage OFFSET $offset;");
$allTodos = $mysqli->query("SELECT * FROM ToDoItems;");

$maxPage = ceil($allTodos->num_rows / $itemsPerPage);

$prevPage = $currentPage > 1 ? $currentPage - 1 : null;
$nextPage = $currentPage  < $maxPage ? $currentPage + 1 : null;

?>

	
<!DOCTYPE html>

<head>
<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

<title>TODO List</title>

</head>

<body>

<div class = "container">

	<? if (!empty($successMessage)): ?>
		<div class="alert alert-success"><?= $successMessage; ?></div>
	<? endif; ?>
	<? if (!empty($errorMessage)): ?>
		<div class="alert alert-danger"><?= $errorMessage; ?></div>
	<? endif; ?>



	<h1>Todo List</h1>

	<table class ="table table-condensed table-hover">
	<? while($todo = $todos->fetch_assoc()): ?>
		<tr>
			<td><?= $todo['Item']; ?></td>
			<td><button class="btn btn-danger btn-sm pull-right" onclick="removeById(<?= $todo['id']; ?>)">Remove</button></td>
		</tr>
	<? endwhile; ?>
	</table>



	<div class="clearfix">

		<? if ($prevPage != null) : ?> 
				<a href="?page=<?= $prevPage; ?>" class="pull-left btn btn-default btn-sm">Previous &lt;</a>
			<? endif ?>

		<? if ($nextPage != null) : ?> 
				<a href="?page=<?= $nextPage; ?>" class="pull-right btn btn-default btn-sm">Next &gt;</a>	
			<? endif ?>
	</div>	
	
	<h2>Add Items</h2>
	<form class="form-horizontal" role="form" action="ToDoMySQL.php" method="POST">
		<div class="form-group">
			<label for="todo" class="col-sm-2 control-label">New To do</label>
			<div class="col-sm-10">
				<input type="text" name="todo" class="form-control" id="todo" placeholder="New To Do">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-default">Add To do</button>
			</div>
		</div>
	</form>

</div>



<form id="removeForm" action="ToDoMySQL.php" method="post">
	<input id="removeId" type="hidden" name="remove" value="">
</form>

<script>
	
	var form = document.getElementById('removeForm');
	var removeId = document.getElementById('removeId');

	function removeById(id) {
		if(confirm('Are you sure you want to remove item?')) {
		removeId.value = id;
		form.submit();
		}
	}

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<footer>
	
	<!-- <p>&copy 2014 Jaime Velasco</p> -->

</footer>
</html>