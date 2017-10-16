<?php

include_once ("config.php");

// call to function fetchAllUsers() from functions.php

 $report = fetchReport($BrandName, $Genre, $Gender, $Size);

?>


<pre><?php //print_r($allusers); ?></pre>

<html>
<head>
    <title>Report the Results</title>
</head>

<body>
<table>
    <tr>
        <td>ItemID</td>
        <td>Quantity</td>
        <td>MSRP</td>

        <?php //NOTICE THE USE OF PHP IN BETWEEN HTML
        foreach($report as $userdetails) { ?>
    <tr>

        <td><?php print $userdetails['ItemID']; ?></td>
        <td><?php print $userdetails['quantity']; ?></td>
        <td><?php print $userdetails['MSRP']; ?></td>

    </tr>

    <?php } ?>

</table>
</body>
</html>