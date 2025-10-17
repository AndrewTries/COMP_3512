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
    echo "<div class='overflow-x-auto'>";
    echo "<div class='grid grid-cols-6 min-w-[550px]'>";
    foreach ($history as $id => $arr) {
        foreach ($arr as $name => $item) {
            if ($name != 'id' && $name != 'symbol')
                echo "<div><h3>" . htmlspecialchars(ucfirst($name))   . "</h3></div>";
        }
        break;
    }
    echo "</div>";
    echo "<div class=' overflow-y-auto max-h-[50vh] min-w-[550px]'>";
    echo "<div class='grid grid-cols-6'>";
    foreach ($history as $id => $arr) {
        foreach ($arr as $name => $item) {
            if ($name != 'id' && $name != 'symbol') {
                echo "<div class='border-b border-gray-300 py-2'>";
                if ($name == 'open' || $name == 'close' || $name == 'high' || $name == 'low')
                    echo "$" . number_format($item, 2);
                else echo htmlspecialchars($item);
                echo "</div>";
            }
        }
    }
    echo "</div>";
    echo "</div>";
    echo "</div>";
}

function output3Year($fin)
{
    echo "<div class='overflow-x-auto'>";
    echo "<div class='grid grid-cols-[12%_22%_22%_22%_22%] min-w-[500px]'>";
    foreach ($fin as $name => $item) {
        echo "<div><h3>" . htmlspecialchars(ucfirst($name))   . "</h3></div>";
        $t = count($item);
    }
    $i = 0;
    echo "</div>";
    echo "<div class='grid grid-cols-[12%_22%_22%_22%_22%] min-w-[500px]'>";
    while ($i < $t) {
        foreach ($fin as $name => $item) {
            echo "<div class='border-b border-gray-300 py-2'>";
            if ($name != 'years') echo "$" . number_format($item[$i]);
            else echo $item[$i];
            echo "</div>";
        }
        $i++;
    }
    echo "</div>";
    echo "</div>";
}

function outputCards($historyMax, $historyLow, $totalVolume, $averageVolume)
{
    for ($i = 0; $i <= 3; $i++) {
        echo "<div class='border-0 rounded-sm p-2 px-8 py-4 mb-5 bg-teal-300 text-center hover:bg-teal-300/80 hover:text-teal-100 hover:shadow-2xl'>";
        if ($i == 0) echo "<h3>History High</h3>";
        else if ($i == 1) echo "<h3>History Low</h3>";
        else if ($i == 2) echo "<h3>Total Volume</h3>";
        else echo "<h3>Average Volume</h3>";
        echo "<div class='text-3xl md:text-4xl lg:text-5xl text-gray-700'>";
        if ($i == 0) echo "$" . number_format(current(current($historyMax)), 2) . "<br>";
        else if ($i == 1) echo "$" . number_format(current(current($historyLow)), 2) . "<br>";
        else if ($i == 2) echo number_format(current(current($totalVolume)), 2) . "<br>";
        else echo "$" . number_format(current(current($averageVolume)), 2) . "<br>";
        echo "</div>";
        echo "</div>";
    }
}