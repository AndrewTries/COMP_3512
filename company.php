<?php
include 'includes/config.inc.php';
include 'includes/index.inc.php';
include 'includes/nav.inc.php';
include 'includes/company-helper.inc.php';

try {
    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
    if (isset($_GET['symbol']) && $_GET['symbol'] != null) {
        $companyGateway = new CompanyDB($conn);
        $companies = $companyGateway->getAllForCompany($_GET['symbol']);
        $historyGateway = new HistoryDB($conn);
        $history = $historyGateway->getAllForHistory($_GET['symbol']);
        $historyMax = $historyGateway->getMaxofHistoryHigh($_GET['symbol']);
        $historyLow = $historyGateway->getMinofHistoryLow($_GET['symbol']);
        $totalVolume = $historyGateway->getTotalofHistoryVolume($_GET['symbol']);
        $averageVolume = $historyGateway->getAverageofHistoryVolume($_GET['symbol']);
    } else {
        $companies = null;
        $history = null;
        $historyMax = null;
        $historyLow = null;
        $totalVolume = null;
        $averageVolume = null;
    }
} catch (Exception $e) {
    die($e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Portfolio Project</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css" />
</head>

<body>
    <div class="flex min-h-screen w-full flex-col bg-background">
        <header></header>
        <?= nav(); ?>
        <main class="flex-grow">
            <div class="grid grid-cols-2 p-5">
                <div class="">
                    <section >
                        <h1 class="text-xl font-bold">Company Info</h1>
                        <?php
                        foreach ($companies as $row) {
                            echo "<h3 class= text-2xl>" . $row['name'] . " (" . $row['symbol'] . ")</h3>";
                            echo $row['description'] . "<br>";
                            echo $row['sector'] . "<br>";
                            echo $row['subindustry'] . "<br>";
                            echo "Address: " . $row['address'] . "<br>";
                            echo "Listed on exchange: " . $row['exchange'] . "<br>";
                            echo "<a class='underline text-sky-500' href = '" . $row['website'] . "'>Company Website</a>";
                        }
                        ?>
                    </section>
                </div>
                <div>
                    <section>
                        <div class="bg-teal-50 px-3 border-1 rounded-md">
                        <h2 class="text-lg font-bold text-center my-3">3 Year History</h2>
                        <div class='hidden md:block'>
                            <div class="overflow-auto grid md:grid-cols-6 border-b-1">
                                <?php output3Year($history); ?>
                            </div>
                            <div>
                                <p class='text-center py-2'>
                                    <?php
                                    if (isset($_GET['userid']) && $_GET['userid'] != null)
                                        echo "Select a company symbol for more information.";
                                    else echo "Please choose a user portfolio";
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div class='block md:hidden'>
                            <?php 
                            // outputHistoryCards($history); 
                            ?>
                        </div>
                        <?php
                        //     foreach ($companies as $row) {

                        //     $fin = json_decode($row['financials']);
                        //     echo "<div class='bg-teal-50 px-3 border-1 rounded-md'>";
                        //     if ($row['financials'] != null) {
                        //         echo "<table><tr>";
                        //         foreach ($fin as $name => $item) {
                        //             echo "<th>" . ucfirst($name) . "</th>";
                        //             $t = count($item);
                        //         }
                        //         $i = 0;
                        //         while ($i < $t) {
                        //             echo "<tr>";
                        //             foreach ($fin as $name => $item) {
                        //                 if ($name != 'years') echo "<td>$" . number_format($item[$i]) . "</td>";
                        //                 else echo "<td>" . $item[$i] . "</td>";
                        //             }
                        //             echo "</tr>";
                        //             $i++;
                        //         }
                        //         echo "</tr><tr>";
                        //         echo "</table>";
                        //     } else echo "<p>No Financial Data Availible</p>";
                        //     echo "</div>";
                        // }
                        ?>
                    </section>
                </div>
                <div>
                    <section>
                        <div>
                            <?php
                            if ($history != null) { ?>
                                <div class="bg-teal-50 px-3 border-1 rounded-md">
                                    <h2 class="text-lg font-bold text-center my-3">Detailed History</h2>
                                    <div class='hidden md:block'>
                                        <div class="overflow-auto grid md:grid-cols-6 border-b-1">
                                            <?php outputHistoryTable($history); ?>
                                        </div>
                                        <div>
                                            <p class='text-center py-2'>
                                                <?php
                                                if (isset($_GET['userid']) && $_GET['userid'] != null)
                                                    echo "Select a company symbol for more information.";
                                                else echo "Please choose a user portfolio";
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class='block md:hidden'>
                                        <?php 
                                        // outputHistoryCards($history); 
                                        ?>
                                    </div>
                                <?php
                            } ?>
                                </div>
                        </div>
                        <?php

                        // // echo "<pre>";
                        // // print_r($history);
                        // // echo "</pre>";

                        // echo "<table><tr>";
                        // foreach($history as $id=> $arr){
                        //     foreach($arr as $name=> $item){
                        //         if($name !='id' && $name !='symbol') {
                        //             echo "<th>" . ucfirst($name)   . "</th>";
                        //         }
                        //     }
                        //     break;
                        // }
                        // echo "</tr>";

                        // foreach($history as $id=> $arr){
                        //     echo "<tr>";
                        //     foreach($arr as $name=> $item){
                        //         if($name !='id' && $name !='symbol') {
                        //             if($name == 'open' || $name == 'close' || $name == 'high' || $name == 'low') 
                        //                 echo "<td>$" . number_format($item, '2') . "</td>";
                        //             else echo "<td>" . $item . "</td>";
                        //         }
                        //     }
                        //     echo "</tr>";
                        // }
                        // echo "</tr></table>";
                        ?>
                    </section>
                </div>
                <div>
                    <section>
                        <div class='hidden md:block'>
                        <?php
                        // echo "<pre>";                
                        // echo print_r($historyMax);
                        // echo "</pre>";
                        // foreach($historyMax as $id=> $arr){
                        //         foreach($arr as $name=> $item){
                        //             echo $item;
                        //         }
                        //     }
                        echo "<div class='bg-teal-50 px-3 border-1 rounded-md'>";
                        echo "<h3>History High</h3>";
                        echo "$" . number_format(current(current($historyMax)), 2) . "<br>";
                        echo "</div>";

                        echo "<div class='bg-teal-50 px-3 border-1 rounded-md'>";
                        echo "<h3>History Low</h3>";
                        echo "$" . number_format(current(current($historyLow)), 2) . "<br>";
                        echo "</div>";

                        echo "<div class='bg-teal-50 px-3 border-1 rounded-md'>";
                        echo "<h3>Total Volume</h3>";
                        echo number_format(current(current($totalVolume)), 2) . "<br>";
                        echo "</div>";

                        echo "<div class='bg-teal-50 px-3 border-1 rounded-md'>";
                        echo "<h3>Average Volume</h3>";
                        echo number_format(current(current($averageVolume)), 2) . "<br>";
                        echo "</div>";
                        ?>
                        </div>
                    </section>
                </div>
            </div>
        </main>
        <?php footer(); ?>
    </div>
</body>

</html>