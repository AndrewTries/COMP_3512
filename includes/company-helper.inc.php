<?php

function outputSingleCompany($row)
{
    echo "<div class='company'><p>" . $row['symbol'] . ", " . $row['name'] . "</p></div>";
    echo "<tr>
                <td>" . $row['symbol'] . "</td>
                <td>" . $row['name'] . "</td>
                <td>" . $row['sector'] . "</td>
                <td>" . $row['amount'] . "</td>
                <td>" . $row['value'] . "</td></tr>";
}
function outputAllCompanies($conn)
{
    echo "<table>";
    echo "<tr>
            <th>Symbol</th>
            <th>Name</th>
            <th>Sector</th>
            <th>Amount</th>
            <th>Value</th>
            </tr>";
    foreach ($conn as $row) outputSingleCompany($row);
    echo "</table>";
}

function outputHistoryTable($history)
{
    foreach ($history as $id => $arr) {
        foreach ($arr as $name => $item) {
            if ($name != 'id' && $name != 'symbol') 
            echo "<div><h3>" . htmlspecialchars(ucfirst($name))   . "</h3></div>";
        }
        break;
    }
    foreach ($history as $id => $arr) {
        foreach ($arr as $name => $item) {
            if ($name != 'id' && $name != 'symbol') {
                echo "<div class='border-b border-gray-300 py-2'>";
                if ($name == 'open' || $name == 'close' || $name == 'high' || $name == 'low')
                    echo "<div>$" . number_format($item, 2) . "</div>";
                else echo "<div>" . htmlspecialchars($item) . "</div>";
                echo "</div>";
            }
        }
    }
}

function output3Year($history) {
    foreach ($history as $id => $arr) {
        foreach ($arr as $name => $item) {
            if ($name != 'id' && $name != 'symbol') 
            echo "<div><h3>" . htmlspecialchars(ucfirst($name))   . "</h3></div>";
        }
        break;
    }
    foreach ($history as $id => $arr) {
        foreach ($arr as $name => $item) {
            if ($name != 'id' && $name != 'symbol') {
                echo "<div class='border-b border-gray-300 py-2'>";
                if ($name == 'open' || $name == 'close' || $name == 'high' || $name == 'low')
                    echo "<div>$" . number_format($item, 2) . "</div>";
                else echo "<div>" . htmlspecialchars($item) . "</div>";
                echo "</div>";
            }
        }
    }
}
