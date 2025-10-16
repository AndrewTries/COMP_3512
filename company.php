<?php
    include 'includes/config.inc.php';
    include 'includes/index.inc.php';
    include 'includes/nav.inc.php';
    // include 'includes/index-helper.inc.php';

    try {
        $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
        if(isset($_GET['symbol']) && $_GET['symbol'] != null) {
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
    } catch(Exception $e) {
        die($e->getMessage());
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>  
    <title>Portfolio Project</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
<header>
   
</header>
 <?= nav(); ?>
    <main>
        <div class="container">
        <section class="top"> 
            <h1>Company Info</h1>
            <?php
            foreach($companies as $row) {
                echo $row['name'] . " (" . $row['symbol'] . ")<br>";
                echo $row['description'] . "<br>";
                echo $row['sector'] . "<br>";
                echo $row['subindustry'] . "<br>"; 
                echo "Address: " .$row['address'] . "<br>";
                echo $row['exchange'] . "<br>";
                echo "<a href = '" . $row['website'] . "'>Company Website</a>";
                // echo $row['financials'];

                $fin = json_decode($row['financials']);

                if($row['financials'] != null) {echo "<table><tr>";
                foreach($fin as $name => $item) {
                    echo "<th>" . ucfirst($name) . "</th>";
                    $t = count($item);
                }
                $i=0;
                while($i<$t){
                    echo "<tr>";
                    foreach($fin as $name => $item) {
                        if($name != 'years') echo "<td>$" . number_format($item[$i]) . "</td>";
                        else echo "<td>" . $item[$i] . "</td>";
                    }
                    echo "</tr>";
                    $i++;
                }
                echo "</tr><tr>";
                echo "</table>";
            } else echo "<p>No Financial Data Availible</p>";
             // foreach($fin as $name => $item) {
                //     $i = 0;
                //     echo "<br><strong>" . $name . "</strong><br>";
                //     foreach($item as $it) {
                //         $i++;
                //         echo $it;
                //         if($i<count($item)) echo ", ";
                //     }
                // }
            } 
        ?>
        </section>
        <section class="left">
        <?php
            // echo "<pre>";
            // print_r($history);
            // echo "</pre>";

            echo "<table><tr>";
            foreach($history as $id=> $arr){
                foreach($arr as $name=> $item){
                    if($name !='id' && $name !='symbol') {
                        echo "<th>" . ucfirst($name)   . "</th>";
                    }
                }
                break;
            }
            echo "</tr>";

            foreach($history as $id=> $arr){
                echo "<tr>";
                foreach($arr as $name=> $item){
                    if($name !='id' && $name !='symbol') {
                        if($name == 'open' || $name == 'close' || $name == 'high' || $name == 'low') 
                            echo "<td>$" . number_format($item, '2') . "</td>";
                        else echo "<td>" . $item . "</td>";
                    }
                }
                echo "</tr>";
            }
            echo "</tr></table>";
        ?>
        </section>
        <section class="right">
            <?php 
                // echo "<pre>";                
                // echo print_r($historyMax);
                // echo "</pre>";
                // foreach($historyMax as $id=> $arr){
                //         foreach($arr as $name=> $item){
                //             echo $item;
                //         }
                //     }
                echo "<h3>History High</h3>";
                echo "$" . number_format(current(current($historyMax)), 2) . "<br>";
                echo "<h3>History Low</h3>";
                echo "$" . number_format(current(current($historyLow)), 2) . "<br>";
                echo "<h3>Total Volume</h3>";
                echo number_format(current(current($totalVolume)), 2) . "<br>";
                echo "<h3>Average Volume</h3>";
                echo number_format(current(current($averageVolume)), 2) . "<br>";
            ?>
        </section>
        </div>

    </main>
</body>
</html>
