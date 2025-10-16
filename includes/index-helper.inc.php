<?php
    function outputSingleUser($row){
        // echo "<tr><td>" . $row['lastname'] . ", " . $row['firstname'] . "</td><td><button>Portfolio</button></td></tr>";
        echo "<div><p>" . $row['lastname'] . ", " . $row['firstname'] . "</p></div>";
        echo "<div><form method='get' action='" . htmlspecialchars($_SERVER['REQUEST_URI']) . "'>";
        echo " <button class='border-2 rounded-md px-1 cursor-pointer type='submit' name='userid' value=" . $row['id'] . ">Portfolio</button>";
        echo "</form></div>";
    }

    function outputPortfolioItem($row){
        // echo "<div class='px-20'><p>" . $row['symbol'] . ", " . $row['name'] . "</p></div>";
        echo "<tr class='bg-white border-2 rounded-md dark:bg-gray-800 dark:border-gray-700 border-gray-200'>
                <td class='p-20 px-6 py-4'>" . $row['symbol'] . "</td>
                <td class='mx-4'>" . $row['name'] . "</td>
                <td class='mx-4'>" . $row['sector'] . "</td>
                <td class='mx-4'>" . $row['amount'] . "</td>
                <td class='mx-4'>" . $row['value'] . "</td></tr>";
    }

    function outputAllUsers($users){
        // echo "<table>";
        // echo "<tr><th colspan='1'>Name</th></tr>";
        foreach($users as $row) outputSingleUser($row);
        // echo "</table>";
    }

    // function outputPortfolio($conn){
    //     echo "<table class='table-auto w-full border-collapse'>";
    //     echo "<tr px-4>
    //         <th>Symbol</th>
    //         <th>Name</th>
    //         <th>Sector</th>
    //         <th>Amount</th>
    //         <th>Value</th>
    //         </tr>";
    //     foreach($conn as $row) outputSingleUser($row);
    //     echo "</table>";
    // }

    function outputCards($portfolioCount, $portfolioShareCount, $portfolioValue) {
        for($i=0; $i<=2; $i++){
            echo "<div class='border-0 rounded-sm p-2 px-8 py-4 bg-teal-300 hover:bg-teal-300/80 hover:text-teal-100 hover:shadow-2xl'>";
            if($i==0) echo "<h3>Companies</h3>";
            else if($i==1) echo "<h3># Shares</h3>";
            else echo "<h3>Total Value</h3>";
            echo "<div class='md:text-6xl text-gray-700'>";
            if($i==0) echo current(current($portfolioCount)) . "<br>";
            else if($i==1) echo current(current($portfolioShareCount)). "<br>";
            else echo "$" . number_format(current(current($portfolioValue)), 2) . "<br>";
            echo "</div>";
            echo "</div>";
        }
    }
?>