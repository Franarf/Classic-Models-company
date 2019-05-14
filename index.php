<!DOCTYPE html>
<meta charset=utf-8>
<html>

<body>
    <header>
        <!--            calls the header-->
        <?php include 'header.php'; ?>
    </header>



    <?php
    // creates a table with specific columns
    echo "<table class='table' style='border: solid 1px black;'>";
    echo "<tr><th style='width:50px'>Product Line</th><th>Description</th></tr>";
    //Iterates through the items
    class TableRows extends RecursiveIteratorIterator
    {
        function __construct($it)
        {
            parent::__construct($it, self::LEAVES_ONLY);
        }

        function current()
        {
            return "<td border:1px solid black;'>" . parent::current() . "</td>";
        }

        function beginChildren()
        {
            echo "<tr>";
        }

        function endChildren()
        {

            echo "</tr>" . "\n";
        }
    }
    // requests the dbconfig data to connect
    require 'dbconfig.php';
    // sets the connection and performs the query to the database
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT productLine, textDescription FROM productlines");
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        foreach (new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k => $v) {
            echo $v;
        }
    }
    //catches the error type
    catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
    echo "</table>";
    ?>


    <footer>
        <!--            recalls the footer-->
        <?php include 'footer.php'; ?>
    </footer>
</body>
<link rel="stylesheet" type="text/css" href="style.css">

</html>


<!--
Francesco Ensoli 
To whom it may interest:

All the files were stored in the XAMPP folder 'htdocs'.

The site is divided into several pages:
index.php, 'offices.php' (that is connected to officesextrainfo.php), payments.php (that connects to paymentsextrainfo.php).

There is a 'Header.php', a 'Footer.php' as well as a 'Dbconfig.php' page that are re-called on every other page for respectively loading the header, footer and connections infos.
As well as a style.css page for styling the site.



There are links as comments within the code for specific tasks
The more important operations to connect and retrive data where taken from these pages:
https://www.w3schools.com/php/php_mysql_connect.asp
https://www.w3schools.com/php/php_mysql_select.asp

-->