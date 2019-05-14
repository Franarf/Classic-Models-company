<!DOCTYPE html>
<meta charset=utf-8>
<html>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>

    <!--https://www.w3schools.com/tags/att_option_value.asp-->
    <!--dropdown list type  -->
    <div class="dropdown">
        <form method="post" action="">
            <select name="listvalues" class="dropdown-select">
                <option selected disable hidden>Select number of row</option>
                <option value="20">20</option>
                <option value="40">40</option>
                <option value="60">60</option>
            </select>
            <input id="input-box" type="submit" name="submit" />
        </form>
    </div>

    <?php
    require 'dbconfig.php';

    //https://www.w3resource.com/php/function-reference/isset.php
    //isset method to check if a variable is set
    if (!(isset($_POST['listvalues']))) {
        $valueList = 20;
    } else {
        $valueList = $_POST['listvalues'];
    }

    echo "<table class='table' style='border: solid 1px black;'>";
    echo "<tr><th>Customer Number</th><th>Check Number</th><th>Amount</th><th>Payment Date</th><th>Extra Info</th></tr>";


    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        //PDO mode set to exeption
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->query("SELECT customerNumber, checknumber, amount, paymentDate FROM payments");

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    //iterates through the table
    $i = 1;
    while ($row = $stmt->fetch()) {
        if ($i <= $valueList) {
            echo "<tr>";
            echo    "<td>" . $row['customerNumber'] . "</td>";
            echo    "<td>" . $row['checknumber'] . "</td>";
            echo    "<td>" . $row['amount'] . "</td>";
            echo    "<td>" . $row['paymentDate'] . "</td>";
            echo    "<td class=\"btn\"><a href='paymentsextrainfo.php?id=" . $row['customerNumber'] . "'>" . $row['customerNumber'] . "</a></td>";
        }
        $i++;
    }
    echo "</table>";
    $conn = null;
    ?>


    <footer>
        <?php include 'footer.php'; ?>
    </footer>

</body>
<link rel="stylesheet" type="text/css" href="style.css">

</html>