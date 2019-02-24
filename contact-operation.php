<?php
session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $to = 'shabazbelim@gmail.com';
    $headers = "From: ".$email . "\r\n";
    $headers .= 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $notify = $_POST['message'];
    $message =  '<html>
                <head>
                    <title>MR ART EXPORTS</title>
                    <style type="text/css">
                        body
                        {
                            background: #c1bdba;
                            font-family: "Titillium Web", sans-serif;
                        }
                        a
                        {
                            text-decoration: none;
                            color: #1ab188;
                            -webkit-transition: .5s ease;
                            transition: .5s ease;
                        }
                        a:hover
                        {
                            color: #179b77;
                        }
                        h1
                        {
                            font-size: 18px;
                            text-align: center;
                            color: #ffffff;
                            font-weight: 300;
                        }
                        h2
                        {
                            text-align: center;
                            color: #1ab188;
                            font-weight: 1000;
                        }
                        span
                        {
                            color: #1ab188;
                            font-weight: bold;
                        }
                        p
                        {
                            text-align: center;
                            color: #ffffff;
                            margin: 0px 0px 50px 0px;
                            padding-top: 2px;
                        }
                        .form
                        {
                            background: rgba(19, 35, 47, 0.9); 
                            padding: 40px;
                            max-width: 600px;
                            margin: 40px auto;
                            border-radius: 4px;
                            box-shadow: 0 4px 10px 4px rgba(19, 35, 47, 0.3);
                        }
                        .button
                        {
                            font-family: "Titillium Web", sans-serif;
                            border: 0;
                            outline: none;
                            border-radius: 0;
                            padding: 15px 0;
                            margin-top: 30px;
                            font-size: 2rem;
                            font-weight: 600;
                            text-transform: uppercase;
                            letter-spacing: .1em;
                            background: #1ab188;
                            color: #ffffff;
                            -webkit-transition: all 0.5s ease;
                            transition: all 0.5s ease;
                            -webkit-appearance: none;
                        }
                        .button:hover, .button:focus
                        {
                            background: #179b77;
                        }
                        .button-block
                        {
                            display: block;
                            width: 100%;
                        }
                    </style>
                </head>
                <body>
                    <div class="form"><center><a href="https://www.mrartexports.com"><img src="https://www.mrartexports.com/images/logo.png" alt="MR ART Exports" width="150px"></a></center>
                        <h1 style="font-size: 20px; text-align: left;">Contact Form <a>'.$notify.'</a></h1>,<br>
                
                    </div>
                </body>
                </html>';
    mail($to, $subject, $message, $headers);
    echo "<div class='alert alert-success' role='alert'>Email is successfully send.</div>";
}
?>

