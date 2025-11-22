<?php

use App\Services\CachedGithubService;

function colorNameToHex(string $colorName): string
{
    $colorMap = [
        'yellow' => '#fef08a',
        'green' => '#4ade80',
        'red' => '#f87171',
        'blue' => '#60a5fa',
        'orange' => '#fb923c',
        'purple' => '#a78bfa',
        'pink' => '#f9a8d4',
        'gray' => '#9ca3af',
    ];

    return $colorMap[strtolower($colorName)] ?? '#000000'; // default to black
}

function getBoardsForNavigation(): \Illuminate\Support\Collection
{
    $api = new CachedGithubService;

    return $api->getBoardsForNavigation();
}

function getCustomField(array $fields, string $name): null|string|array
{
    $data = collect($fields)->where('name', $name)->first();
    if (is_null($data)) {
        return null;
    }
    $result = match ($name) {
        'Assignees', 'Parent Issue', 'Labels' => $data['value'] ?? null,
        'Milestone' => $data['value']['title'] ?? null,
        'Size', 'Priority', 'Status' => $data['value']['name']['raw'] ?? null,
        'Iteration' => $data['value']['title']['raw'] ?? null,
        'Title' => $data['value']['raw'] ?? null,
        'Repository' => $data['value']['full_name'] ?? null,
        'Type' => $data['value']['name'] ?? null,
        default => throw new UnhandledMatchError($name.' not found in match statement')
    };
    return $result;
}

/**
 * Suggests a readable text color for a given background hex color.
 * Returns a hex code string that meets WCAG contrast guidelines.
 */
function suggestTextColor(string $bgHex, array $candidates = ['#000000', '#ffffff']): string
{
    $bgHex = ltrim($bgHex, '#');

    // Split RGB
    $r = hexdec(substr($bgHex, 0, 2));
    $g = hexdec(substr($bgHex, 2, 2));
    $b = hexdec(substr($bgHex, 4, 2));

    // Perceived brightness formula
    $brightness = ($r * 299 + $g * 587 + $b * 114) / 1000;

    // If brightness is high, pick dark color; else pick light color
    if ($brightness > 186) {
        // background is light → pick dark color
        return '#000000';
    }

    // background is dark → pick light color
    return '#ffffff';
}

/**
 * Returns either 'black' or 'white' depending on which has better WCAG contrast
 * for a given hex background color.
 */
function wcagTextColor(string $hex): string
{
    $hex = ltrim($hex, '#');

    // Convert hex to RGB
    $r = hexdec(substr($hex, 0, 2)) / 255;
    $g = hexdec(substr($hex, 2, 2)) / 255;
    $b = hexdec(substr($hex, 4, 2)) / 255;

    // Convert sRGB to linear RGB
    $r = ($r <= 0.03928) ? $r / 12.92 : pow((($r + 0.055) / 1.055), 2.4);
    $g = ($g <= 0.03928) ? $g / 12.92 : pow((($g + 0.055) / 1.055), 2.4);
    $b = ($b <= 0.03928) ? $b / 12.92 : pow((($b + 0.055) / 1.055), 2.4);

    // Calculate relative luminance
    $luminance = 0.2126 * $r + 0.7152 * $g + 0.0722 * $b;

    // Contrast ratios with white and black
    $contrastWithWhite = (1.05) / ($luminance + 0.05);
    $contrastWithBlack = ($luminance + 0.05) / 0.05;

    // Return the one with better contrast
    return ($contrastWithWhite >= $contrastWithBlack) ? 'black' : 'white';
}
