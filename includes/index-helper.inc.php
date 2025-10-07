<?php
    function outputSingleUser($row){
        // echo "<tr><td>" . $row['lastname'] . ", " . $row['firstname'] . "</td><td><button>Portfolio</button></td></tr>";
        echo "<div class='customer'><p>" . $row['lastname'] . ", " . $row['firstname'] . "</p>";
        echo "<form method='get' action='" . $_SERVER['REQUEST_URI'] . "'>";
        echo "<button type='submit' name='userid' value=" . $row['id'] . ">Portfolio</button>";
        echo "</form></div>";
    }

    function outputPortfolioItem($row){
        echo "<div class='company'><p>" . $row['symbol'] . ", " . $row['name'] . "</p></div>";
        echo "<tr>
                <td>" . $row['symbol'] . "</td>
                <td>" . $row['name'] . "</td>
                <td>" . $row['sector'] . "</td>
                <td>" . $row['amount'] . "</td>
                <td>" . $row['value'] . "</td></tr>";
    }

    function outputAllUsers($conn){
        // echo "<table>";
        // echo "<tr><th colspan='1'>Name</th></tr>";
        foreach($conn as $row) outputSingleUser($row);
        // echo "</table>";
    }

    function outputPortfolio($conn){
        echo "<table>";
        echo "<tr>
            <th>Symbol</th>
            <th>Name</th>
            <th>Sector</th>
            <th>Amount</th>
            <th>Value</th>
            </tr>";
        foreach($conn as $row) outputSingleUser($row);
        echo "</table>";
    }
?>