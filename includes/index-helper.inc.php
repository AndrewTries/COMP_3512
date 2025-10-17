<?php
function outputSingleUser($row)
{
    echo "<div><p>" . htmlspecialchars($row['lastname']) . ", " . htmlspecialchars($row['firstname']) . "</p></div>";
    echo "<div><form method='get' action='" . htmlspecialchars($_SERVER['REQUEST_URI']) . "'>";
    echo " <button class='border-2 rounded-md px-1 cursor-pointer type='submit' name='userid' value=" . $row['id'] . ">Portfolio</button>";
    echo "</form></div>";
}

function outputSingleUser2($row)
{
    echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['lastname']) . ", " . htmlspecialchars($row['firstname']) . "</option>";
}

function outputAllUsersList($users)
{
    echo "<div class='m-2'><form method='get' action='" . htmlspecialchars($_SERVER['PHP_SELF']) . "'>";
    echo "<label for='users'>Select a portfolio:</label>";
    echo "<select name='userid' id='users' onchange='this.form.submit()' class='px-2 w-1/1'>";
    echo "<option value=''>--select--</option>";
    foreach ($users as $row) outputSingleUser2($row);
    echo "</select>";
    echo "</form>";
    echo "</div>";
}

// function outputPortfolioItem($row)
// {
//     echo "<tr class='bg-white border-2 rounded-md dark:bg-gray-800 dark:border-gray-700 border-gray-200'>
//                 <td class='p-20 px-6 py-4'>" . $row['symbol'] . "</td>
//                 <td class='mx-4'>" . $row['name'] . "</td>
//                 <td class='mx-4'>" . $row['sector'] . "</td>
//                 <td class='mx-4'>" . $row['amount'] . "</td>
//                 <td class='mx-4'>" . $row['value'] . "</td></tr>";
// }

function outputAllUsers($users)
{
    foreach ($users as $row) outputSingleUser($row);
}

function outputCards($portfolioCount, $portfolioShareCount, $portfolioValue)
{
    for ($i = 0; $i <= 2; $i++) {
        echo "<div class='border-0 rounded-sm p-2 px-7 py-4 bg-teal-300 text-center hover:bg-teal-300/80 hover:text-teal-100 hover:shadow-2xl'>";
        if ($i == 0) echo "<h3>Companies</h3>";
        else if ($i == 1) echo "<h3># Shares</h3>";
        else echo "<h3>Total Value</h3>";
        echo "<div class='text-3xl md:text-4xl lg:text-5xl xl:text-6xl text-gray-700'>";
        if ($i == 0) echo current(current($portfolioCount)) . "<br>";
        else if ($i == 1) echo current(current($portfolioShareCount)) . "<br>";
        else echo "$" . number_format(current(current($portfolioValue)), 2) . "<br>";
        echo "</div>";
        echo "</div>";
    }
}

function outputPortfolioTable($portfolio)
{
    echo "<div class='grid md:grid-cols-[15%_25%_25%_15%_20%]'>";
    foreach ($portfolio as $id => $arr) {
        foreach ($arr as $name => $item) {
            echo "<div ><h3 class='border-b-1'>" . htmlspecialchars(ucfirst($name))   . "</h3></div>";
        }
        break;
    }
    echo "</div>";
    echo "<div class=' overflow-y-auto max-h-[50vh]'>";
    echo "<div class='grid md:grid-cols-[15%_25%_25%_15%_20%]'>";
    foreach ($portfolio as $id => $arr) {

        foreach ($arr as $name => $item) {
            $clearedItem = htmlspecialchars($item);
            echo "<div class='border-b border-gray-300 py-2'>";
            if ($name == 'symbol') echo "<div class='underline'><a href='company.php?symbol=" . $clearedItem . "'>$" . $clearedItem . "</a></div>";
            else if ($name == 'value') echo "<div>$" . number_format($item, 2) . "</div>";
            else echo "<div>" . $clearedItem . "</div>";
            echo "</div>";
        }
    }
    echo "</div>";
    echo "</div>";
}

function outputPortfolioCards($portfolio)
{
    foreach ($portfolio as $id => $arr) {
        echo "<div class='border border-gray-300 rounded-lg text-center my-2'>";

        if (isset($arr['name'])) echo "<div class='bg-nav w-full text-white py-1 rounded-t-lg'>" . htmlspecialchars($arr['name']) . "</div>";
        echo "<div class='px-4 pb-4 pt-2'>";
        if (isset($arr['value'])) echo "<h3 class='text-lg'> $" . number_format($arr['value'], 2) . "</h3>";

        if (isset($arr['amount'])) echo "<p>Amount: " . htmlspecialchars($arr['amount']) . "</p>";

        if (isset($arr['sector'])) echo "<p>Sector: " . htmlspecialchars($arr['sector']) . "</p>";

        if (isset($arr['symbol'])) echo "<button class='mt-2 bg-nav text-white rounded-lg px-2 underline 
        hover:bg-teal-300/80 hover:text-teal-100 hover:shadow-xl'>
        <a href='company.php?symbol=" . htmlspecialchars($arr['symbol']) . "'>$" . htmlspecialchars($arr['symbol']) . "</a></button>";
        echo "</div>";
        echo "</div>";
    }
}
