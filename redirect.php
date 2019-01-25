<?php

// All relevant changes can be made in the data file. Please read the docs: https://github.com/flokX/devShort/wiki

$short = htmlspecialchars($_GET["short"]);

// If the robots.txt is requested, return it
if ($short === "robots.txt") {
	header("Content-Type: text/plain; charset=utf-8");
	echo "User-agent: *\n";
	echo "Disallow: /\n";
	exit;
} else if ($short === 'favicon.ico') {
    header("HTTP/1.1 404 Not Found");
    exit;
}

// Counts the access to the given $name
function count_access($base_path, $name) {
    $filename = $base_path . DIRECTORY_SEPARATOR . "stats.json";
    $stats = json_decode(file_get_contents($filename), true);
    $stats[$name][date("Y-m-d")] += 1;
    file_put_contents($filename, json_encode($stats));
}

$base_path = implode(DIRECTORY_SEPARATOR, array(__DIR__, "secure"));
$data = json_decode(file_get_contents($base_path . DIRECTORY_SEPARATOR . "configjson"), true);

if (array_key_exists($short, $data["shortlinks"])) {
    header("Location: " . $data["shortlinks"][$short], $http_response_code=303);
    count_access($base_path, $short);
    exit;
} else {
    header("HTTP/1.1 404 Not Found");
    count_access($base_path, "404 request");

    // Generator for page customization
    $links_string = "";
    if ($data["settings"]["custom_links"]) {
        foreach ($data["settings"]["custom_links"] as $name => $url) {
            $links_string = $links_string . "<a href=\"$url\" class=\"badge badge-secondary\">$name</a> ";
        }
        $links_string = substr($links_string, 0, -1);
    }
}

?>

<!doctype html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="noindex, nofollow">
    <meta name="author" content="<?php echo $data["settings"]["author"]; ?> and the devShort team">
    <link rel="icon" href="<?php echo $data["settings"]["favicon"]; ?>">
    <title>404 | <?php echo $data["settings"]["name"]; ?></title>
    <link href="assets/vendor/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="assets/main.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

    <main role="main" class="flex-shrink-0">
        <div class="container">
            <nav class="mt-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $data["settings"]["home_link"]; ?>">Home</a></li>
                    <li class="breadcrumb-item"><?php echo $data["settings"]["name"]; ?></li>
                    <li class="breadcrumb-item active" aria-current="page">404</li>
                </ol>
            </nav>
            <h1 class="mt-5">404 | Shortlink Not Found.</h1>
            <p class="lead">The requested shortlink <i><?php echo $short; ?></i> was not found on this server. It was either deleted, expired, misspelled, or eaten by a monster.</p>
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

</body>

</html>
