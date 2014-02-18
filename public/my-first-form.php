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
    <title>My First HTML form</title>
</head>


<body>
    <h1>User Login</h1>
    <form method="POST" action="">
        <p>
            <label for="username">Username</label>
            <input id="username" name="username" placeholder="Username here." type="text" >
        </p>
        <p>
            <label for="password">Password</label>
            <input id="password" name="password" placeholder= "Yep, password here."type="password">
        </p>
        <p>
            <!-- <input type="submit" value="Click me, I like it!"> -->
            <button type="submit">Login</button>
        </p>
    </form>            



    <h1>Compose an Email</h1>
    <form method="GET" action="">
        <p>
            <label for="To">To</label>
            <input id="To" name="To" placeholder= "Recipient here." type="text" >
        </p>
        <p>
            <label for="From">From</label>
            <input id="From" name="From" placeholder= "Your email."type="text">
        </p>
        <p>
            <label for="Subject">Subject</label>
            <input id="Subject" name="Subject" placeholder= "Subject here"type="text">
        </p>
       
            <label for="Email_body">Email body</label>
            <textarea id="email_body" name="email_body" placeholder= "Content here"rows="5" cols="40"></textarea>
      
        <p>
            <input type="submit" value="C'mon, send me!"> 
        </p>

        <label for="Save_to_sent_folder">
            <input type="checkbox" id="Save_to_sent_folder" name= "Save_to_sent_folder" value="yes" checked> Save to sent folder?
        </label>
    </form>  
    


    <h1>Multiple Choice Test</h1> 
    <form method="GET" action="">
    <p>What is the capital of Texas?</p>
        <label for="q1a">
            <input type="radio" id="q1a" name="q1" value="houston">
            Houston
        </label>
        <label for="q1b">
            <input type="radio" id="q1b" name="q1" value="dallas">
            Dallas
        </label>
        <label for="q1c">
            <input type="radio" id="q1c" name="q1" value="austin">
            Austin
        </label>
        <label for="q1d">
            <input type="radio" id="q1d" name="q1" value="san antonio">
            San Antonio
    <p>
            <input type="submit" value="Submit if sure"> 
        </p>        
</label> 


        <p>What is the capital of Mexico?</p>
        <label for="q2a">
            <input type="radio" id="q2a" name="q2" value="Guadalajara">
            Guadalajara
        </label>
        <label for="q2b">
            <input type="radio" id="q2b" name="q2" value="Monterrey">
            Monterrey
        </label>
        <label for="q2c">
            <input type="radio" id="q2c" name="q2" value="Coahuila">
            Coahuila
        </label>
        <label for="q2d">
            <input type="radio" id="q2d" name="q2" value="Mexico DF">
            Mexico DF

        <p>
            <input type="submit" value="C'mon, send me!"> 
        </p>    
</label> 
    </form>         


</body>