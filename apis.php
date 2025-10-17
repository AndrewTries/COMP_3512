<?php
    include 'includes/config.inc.php';
    include 'includes/index.inc.php';
    include 'includes/nav.inc.php';
    include 'includes/index-helper.inc.php';

    try {
        $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
        $userGateway = new UserDB($conn);
        $users = $userGateway->getAll();
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
        <section>
            <h1>API's</h1>
            <h2>URL</h2>
            <div id='hover'>
            <ul>
                <li><a href="api/companies.php" title="Retrieve Information of all Companies">Companies</a></li>
                <li><a href="api/companies.php?ref=ads">Company Stock</a></li>
                <li><a href="api/portfolio.php?ref=8">Customer Portfolio</a></li>
                <li><a href="api/history.php?ref=ads">Company History</a></li>
            </ul>
            </div>
            <h2>Description</h2>
            <ul>
                <li>Returns all the companies/stocks</li>
                <li>Return just a specific company/stock</li>
                <li>Returns all the portfolios for a specific customer</li>
                <li>Returns the history information for a specific sample company</li>
            </ul>
        </section>
    </main>
    <?php footer(); ?>
</body>
</html>
