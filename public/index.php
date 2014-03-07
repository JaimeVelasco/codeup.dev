<?php 
            
require_once 'file_store.php';  
$list = new Filestore("Data/todo_list.txt");
$items = $list->read();
$archiveFile = new Filestore('Data/archives.txt');
$archives = $archiveFile->read();
$error = '';

class InvaidInputException extends Exception{}




            if(isset($_POST['NewItem'])){
                try {
                    if (strlen($_POST['NewItem']) >240 ) {
                        throw new InvaidInputException('Please enter something smaller than 240 characters');
                    }elseif (empty($_POST['NewItem'])) {
                        throw new InvaidInputException ('Please enter an item');
                    }else{
                        array_push($items, $_POST['NewItem']);
                        $list->save($items);}
                }catch(InvaidInputException $e){        
                    $InvalidInputMessage = $e->getMessage();
                    }               
                }
            

            if (isset($_GET['remove'])) {
                $archiveItem = array_splice($items, $_GET['remove'], 1);
                $archives = array_merge($archives, $archiveItem);
                $archiveFile->save($archives);
                $list->save($items);
                header("Location: index.php");
                exit(0);
            }
            

            // Verify there were uploaded files and no errors
            if (count($_FILES) > 0 && $_FILES['UploadFile']['error'] == 0 && $_FILES['UploadFile']['type'] == 'text/plain' ){
                if($_FILES['UploadFile']['error'] != 0) {
                    $error = 'ERROR UPLOADING FILE.';
                } elseif ($_FILES['UploadFile']['type'] != 'text/plain') {
                    $error = 'ERROR: INVALID FILE TYPE.';
                } else {
                    $upload_dir = '/vagrant/sites/codeup.dev/public/uploads/';
                    $filename = basename($_FILES['UploadFile']['name']);
                    $saved_filename = $upload_dir . $filename;
                    move_uploaded_file($_FILES['UploadFile']['tmp_name'], $saved_filename);
                    $uploadedList = new Filestore($saved_filename);
                    $fileContents = $uploadedList->read();  

                    if (isset($_POST['submit'])) {
                        $items = $fileContents;
                    } else {
                        $items = array_merge($items, $fileContents);
                    }
                    $list->save($items);    
                    }
            }           
        ?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Jaime Velasco</title>

    <!-- Bootstrap Core CSS -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <!-- Fonts -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

    <!-- Custom Theme CSS -->
    <link href="css/grayscale.css" rel="stylesheet">

</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-custom">

    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="#page-top">
                    <i class="fa fa-camera"></i>  <span class="light">Jaime</span> Velasco
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li class="page-scroll">
                        <a href="#about">About</a>
                    </li>
                    <li class="page-scroll">
                        <a href="#download">Codeup</a>
                    </li>
                    <li class="page-scroll">
                        <a href="#contact">Contact</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <section class="intro">
        <div class="intro-body">
            <div class="container">
                <div class="intro">
                    <div class="col-md-12">
                        <h1 class="brand-heading">ToDo List</h1>
                       
        
        <ul>

            <? foreach ($items as $key => $item): ?>
                <li><?= htmlspecialchars(strip_tags($item)); ?>
                <a href='?remove=<?= $key; ?>'> (Remove) </a>
                </li>
            <? endforeach; ?>
        </ul>   
            
        

    <h3>Add a new item to the list</h3>
        <form method="POST" enctype="multipart/form-data" action="">
            <p>
                <label for="NewItem">New Item</label>
                <input id="NewItem" name="NewItem" placeholder="new item here." type="text" autofocus='autofocus' >
            
            <p>
                <? if (!empty($InvalidInputMessage)) : ?>
                ! <?= $InvalidInputMessage; ?> !
                <? endif; ?>
            </p>    

            <p>
                <input type="submit" value="Add new item">
            </p>
        
    <h3>Upload a new file</h3>  
            <p>      
                <label for="UploadFile">Upload File</label>
                <input id="UploadFile" name="UploadFile" type="file">

                <label for="overwrite">Want to overwrite the original list?</label>
                <input id="overwrite" name="overwrite" type="checkbox" value="true">
            </p>

            <p>
                <input type="submit" value="Upload File">
            </p>
        </form>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="container content-section text-center">
        <div class="Row">
            <div class="col-lg-8 col-lg-offset-2">
                <h1>About me</h1>
                <tt>I’m a 36 year old father of an amazing 8 year old kid. Professionaly, I have been a free-lance <a href="http://photojv.com/">commercial photographer</a></li> for the best part of the last 10 years, serving clients of all sizes. I’ve also worked as a copywriter for an <a href="http://www.adler-ce.com/">advertising company</a></li>, a cook for a <a href="http://www.limon.co.nz/">busy restaurant</a></li> in New Zealand, had a little Cafe in Cabo San Lucas and managed a <a href="http://www.elja.mx/">custom jewelry business</a></li> in Guadalajara, Mexico. I moved to San Antonio a bit over 3 years ago and it feels like home already.</tt>
            </div>
        </div>
    </section>

    <section id="download" class="content-section text-center">
        <div class="download-section">
            <div class="container">
                <div class="col-lg-8 col-lg-offset-2">
                    <h1>I'm a Codeup Student now.</h1>
                    <p><strong>I want to learn how to build stuff</strong>, that's my main reason for studying web development. I have tried to do it on my own, but found it really hard. I joined Geekdom with the hope to learn from the community there and that’s how I heard about Codeup.  So making the decision to apply was a no-brainer, convincing my girlfriend that I was going to quit my job and then not get another for a few months proved to be a lot harder. But honestly, this feels really good. And, who knows?, maybe this turns out to be one of the best decisions I’ve made.</p>
                    <a href="http://www.codeup.com" class="btn btn-default btn-lg">Check out CodeUp, its awesome.</a>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="container content-section text-center">
        <div class="Row">
            <div class="col-lg-8 col-lg-offset-2">
                <h1>Contact me!</h1>
                <p>Feel free to email, asking anything or to just say hello!</p>
                <p><a href="mailto:jaime@photojv.com?Subject=Hello_from_webpage" target="_top">jaime@photojv.com</p>
                <ul class="list-inline banner-social-buttons">
                    <li><a href="https://twitter.com/jaimevelas" class="btn btn-default btn-lg"><i class="fa fa-twitter fa-fw"></i> <span class="network-name">Twitter</span></a>
                    </li>
                    <li><a href="https://github.com/JaimeVelasco" class="btn btn-default btn-lg"><i class="fa fa-github fa-fw"></i> <span class="network-name">My Github</span></a>
                    </li>
                    <li><a href="https://plus.google.com/u/1/112643031668235216682/posts" class="btn btn-default btn-lg"><i class="fa fa-google-plus fa-fw"></i> <span class="network-name">Google+</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <div id="map"></div>

    <!-- Core JavaScript Files -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Google Maps API Key - You will need to use your own API key to use the map feature -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRngKslUGJTlibkQ3FkfTxj3Xss1UlZDA&sensor=false"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/grayscale.js"></script>

</body>

</html>
