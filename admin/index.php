<?php

// All relevant changes can be made in the data file. Please read the docs: https://github.com/flokX/devShort/wiki

$config_path = __DIR__ . DIRECTORY_SEPARATOR . "config.json";
$config_content = json_decode(file_get_contents($config_path), true);
$stats_path = __DIR__ . DIRECTORY_SEPARATOR . "stats.json";
$stats_content = json_decode(file_get_contents($stats_path), true);

// API functions to delete and add the shortlinks via the admin panel
if (isset($_GET["delete"]) || isset($_GET["add"])) {
    $name = htmlspecialchars($_POST["name"]);
    $link = htmlspecialchars($_POST["link"]);

    if (isset($_GET["delete"])) {
        unset($config_content["shortlinks"][$name]);
        unset($stats_content[$name]);
    } else if (isset($_GET["add"])) {
        $config_content["shortlinks"][$name] = $link;
        $stats_content[$name] = array();
    }

    file_put_contents($config_path, json_encode($config_content, JSON_PRETTY_PRINT));
    file_put_contents($stats_path, json_encode($stats_content, JSON_PRETTY_PRINT));
    echo "{\"status\": \"successful\"}";
    exit;
}

// Check if there are links which are only in the config.json or only in the stats.json
$changed = false;
foreach ($config_content["shortlinks"] as $name => $url) {
    if (!isset($stats_content[$name])) {
        $stats_content[$name] = array();
        $changed = true;
    }
}
foreach ($stats_content as $name => $stats) {
    if (!isset($config_content["shortlinks"][$name]) && $name !== "404-request") {
        unset($stats_content[$name]);
        $changed = true;
    }
}
if ($changed) {
    file_put_contents($config_path, json_encode($config_content, JSON_PRETTY_PRINT));
    file_put_contents($stats_path, json_encode($stats_content, JSON_PRETTY_PRINT));
}

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
    <meta name="author" content="<?php echo $config_content[" settings"]["author"]; ?> and the devShort team">
    <link rel="icon" href="../<?php echo $config_content[" settings"]["favicon"]; ?>">
    <title>Admin panel | <?php echo $config_content["settings"]["name"]; ?></title>
    <link href="../assets/vendor/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/main.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

    <main role="main" class="flex-shrink-0">
        <div class="container">
            <h1 class="mt-5 text-center"><?php echo $config_content["settings"]["name"]; ?>
            </h1>
            <h4 class="mb-4 text-center">admin panel</h4>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Add shortlink <a id="refresh" href="#refresh" class="card-link">Refresh charts</a></h5>
                    <form class="form-inline">
                        <label class="sr-only" for="name">Name</label>
                        <input type="text" class="form-control mb-2 mr-sm-2" id="name" placeholder="Link1" aria-describedby="name-help">
                        <label class="sr-only" for="link">Link (destination)</label>
                        <input type="text" class="form-control mb-2 mr-sm-2" id="link" placeholder="https://example.com">
                        <button type="submit" id="add-shortlink" class="btn btn-primary mb-2">Add</button>
                    </form>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <div id="spinner" class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div id="charts"></div>
            <p class="text-center my-4">powered by <a href="https://github.com/flokX/devShort">devShort</a> v2.0.0 (Latest: <a href="https://github.com/flokX/devShort/releases"><img src="https://img.shields.io/github/release/flokX/devShort.svg?style=flat" alt="Latest release"></a>)</p>
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

    <script src="../assets/vendor/frappe-charts/frappe-charts.min.iife.js"></script>
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="main.js"></script>

</body>

</html>
