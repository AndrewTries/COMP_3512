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
    <div class="flex min-h-screen w-full flex-col bg-background">
        <header></header>
        <?= nav(); ?>
        <main class="flex-grow">
        <section> 
            <h1 class="text-2xl font-bold text-center mt-5">About</h1>
            <div class="mx-auto max-w-sm md:max-w-[40%] p-4">
            <div class="text-center">
            <p>My name is Andrew Krawiec. I am a 3rd year student in Computer Information Systems. My hobbies include skiing and board games.</p>
            <p>This assignment is to demonstrate my profficiency with PHP.</p>
            <p>The coding languages I am using include PHP, HTML ans TailWindCSS.</p>
            <p>The technologies I am using include VSCode, GitHub, and git.</p>
            <p class="p-4"><a class="text-sky-500 underline" href="https://github.com/AndrewTries/COMP_3512-Assignment1">github link</a></p>
            </div>
            </div>
        </section>
    </main>
        <?php footer(); ?>
    </div>
</body>
</html>
