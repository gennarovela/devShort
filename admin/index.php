<?php

// All relevant changes can be made in the data file. Please read the docs: https://github.com/flokX/devShort/wiki

$name = htmlspecialchars($_POST["delete"]);

$base_path = __DIR__;
$data = json_decode(file_get_contents($base_path . DIRECTORY_SEPARATOR . "config.json"), true);

if (isset($_POST["delete"])) {
    $filename = $base_path . DIRECTORY_SEPARATOR . "config.json";
    $content = json_decode(file_get_contents($filename), true);
    unset($content["shortlinks"][$name]);
    file_put_contents($filename, json_encode($content, JSON_PRETTY_PRINT));

    $filename = $base_path . DIRECTORY_SEPARATOR . "stats.json";
    $content = json_decode(file_get_contents($filename), true);
    unset($content[$name]);
    file_put_contents($filename, json_encode($content, JSON_PRETTY_PRINT));

    echo "{\"status\": \"successful\"}";
    exit;
}

// Generator for page customization
$links_string = "";
if ($data["settings"]["custom_links"]) {
    foreach ($data["settings"]["custom_links"] as $name => $url) {
        $links_string = $links_string . "<a href=\"$url\" class=\"badgebadge-secondary\">$name</a> ";
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
    <meta name="author" content="<?php echo $data["settings"]["author"]; ?> and the devShort team">
    <link rel="icon" href="../<?php echo $data["settings"]["favicon"]; ?>">
    <title>Admin console | <?php echo $data["settings"]["name"]; ?></title>
    <link href="../assets/vendor/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/main.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

    <main role="main" class="flex-shrink-0">
        <div class="container">
            <h1 class="mt-5 mb-4 text-center"><?php echo $data["settings"]["name"]; ?> admin console</h1>
            <div id="charts"></div>
            <p class="text-center mt-4">powered by <a href="https://github.com/flokX/devShort">devShort</a> v1.1.0 (Latest: <a href="https://github.com/flokX/devShort/releases"><img src="https://img.shields.io/github/release/flokX/devShort.svg?style=flat" alt="Latest release"></a>)</p>
        </div>
    </main>

    <footer class="footer mt-auto py-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted">&copy; <?php echo date("Y") . " " . $data["settings"]["author"]; ?> and <a href="https://github.com/flokX/devShort">devShort</a></span>
                <?php if ($links_string) { echo "<span class=\"text-muted\">$links_string</span>"; } ?>
            </div>
        </div>
    </footer>

    <script src="../assets/vendor/frappe-charts/frappe-charts.min.iife.js"></script>
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="main.js"></script>

</body>

</html>
