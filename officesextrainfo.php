<!DOCTYPE html>
<meta charset=utf-8>
<html>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>

    <?php
    require 'dbconfig.php';
    //set two variables with the get method to use the info in another field
    $officename = $_GET['officeCity'];
    $info_office = $_GET['id'];

    echo "<table id='office-extra' class='table' style='border: solid 1px black;'>";
    echo "<tr><th>First Name</th><th>Last Name</th><th>Job Title</th><th>Email Address</th></tr>";


    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        //PDO mode set to exeption
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->query("SELECT * FROM employees WHERE officeCode = '$info_office'");

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    //recall the variable from before to show the updated field
    echo "<h3>" . $officename . " Employees</h3>";

    //echo the office;
    while ($row = $stmt->fetch()) {

        echo "<tr>";
        echo    "<td>" . $row['firstName'] . "</td>";
        echo    "<td>" . $row['lastName'] . "</td>";
        echo    "<td>" . $row['jobTitle'] . "</td>";
        echo    "<td>" . $row['email'] . "</td>";
        echo    "<td class=\"btn\" id=\"officeback\"><a href='offices.php?id=" . $row['officeCode'] . "'><button class=\"btn2\">back</a></td>";
    }



    echo "</table>";
    $conn = null;
    //closes the connection
    ?>


    <footer>
        <?php include 'footer.php'; ?>
    </footer>

</body>

</html>