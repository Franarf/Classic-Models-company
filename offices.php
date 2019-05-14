<!DOCTYPE html>
<meta charset=utf-8>
<html>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <?php

    echo "<table class='table' style='border: solid 1px black;'>";
    echo "<tr><th>City</th><th>Address</th><th>Phone Number</th></tr>";


    require 'dbconfig.php';

    try {
        //PDO type of connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        //PDO mode set to exeption
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->query("SELECT * FROM offices");

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    //iterates throught the list
    while ($row = $stmt->fetch()) {
        echo "<tr>";
        echo    "<td>" . $row['city'] . "<br><h5>" . $row['country'] . "</h5></td>";
        echo    "<td>" . $row['addressLine1'] . "<br>" . $row['addressLine2'] . "</td>";
        echo    "<td>" . $row['phone'] . "</td>";
        echo    "<td class=\"btn\"><a href='officesextrainfo.php?id=" . $row['officeCode'] . " &officeCity=" . $row['city'] . " '><button class=\"btn\">More Info</td></a>";
    }

    echo "</table>";
    $conn = null;
    //connection closed
    ?>


    <footer>
        <?php include 'footer.php'; ?>
    </footer>

</body>
<link rel="stylesheet" type="text/css" href="style.css">

</html>