<?php
include_once ("config.php");
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <h1>Welcome to Everlastling Wardrobe</h1>
    <h2>Please Choose the Brand and Size</h2>

    <style type="text/css">
        table.table-style-three {
            font-family: verdana, arial, sans-serif;
            font-size: 11px;
            color: black;
            border-width: 1px;
            border-color: white;
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
            background-color: darkred;
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
<body>




<form name="Search" action="" method="post">

    <!-- Table goes in the document BODY -->
    <table class="table-style-three">
        <thead>

        <tr>
            <th>Genre</th>
            <td><select name="Genre">
                    <option value="">..Select A Genre</option>
                    <option value="Jazz/Classic">Jazz/Classic</option>
                    <option value="Techno/Funky">Techno/Funky</option>
                    <option value="Indie/Sustainable">Indie/Sustainable</option>
                    <option value="Hip Hop/Streetwear">Hip Hop/Streetwear</option>
                    <option value="Pop/Trendy">Pop/Trendy</option>
                    <option value="Lullaby/PJs">Lullaby/PJs</option>

                </select></td>

        </tr>


        <tr>
            <th>Brand</th>
            <td><select name="Brand">
                    <option value="">..Select A Brand..</option>
                    <?php
                    $AllBrands=fetchAllBrand();
                    foreach ($AllBrands as $Brands){
                        ?>
                        <option value="<?php echo $Brands['BrandName'];?>"><?php echo $Brands["BrandName"];?>
                        </option>
                        <?php
                    }
                    ?>
                </select></td>
        </tr>



        <tr>
            <th>Gender</th>
            <td><select name="Gender">
                    <option value="">..Select Gender</option>
                    <option value="G">Girls</option>
                    <option value="B">Boys</option>
                    <option value="U">Unix</option>
                </select></td>

        </tr>

        <tr>
            <th>Size</th>
            <td><select name="Size">
                    <option value="">..Select A Size..</option>
                    <?php
                    $viewAllSize=fetchAllSize();
                    foreach ($viewAllSize as $AllSize){
                        ?>
                        <option value="<?php echo $AllSize['Size'];?>"><?php echo $AllSize["Size"];?>
                        </option>
                        <?php
                    }
                    ?>
                </select></td>

        </tr>


        <tr>
            <td><input type="Submit" name="submit" value="Submit" style="background-color:lightsalmon";></td>
        </tr>
        </thead>
    </table>
</form>

<pre><?php //print_r($allusers); ?></pre>


<table>
    <tr>
        <td>ItemID</td>
        <td>Quantity</td>
        <td>MSRP</td>

        <?php //NOTICE THE USE OF PHP IN BETWEEN HTML
        if((isset($_POST["submit"]))&& (isset($_POST["Genre"]))&& (isset($_POST["Brand"]))&&
            (isset($_POST["Gender"]))&&(isset($_POST["Size"]))) {

            // require_once("config.php");

// Assigning $_POST values to individual variables for reuse.
            $Genre=$_POST["Genre"];
            $BrandName=$_POST["Brand"];
            $Gender = $_POST["Gender"];
            $Size = $_POST["Size"];

            echo $BrandName,'  ,  ', $Genre, '   , ', $Gender,'  ,  ', $Size, '<br><br>';


                $report = fetchReport($BrandName, $Genre, $Gender, $Size);

        foreach($report as $userdetails) { ?>
    <tr>

        <td><?php print $userdetails['ItemID']; ?></td>
        <td><?php print $userdetails['quantity']; ?></td>
        <td><?php print $userdetails['MSRP']; ?></td>

    </tr>
    <?php } ?>

<!--
                    foreach($report as $userdetails) {


                       echo $userdetails['ItemID'], '<br>';
                        echo $userdetails['MSRP'], '<br>';
                        echo $userdetails['quantity'], '<br>';

                   }
            -->




    <?php } ?>





</table>


</body>


</html>


