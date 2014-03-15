<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">

    <title>National Parks</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/parks.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

  <?php
    require_once 'mysqlicall.php';
    $sortcol = $_GET['sortcol'];
    $sortorder = $_GET['sortorder'];

  ?>  

    <div class="navbar navbar-static-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">National Parks</a>
        </div>
        <div class="collapse navbar-collapse">
          <!-- <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul> -->
        </div>
        <!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">
      <div class="table">
        <div class="col-md-12 table-responsive">
        <h1>A Selection of 10 National Parks in the US</h1>
              <table class="table table-bordered">

                        <thead>
                            <tr>
                                <th class='col-md-1'>
                                    Park Name
                                    <br>
                                    <i><a href="?sortcol=name&sortorder=asc" class="fa fa-sort-desc"</i></a>
                                    <i><a href="?sortcol=name&sortorder=desc" class="fa fa-sort-asc"</i></a>
                                </th>    
                                <th class='col-md-1'>
                                    Location
                                    <br>
                                    <i><a href="?sortcol=location&sortorder=asc" class="fa fa-sort-desc"</i></a>
                                    <i><a href="?sortcol=location&sortorder=desc" class="fa fa-sort-asc"</i></a>
                                </th>
                                <th class='col-md-2'>
                                    Date Stablished
                                    <br>
                                    <i><a href="?sortcol=date_established&sortorder=asc" class="fa fa-sort-desc"</i></a>
                                    <i><a href="?sortcol=date_established&sortorder=desc" class="fa fa-sort-asc"</i></a>
                                </th>
                                <th class='col-md-1'>
                                    Area in Acres
                                    <br>
                                    <i><a href="?sortcol=area_in_acres&sortorder=asc" class="fa fa-sort-desc"</i></a>
                                    <i><a href="?sortcol=area_in_acres&sortorder=desc" class="fa fa-sort-asc"</i></a>
                                </th>
                                <th class='col-md-6'>
                                    Description
                                </th>
                            </tr>
                        </thead>
                        <?php 
                        $result = $mysqli->query("SELECT name, location, date_established, area_in_acres, description
                                                  FROM national_parks ORDER BY $sortcol $sortorder");

                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            foreach ($row as $park) {
                                echo "<td>$park</td>";
                                }
                                echo "</tr>";
                            };  






                        // $stmt = $mysqli->prepare("SELECT name, location, date_established, area_in_acres, description
                        //                             FROM national_parks WHERE name = ? AND location = ? AND date_established = ?
                        //                             AND description = ? ORDER BY $sortcol $sortorder");

                        // $stmt->bind_param( "sssds" $name, $location, $date_established, $area_in_acres, $description);

                        // $stmt->execute();
                        
                        ?>
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
