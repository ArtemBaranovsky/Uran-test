<?php
require('FieldInterface.php');
require('ListObjects.php');
require('Users.php');
require('Messages.php');
session_start();
$messages = new Messages();
$bunchMessages = $messages->getList();
$quantity = count($bunchMessages);

$itemsPerPage = 4;
$totalPages = ceil($quantity/$itemsPerPage);

//var_dump($_SESSION);
if (!$_SESSION['pageNumber']) {
    $_SESSION['pageNumber'] = 1;
};

$_SESSION['pageNumber'] = 1;
$offset = ($itemsPerPage * $_SESSION['pageNumber']) - $itemsPerPage;



?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,initial-scale=1.0,maximum-scale=1.0,user-scalable=no,viewport-fit=cover">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <title>Document</title>
</head>
    <body>
        <div class="container">
            <div class="card w-70 my-5">
                <table id="myTable" class="table table-striped  table-bordered table-hover ">
                    <thead class="thead-dark">

                        <tr class="text-center table-primary">
                                <td><h3>id</h3></td><td class="w-25"><h3>Author</h3></td><td><h3>Message</h3></td>
                        </tr>

                    </thead>
                    <tbody>
                        <?php for ($item = 0 ; $item  < $quantity ; $item++) {
                            echo("<tr><td>" . $bunchMessages[$item][0]. "</td><td  class='text-center'>" . $bunchMessages[$item][1] . "</td><td>" . $bunchMessages[$item][2] . "</td></tr>");
                        } ?>
                    </tbody>
                </table>
<!--                <div class="m-3">-->
<!--                    <h4>Page #<span>--><?php //echo $_SESSION['pageNumber'] ?><!--</span> of <span>--><?php //echo $totalPages ?><!--</span></sp></h4>-->
<!--                    <nav>-->
<!--                        <button class="btn btn-info prev">prev</button>-->
<!--                        <button class="btn btn-info next">next</button>-->
<!--                    </nav>-->
<!--                </div>-->
            </div>
        </div>
        <script src="js/main.js"></script>
    </body>
</html>
