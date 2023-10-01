<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewsport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/public/assets/css/style.css">

        <?php if(!empty($jsFiles)) {
            foreach($jsFiles as $jsFile) {
                echo "<script src='$jsFile' defer></script>";
            }
        }?>

        <title><?= $title . " | PHP Training" ?></title>
        
    </head>
    <body class="body">
        <?php require_once "partials/header.php" ?>
        <?php require_once "partials/nav.php" ?>
        <main class="main page">
            <h1 class="page__title"><?= $title; ?></h1>
            <?= $content; ?>  
        </main>
        <?php require_once "partials/footer.php" ?>
    </body>
</html>