<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'helpers.php';
$colors = include 'colors.php';
$order = isset($_GET['order']) ? $_GET['order'] : '';
$orderKey = isset($_GET['order-key']) ? $_GET['order-key'] : '';

if ($order == 'h-grouped') {
    $hRange = 360;
    $hRangeOnePercent = $hRange / 100;
    $colorsGrouped = [];
    $colorsGrouped = [
        0 => ['range' => [0, 10], 'name' => 'Red', 'colors' => []],
        1 => ['range' => [11, 20], 'name' => 'Red Orange', 'colors' => []],
        2 => ['range' => [21, 40], 'name' => 'Orange', 'colors' => []],
        3 => ['range' => [41, 50], 'name' => 'Yellow Orange', 'colors' => []],
        4 => ['range' => [51, 60], 'name' => 'Yellow', 'colors' => []],
        5 => ['range' => [61, 80], 'name' => 'Yellow Green', 'colors' => []],
        6 => ['range' => [81, 140], 'name' => 'Green', 'colors' => []],
        7 => ['range' => [141, 169], 'name' => 'Blue Green', 'colors' => []],
        8 => ['range' => [170, 240], 'name' => 'Blue', 'colors' => []],
        9 => ['range' => [241, 280], 'name' => 'Blue Violet', 'colors' => []],
        10 => ['range' => [281, 320], 'name' => 'Violet', 'colors' => []],
        11 => ['range' => [321, 344], 'name' => 'Red Violet', 'colors' => []],
        12 => ['range' => [355, 500], 'name' => 'Red', 'colors' => []],
        // 0 => ['range' => [0, 10], 'name' => 'Red', 'colors' => []],
        // 1 => ['range' => [11, 19], 'name' => 'Red Orange', 'colors' => []],
        // 2 => ['range' => [20, 29], 'name' => 'Orange', 'colors' => []],
        // 3 => ['range' => [30, 43], 'name' => 'Yellow Orange', 'colors' => []],
        // 4 => ['range' => [44, 60], 'name' => 'Yellow', 'colors' => []],
        // 5 => ['range' => [61, 76], 'name' => 'Yellow Green', 'colors' => []],
        // 6 => ['range' => [77, 135], 'name' => 'Green', 'colors' => []],
        // 7 => ['range' => [136, 163], 'name' => 'Blue Green', 'colors' => []],
        // 8 => ['range' => [164, 203], 'name' => 'Blue', 'colors' => []],
        // 9 => ['range' => [204, 225], 'name' => 'Blue Violet', 'colors' => []],
        // 10 => ['range' => [226, 300], 'name' => 'Violet', 'colors' => []],
        // 11 => ['range' => [301, 345], 'name' => 'Red Violet', 'colors' => []],
        // 12 => ['range' => [346, 359], 'name' => 'Red', 'colors' => []],
    ];
    foreach ($colors as $color) {
        $hsl = hexToHsl($color['hex']);
        $hue = round($hsl[0] * 100);
        $hue = $hRangeOnePercent * $hue;
        $hue = explode('.', $hue)[0];
        $color['h'] = $hue;
        $color['s'] = explode('.', ($hsl[1] * 100))[0];
        $color['l'] = explode('.', ($hsl[2] * 100))[0];
        foreach ($colorsGrouped as $key => $group) {
            if ($hue >= $group['range'][0] && $hue <= ($group['range'][1] + 1)) {
                $colorsGrouped[$key]['colors'][] = $color;
            }
        }
    }
    foreach ($colorsGrouped as $key => $group) {
        uasort($colorsGrouped[$key]['colors'], function($a, $b) {
            return $a['s'] > $b['s'];
        });
    }
}

if ($order == 'hsl') {
    uasort($colors, function($a, $b) use ($orderKey) {
        $ahsl = hexToHsl($a['hex']);
        $bhsl = hexToHsl($b['hex']);
        return $ahsl[$orderKey] > $bhsl[$orderKey];
    });
}

include 'home.php';
