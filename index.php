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
        $portfolio = $portfolioGateway->getAllForPortfolio($_GET['userid']);
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
<div class="flex min-h-screen w-full flex-col bg-background">
<header></header>
<?= nav(); ?>
    <main class="flex-grow">
        <div class="grid grid-cols-[30%_70%]">
        <div>
        <section class="bg-teal-50 mx-10 px-3 pb-4 border-1 ">
            <h2 class="text-lg font-bold my-3 text-center place-items-center">Customers</h2>
            <div class='grid grid-cols-2 gap-6'>
                <?php
                    outputAllUsers($users);
                ?>
            </div>
        </section>
        </div>
        <div>
        <!-- <?php echo "<pre>";
        print_r($portfolioValue);
        echo "</pre>";?> -->
        <section class="border-1 mx-4">
            <div>
                <?php if($portfolio!= null) {?>
                <h2 class="text-lg font-bold text-center ">Portfolio Summary</h2>
                <div class="flex flex-wrap gap-y-3 md:text-center md:gap-x-10 justify-center p-4 ">
                <?php
                    outputCards($portfolioCount, $portfolioShareCount, $portfolioValue);
                ?>
                </div>
                <div class="px-3">
                <h2 class="text-lg font-bold text-center my-3">Portfolio Details</h2>
                <div class="grid grid-cols-[15%_25%_25%_15%_20%] border-b-1">
                <?php
                    foreach($portfolio as $id=> $arr){
                        foreach($arr as $name=> $item){
                            echo "<div><h3>" . ucfirst($name)   . "</h3></div>";
                        }
                        break;
                    }
                    foreach($portfolio as $id=> $arr){
                        
                        foreach($arr as $name=> $item){
                            echo "<div class='border-b border-gray-300 py-2'>";
                            if($name == 'symbol') echo "<div class='underline'><a href='company.php?symbol=" . $item . "'>$" . $item . "</a></div>";
                            else if($name == 'value') echo "<div>$" . number_format($item, 2) . "</div>";
                            else echo "<div>" . $item . "</div>";
                            echo "</div>";
                        }
                        
                    }
                    // echo "<table class='px-4'>";
                    // foreach($portfolio as $id=> $arr){
                    //     echo "<tr>";
                    //     foreach($arr as $name=> $item){
                    //         echo "<th>" . ucfirst($name)   . "</th>";
                    //     }
                    //     echo "</tr>";
                    //     break;
                    // }
                    // foreach($portfolio as $id=> $arr){
                    //     echo "<tr>";
                    //     foreach($arr as $name=> $item){
                    //         if($name == 'symbol') echo "<td><a href='company.php?symbol=" . $item . "'>$" . $item . "</a></td>";
                    //         else if($name == 'value') echo "<td>$" . number_format($item, 2) . "</td>";
                    //         else echo "<td>" . $item . "</td>";
                    //     }
                    //     echo "</tr>";
                    // }
                    // echo "</tr></table>";
                } else?> 
                </div>
                <div><p class='text-center py-2'>
                    <?php 
                    if (isset($_GET['userid']) && $_GET['userid'] !=null)
                        echo "Select a company symbol for more information.";
                    else echo "Please choose a user portfolio"; 
                    ?>
                </p></div>
                </div>
            </div>  
        </section>
            </div>
            </div>
    </main>
    <div class="mt-4 bg-background py-6 text-center text-sm ">
                &copy; 2025 Portfolio Project. All rights reserved.
    </div>
</div>
</body>
</html>
