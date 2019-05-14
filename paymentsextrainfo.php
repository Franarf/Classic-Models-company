<!DOCTYPE html>
<meta charset=utf-8>
<html>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>

    <?php

    require 'dbconfig.php';
    //associate the id to the variables
    $id = $_GET['id'];
    $customer_id = $_GET['id'];
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        //PDO mode set to exeption
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //first table with customer dettails
        $stmt = $conn->query("SELECT  payments.checkNumber, payments.paymentDate,  payments.amount FROM customers, payments WHERE customers.customerNumber = payments.customerNumber and payments.customerNumber = '$customer_id'");
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        //second table with payments for that customer
        $stmtpayment = $conn->query("SELECT C.customerName, C.phone, C.salesRepEmployeeNumber, C.creditLimit  FROM customers as C, payments as P WHERE C.customerNumber = P.customerNumber and P.customerNumber = '$customer_id'");
        $stmtpayment->setFetchMode(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    //displays the customer number when opening extra info
    echo "<h3>Customer number: " . $id . "</h3>";
    $row = $stmtpayment->fetch();

    echo "<table id=table1 class='table' style='border: solid 1px black;'>";
    echo "<tr><th>Name</th><th>Phone</th><th>Sales rep. Number</th><th>Credit Limit</th></tr>";
    echo "<td>" . $row['customerName'] . "</td><td>" . $row['phone'] . "</td><td>" . $row['salesRepEmployeeNumber'] . "</td><td>" . $row['creditLimit'] . "</td>";
    echo "</table>";

    echo "<table id=table2 class='table' style='border: solid 1px black'>";
    echo "<tr><th>Check Number</th><th>Payment Date</th><th>Payment History</th></tr>";
    //set counter
    $sumtotal = 0;
    while ($row = $stmt->fetch()) {

        echo "<tr>";
        echo    "<td>" . $row['checkNumber'] . "</td>";
        echo    "<td>" . $row['paymentDate'] . "</td>";
        echo    "<td>" . $row['amount'] . "</td>";
        echo    "<td class=\"btn\" id=\"payback\"><a href='payments.php'><button class=\"btn2\">back</a></td></tr>";
        //set total adding to the counter
        $sumtotal += $row['amount'];
    }
    echo "<td id=sumtotal colspan=2 style='text-align:right'>Total:</td><td>" . $sumtotal . "</td>";

    echo "</table>";
    $conn = null;
    ?>


    <footer>
        <?php include 'footer.php'; ?>
    </footer>

</body>

</html>