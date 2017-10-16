<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <h1>Bug Tracking System</h1>
    <h2>Closed bugs</h2>
    <!-- Style -- Can also be included as a file usually style.css -->
    <style type="text/css">
        table.table-style-three {
            font-family: verdana, arial, sans-serif;
            font-size: 11px;
            color: black;
            border-width: 1px;
            border-color: black;
            border-collapse: collapse;
        }
        table.table-style-three th {
            border-width: 1px;
            padding: 8px;
            border-style: solid;
            border-color:black;
            background-color: black;
            color: white;
        }
        table.table-style-three a {
            color:black;
            text-decoration: none;
        }

        table.table-style-three tr:hover td {
            cursor: pointer;
        }
        table.table-style-three tr:nth-child(even) td{
            background-color: white;
        }
        table.table-style-three td {
            border-width: 1px;
            padding: 8px;
            border-style: solid;
            border-color: black;
            background-color: lightsalmon;
        }
        body {
            background: url(bug.jpg) no-repeat center center fixed;
            top:0%;
            left:0;
            min-width:200%;
            min-height:200%;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
    </style>

</head>
</style>




<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<body>


<?php
require_once("config.php");
$test = fetchAllBrand();



?>

<table class="table-style-three">
    <thead>
    <!-- display user details header  -->
    <th>BrandName</th>

    
    </thead>
    <tbody>
    <?php
    foreach($test as $displayRecords) { ?>
        <tr>
            <td><?php print $displayRecords['BrandName']; ?></td>

        </tr>
    <?php } ?>
    </tbody>
</table>
</body>
</html>