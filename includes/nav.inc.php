<?php
function nav()
{ ?>
    <div class="flex min-h-screen w-full flex-col bg-background">
        <div class="flex items-center justify-between bg-nav px-6 py-4 text-white dark:bg-slate-900">
            <h1 class="text-xl font-bold"><a href="index.php">Portfolio Project</a></h1>
            <nav class="flex gap-5">
                <a href="index.php">Home</a>
                <a href="about.php">About</a>
                <a href="apis.php">APIs</a>
            </nav>
        </div>
    <?php
}

function footer()
{ ?>
        <div class="flex items-center justify-center">
            <div class="border-t-1 w-1/2 bg-background py-6 border-gray-500 text-center text-sm ">
                &copy; 2025 Portfolio Project. All rights reserved.
            </div>
        </div>
    <?php
}
    ?>