<?php
    include 'includes/config.inc.php';
    include 'includes/index.inc.php';
    include 'includes/nav.inc.php';
    include 'includes/index-helper.inc.php';

    try {
        $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
        $userGateway = new UserDB($conn);
        $users = $userGateway->getAll();
        if(isset($_GET['userid']) && $_GET['userid'] != null) {
            $portfolioGateway = new PortfolioDB($conn);
            $portfolio = $portfolioGateway->getPortfolioTable($_GET['userid']);
            $portfolioCount = $portfolioGateway->getPortfolioCount($_GET['userid']);
            $portfolioShareCount = $portfolioGateway->getShareCount($_GET['userid']);
            $portfolioValue = $portfolioGateway->getTotalValue($_GET['userid']);
        } else {
            $portfolio = null;
            $history = null;
            $portfolioCount = null;
            $portfolioShareCount = null;
            $portfolioValue = null;
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
    <?= nav(); ?>
</header>
    <main>
        <section class="left-panel">
            <h2>Customers</h2>
            <div>
                <?php
                    outputAllUsers($users);
                ?>
            </div>
        </section>
        <!-- <?php echo "<pre>";
        print_r($portfolioValue);
        echo "</pre>";?> -->
        <section class="right-panel">
            <div>
                <?php if($portfolio!= null) {?>
                <h2>Portfolio Summary</h2>
                <?php
                    echo "<h3>Companies</h3>";
                    echo current(current($portfolioCount)) . "<br>";
                    echo "<h3># Shares</h3>";
                    echo current(current($portfolioShareCount)). "<br>";
                    echo "<h3>Total Value</h3>";
                    echo "$" . number_format(current(current($portfolioValue)), 2) . "<br>";
                ?>
                <h2>Portfolio Details</h2>
                <?php
                    echo "<table><tr>";
                    foreach($portfolio as $id=> $arr){
                        foreach($arr as $name=> $item){
                            echo "<th>" . ucfirst($name)   . "</th>";
                        }
                        break;
                    }
                    echo "</tr>";

                    
                    foreach($portfolio as $id=> $arr){
                        echo "<tr>";
                        foreach($arr as $name=> $item){
                            if($name == 'symbol') echo "<td><a href='company.php?symbol=" . $item . "'>$" . $item . "</a></td>";
                            else if($name == 'value') echo "<td>$" . number_format($item, 2) . "</td>";
                            else echo "<td>" . $item . "</td>";
                        }
                        echo "</tr>";
                    }
                    echo "</tr></table>";
                } else?> <p>Please choose a user portfolio</p>
            </div>  
        </section>
    </main>
</body>
</html>
