<?php
include 'includes/config.inc.php';
include 'includes/index.inc.php';
include 'includes/nav.inc.php';
include 'includes/index-helper.inc.php';

try {
    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
    $userGateway = new UserDB($conn);
    $users = $userGateway->getAll();
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
            <section>
                <h1 class="text-2xl font-bold text-center mt-5">About</h1>
                <div class="flex justify-center p-4 mx-4">
                    <div class="">
                        <div class="flex flex-col-2 gap-x-5 md:gap-x-15 lg:gap-x-30">
                            <div class="w-[40%]">
                                <h3>URL</h3>
                                <div id='hover'>
                                    <ul class="list-disc">
                                        <li><a class="text-sky-500 underline" href="api/companies.php" title="Retrieve Information of all Companies">Companies</a></li>
                                        <li><a class="text-sky-500 underline" href="api/companies.php?ref=ads">Company Stock</a></li>
                                        <li><a class="text-sky-500 underline" href="api/portfolio.php?ref=8">Customer Portfolio</a></li>
                                        <li><a class="text-sky-500 underline" href="api/history.php?ref=ads">Company History</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="w-[60%]">
                                <h3>Description</h3>
                                <ul>
                                    <li>Returns all the companies/stocks</li>
                                    <li>Return just a specific company/stock</li>
                                    <li>Returns all the portfolios for a specific customer</li>
                                    <li>Returns the history information for a specific sample company</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <?php footer(); ?>
    </div>
</body>

</html>