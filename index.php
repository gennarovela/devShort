<?php

// All relevant changes can be made in the data file. Please read the docs: https://github.com/flokX/devShort/wiki

$base_path = implode(DIRECTORY_SEPARATOR, array(__DIR__, "admin"));
$config_content = json_decode(file_get_contents($base_path . DIRECTORY_SEPARATOR . "config.json"), true);

// Generator for page customization
$links_string = "";
if ($config_content["settings"]["custom_links"]) {
    foreach ($config_content["settings"]["custom_links"] as $name => $url) {
        $links_string = $links_string . "<a href=\"$url\" class=\"badge badge-secondary\">$name</a> ";
    }
    $links_string = substr($links_string, 0, -1);
}

?>

<!doctype html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="noindex, nofollow">
    <meta name="author" content="<?php echo $config_content["settings"]["author"]; ?> and the devShort team">
    <link rel="icon" href="<?php echo $config_content["settings"]["favicon"]; ?>">
    <title><?php echo $config_content["settings"]["name"]; ?></title>
    <link href="assets/vendor/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="assets/main.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

    <main role="main" class="flex-shrink-0">
        <div class="container">
            <nav class="mt-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $config_content["settings"]["home_link"]; ?>">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page"><?php echo $config_content["settings"]["name"]; ?></li>
                </ol>
            </nav>
            <h1 class="mt-5"><?php echo $config_content["settings"]["name"]; ?></h1>
            <p class="lead">This is a shortlink service. You need a valid shortlink to get redirected.</p>
            <div class="btn-group" role="group" aria-label="Next actions">
                <a class="btn btn-secondary" href="<?php echo $config_content["settings"]["home_link"]; ?>" role="button">Go to home</a>
                <a class="btn btn-secondary" href="https://github.com/flokX/devShort/wiki/What-is-URL-shortening%3F" role="button">Link shortener explanation</a>
                <a class="btn btn-secondary" href="admin" role="button">Admin panel</a>
            </div>
        </div>
    </main>

    <footer class="footer mt-auto py-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted">&copy; <?php echo date("Y") . " " . $config_content["settings"]["author"]; ?> and <a href="https://github.com/flokX/devShort">devShort</a></span>
                <?php if ($links_string) { echo "<span class=\"text-muted\">$links_string</span>"; } ?>
            </div>
        </div>
    </footer>

</body>

</html>
