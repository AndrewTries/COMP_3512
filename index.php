<?php
include 'includes/config.inc.php';
include 'includes/index.inc.php';
include 'includes/nav.inc.php';
include 'includes/index-helper.inc.php';

try {
    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
    $userGateway = new UserDB($conn);
    $users = $userGateway->getAll();
    if (isset($_GET['userid']) && $_GET['userid'] != null) {
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
            <div class="grid grid-cols-[30%_70%] p-5">
                <div>
                    <section class="bg-teal-50 md:mr-10 md:px-3 md:pb-4 border-1 rounded-md">
                        <h2 class="text-lg font-bold my-3 text-center place-items-center">Customers</h2>
                        <div class='hidden md:block'>
                        <div class='grid grid-cols-2 gap-6'>
                            <?php
                            outputAllUsers($users);
                            ?>
                            
                        </div>
                        </div>
                        <div class='block md:hidden'>
                            <?php
                            outputAllUsersList($users);
                            ?>
                        </div>
                    </section>
                </div>
                <div>
                    <section>
                        <div>
                            <?php
                            if ($portfolio != null) { ?>
                                <div class="bg-teal-50 mb-1 border-1 rounded-md">
                                    <h2 class="text-lg font-bold text-center ">Portfolio Summary</h2>
                                    <div class="flex flex-col gap-y-3 md:flex-row sm:flex-wrap md:text-center md:gap-x-3 justify-center p-4 ">
                                        <?php
                                        outputCards($portfolioCount, $portfolioShareCount, $portfolioValue);
                                        ?>
                                    </div>
                                </div>
                                <div class="bg-teal-50 px-3 border-1 rounded-md">
                                    <h2 class="text-lg font-bold text-center my-3">Portfolio Details</h2>
                                    <div class='hidden md:block'>
                                        <div class="overflow-auto grid md:grid-cols-[15%_25%_25%_15%_20%] border-b-1">
                                            <?php outputPortfolioTable($portfolio); ?>
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
                                        <p class='text-center pb-2'>
                                            Select a company symbol for more information.
                                        </p>
                                        <?php outputPortfolioCards($portfolio); ?>
                                    </div>
                                <?php
                            } ?>
                                </div>
                        </div>
                    </section>
                </div>
            </div>
        </main>
        <?php footer(); ?>
    </div>
</body>

</html>