
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


<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="TodoList for Codeup">
<meta name="author" content="Jaime Velasco">
<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
<link href='http://fonts.googleapis.com/css?family=Lato:100,400,900' rel='stylesheet' type='text/css'>

<!-- Latest compiled and minified JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>




  <title></title>
            <style type="text/css">
              /* bootstrap 3 helpers */



          body {
            font-family: 'Lato', sans-serif; 
            font-weight:900;
            font-size: 18px;
          }    

          h1  {
            font-family: 'Lato', sans-serif; 
            font-weight:100;
            font-size: 62px;
            color: orange;
          }    

          h2  {
            font-family: 'Lato', sans-serif; 
            font-weight:100;
            font-size: 43px;
            color: orange;
          }    
          table  {
            font-family: 'Lato', sans-serif; 
            font-weight:100;
            font-size: 20px;

          }    

         button  {
            font-family: 'Lato', sans-serif; font-weight:100;
            font-size: 10px;
          } 

         #placeholder  {
            font-family: 'Lato', sans-serif; font-weight:100;
            font-size: 12px;
          }       

          .navbar-form input, .form-inline input {
            width:auto;
          }

          header {
            height:270px;
          }

          @media (min-width: 979px) {
            #sidebar.affix-top {
              position: static;
              margin-top:25px;
              width:228px;
            }
            
            #sidebar.affix {
              position: fixed;
              top:25px;
              width:228px;
            }
          }

          .affix,.affix-top {
             position:static;
          }

            </style>
</head>
<body>

    <header class="masthead">
    <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2><a href="#" title="scroll down for your viewing pleasure">Jaime Velasco</a>
          <p class="lead">Junior Developer</p></h2>
      </div>
      <div class="col-md-6 ">
        <div class="pull-right hidden-sm">    
          <h2><a href="#" title="Placeholder fo login sistem"><i class="fa fa-pencil">  </i></a><a href="#" title="A button that makes something awesome"><i class="fa fa-list"></i></a></h2>
        </div>
      </div>
    </div>
    </div>
  </header>         

<!-- Begin Body -->
<div class="container">
  <div class="row">
        <div class="col-md-3">
              
                <div class="list-group" id="sidebar">
                  <a href="#" class="list-group-item">
                   <div class="row text-center"> 
                      <h2>Add Items</h2>
                      <form class="form-horizontal" role="form" action="ToDoMySQL.php" method="POST">
                        <div class="form-group-">
                          
                          <div class="col-sm-12">
                            <textarea class="form-control" rows="3" id="todo" placeholder="New To Do"  name="todo" autofocus="autofocus"></textarea>
                            <!-- <input type="text" name="todo" class="form-control" rows="6" id="todo" placeholder="New To Do" autofocus="autofocus">-->
                          </div>
                        </div>
                        <div class="form-group">
                          <div>
                            <button type="submit" class="btn btn-default" >Add To do</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </a>
                  
                </div>
              




          </div>  
     <div class="col-md-9">


        <div id="leftcol" class="pull-left col-xs-12 text-center">

                  <? if (!empty($successMessage)): ?>
                  <div class="alert alert-success text-center"><?= $successMessage; ?></div>
                  <? endif; ?>
                  <? if (!empty($errorMessage)): ?>
                  <div class="alert alert-danger text-center"><?= $errorMessage; ?></div>
                  <? endif; ?>

        <h1>Todo List</h1>

                    <table class ="table table-condensed table-hover">
                      <? while($todo = $todos->fetch_assoc()): ?>
                        <tr>
                          <td><?= $todo['Item']; ?></td>
                          <td><i class="fa fa-trash-o" onclick="removeById(<?= $todo['id']; ?>)"></i></td>
                        </tr>
                      <? endwhile; ?>
                    </table>
            <div>

                    <? if ($prevPage != null) : ?> 
                        <a href="?page=<?= $prevPage; ?>" class="pull-left btn btn-default btn-sm">Previous &lt;</a>
                      <? endif ?>

                    <? if ($nextPage != null) : ?> 
                        <a href="?page=<?= $nextPage; ?>" class="pull-right btn btn-default btn-sm">Next &gt;</a> 
                      <? endif ?>
            </div>  
        </div>  


    </div>
    </div>
</div>


<form id="removeForm" action="ToDoMySQL.php" method="post">
  <input id="removeId" type="hidden" name="remove" value="">
</form>

<script type="text/javascript">
//remove items
var form = document.getElementById('removeForm');
  var removeId = document.getElementById('removeId');

  function removeById(id) {
    if(confirm('Are you sure you want to remove item?')) {
    removeId.value = id;
    form.submit();
    }
  }


//sidebar
$('#sidebar').affix({
    offset: {
      top: $('header').height()
    }
  }); 


// alerts hide after 5 seconds

// function createAutoClosingAlert(selector, delay) {
//    var alert = $(selector).alert();
//    window.setTimeout(function() { alert.alert('close') }, delay);
// }

</script>

</body>
</html>