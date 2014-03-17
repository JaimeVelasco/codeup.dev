<?php
require_once 'mysqlicall.php';

// Set default values for Query if GET is not empty
$sortCol = 'name';
$sortOrder = 'asc';

$validCols = ['name', 'location', 'description', 'date_established', 'area_in_acres'];

// this handles the GET links used to sort by which column and which direction asc or desc


if ((isset($_GET['sortcol'])) && (in_array($_GET['sortcol'], $validCols))) {  
  $sortCol = $_GET['sortcol'];

  if ((isset($_GET['sortorder'])) && ($_GET['sortorder'] == 'desc')) {
    $sortOrder = 'desc';
  }
} 
$result = $mysqli->query("SELECT name, location, date_established, area_in_acres, description FROM national_parks ORDER BY $sortCol $sortOrder");




if (!empty($_POST)) {

    try {   
        // Set variables
        if (empty($_POST['name'])) {
            throw new Exception('\'Park Name\' field required.');
        } elseif (empty($_POST['location'])) {
            throw new Exception('\'Location\' field required.');
        } elseif (empty($_POST['description'])) {
            throw new Exception('\'Description\' field required.');
        } elseif (empty($_POST['date_established'])) {
            throw new Exception('\'Date Established\' field required.');
        } elseif (empty($_POST['area_in_acres'])) {
            throw new Exception('\'Area\' field required.');
        } else {
            $name = $_POST['name'];
            $location = $_POST['location'];
            $date_established = $_POST['date_established']; 
            $area_in_acres = $_POST['area_in_acres'];
            $description = $_POST['description'];            

            $stmt = $mysqli->prepare("INSERT INTO national_parks (name, location, date_established, area_in_acres, description ) VALUES (?, ?, ?, ?, ?)");
          
            $stmt->bind_param("sssds", $name, $location, $date_established, $area_in_acres, $description);

            $stmt->execute();
          
            $mysqli->close();
        }
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
    }
}

?>
       

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">

<title>National Parks</title>

<!-- Bootstrap core CSS -->
<link href="assets/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="assets/css/parks.css" rel="stylesheet">


</head>

<body>

<div class="navbar navbar-static-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="http://photojv.com/">Home</a>
    </div>
  </div>
</div>

<div class="container">
    <? if(!empty($errorMessage)): ?> 
    <div class="alert alert-danger" data-dismiss="alert"><?= $errorMessage; ?>
    </div>
<? endif; ?>
    <div class="col-md-12">
        <div class="form-horizontal" >
            <form method="POST" action="national_parks.php" role="form">
              
              <div class="form-group">
                 <label for="name" class="col-sm-2 control-label">Park Name</label>
              <div class="col-sm-10">
                 <input type="text" class="form-control" name="name" id="name" placeholder="Park Name"value="<?php if(isset($_POST['name'])){ echo $_POST['name'];}else{ echo '';}?>" required>
              </div>
              </div>
             
              <div class="form-group">
                 <label for="location" class="col-sm-2 control-label">Location</label>
              <div class="col-sm-10">
                 <input type="text" class="form-control" name="location" id="location" placeholder="location" value="<?php if(isset($_POST['location'])){ echo $_POST['location'];}else{ echo '';}?>" required>
              </div>
              </div>

              <div class="form-group">
                 <label for="date_established" class="col-sm-2 control-label">Date Established</label>
              <div class="col-sm-10">
                 <input type="date" class="form-control" name="date_established" id="date_established" data-date-format="yyyy/mm/dd" placeholder="yyyy/mm/dd" value="<?php if(isset($_POST['date_established'])){ echo $_POST['date_established'];}else{ echo '';}?>" required>
              </div>
              </div>

              <div class="form-group">
                 <label for="area_in_acres" class="col-sm-2 control-label">Area</label>
              <div class="col-sm-10">
                 <input type="text" class="form-control" name="area_in_acres"
                  id="area_in_acres" placeholder="area_in_acres" value="<?php if(isset($_POST['area_in_acres'])){ echo $_POST['area_in_acres'];}else{ echo '';}?>" required>
              </div>
              </div>

              <div class="form-group">
                 <label for="description" class="col-sm-2 control-label">Description</label>
              <div class="col-sm-10">
                 <input type="text" class="form-control" 
                  name= "description" id="description" placeholder="Description" value="<?php if(isset($_POST['description'])){ echo $_POST['description'];}else{ echo '';}?>" required>
              </div>
              </div>

              <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                 <button type="submit" class="btn btn-default">submit</button>
              </div>
              </div>
            </form>
        </div>
    </div>
</div> 
    


<div class="table">
    <div class="col-md-12 table-responsive">
        <h1>A Selection of 10 National Parks in the US</h1>
          <table class="table table-bordered">

                    <thead>
                        <tr>
                            <th class='col-md-1'>
                                Park Name
                                <br>
                                <i><a href="?sortcol=name&amp;sortorder=asc" class="fa fa-sort-desc"</i></a>
                                <i><a href="?sortcol=name&amp;sortorder=desc" class="fa fa-sort-asc"</i></a>
                            </th>    
                            <th class='col-md-1'>
                                Location
                                <br>
                                <i><a href="?sortcol=location&amp;sortorder=asc" class="fa fa-sort-desc"</i></a>
                                <i><a href="?sortcol=location&amp;sortorder=desc" class="fa fa-sort-asc"</i></a>
                            </th>
                            <th class='col-md-2'>
                                Date Stablished
                                <br>
                                <i><a href="?sortcol=date_established&amp;sortorder=asc" class="fa fa-sort-desc"</i></a>
                                <i><a href="?sortcol=date_established&amp;sortorder=desc" class="fa fa-sort-asc"</i></a>
                            </th>
                            <th class='col-md-1'>
                                Area in Acres
                                <br>
                                <i><a href="?sortcol=area_in_acres&amp;sortorder=asc" class="fa fa-sort-desc"</i></a>
                                <i><a href="?sortcol=area_in_acres&amp;sortorder=desc" class="fa fa-sort-asc"</i></a>
                            </th>
                            <th class='col-md-6'>
                                Description
                            </th>
                        </tr>
                    </thead>
                   
                  <?php while ($row = $result->fetch_assoc()): ?>
                  <tr>  
                    <td> <?= $row['name']; ?> </td>
                    <td> <?= $row['location']; ?> </td>
                    <td> <?= $row['date_established']; ?> </td>
                    <td> <?= $row['area_in_acres']; ?> </td>
                    <td> <?= $row['description']; ?> </td>
                <?php endwhile ?>  

                
                   
                   
            </table> 
        </div>
  </div>

</div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
</body>
</html>
