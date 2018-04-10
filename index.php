<?php

// features
// click to copy hex
// click to tick and then button to open in trycolors

include 'helpers.php';
$colors = include 'colors.php';
$order = isset($_GET['order']) ? $_GET['order'] : '';
$orderKey = isset($_GET['order-key']) ? $_GET['order-key'] : '';

if ($order == 'hsl') {
    uasort($colors, function($a, $b) use ($orderKey) {
        $ahsl = hexToHsl($a['hex']);
        $bhsl = hexToHsl($b['hex']);
        return $ahsl[$orderKey] > $bhsl[$orderKey];
    });
}

include 'home.php';