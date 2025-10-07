<?php

    function outputSingleCompany($row){
        echo "<div class='company'><p>" . $row['symbol'] . ", " . $row['name'] . "</p></div>";
        echo "<tr>
                <td>" . $row['symbol'] . "</td>
                <td>" . $row['name'] . "</td>
                <td>" . $row['sector'] . "</td>
                <td>" . $row['amount'] . "</td>
                <td>" . $row['value'] . "</td></tr>";
    }
    function outputAllCompanies($conn){
        echo "<table>";
        echo "<tr>
            <th>Symbol</th>
            <th>Name</th>
            <th>Sector</th>
            <th>Amount</th>
            <th>Value</th>
            </tr>";
        foreach($conn as $row) outputSingleCompany($row);
        echo "</table>";
    }
?>