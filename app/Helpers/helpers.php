<?php

function pr($data, bool $array = true) {
    echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Debug</title>
</head>
<body class="w-screen h-screen bg-black text-white">
    <pre>
HTML;

    if ($array) {
        print_r($data);
    }
    else {
        var_dump($data);
    }

echo <<<HTML
    </pre>
</body>
</html>
HTML;
}
