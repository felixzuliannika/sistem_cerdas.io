<?php
/**
 * Helper functions for Mood-Based Film Recommendation
 */

/**
 * Generate thumbnail URL from film title if thumbnail is placeholder
 * @param string $thumbnail Current thumbnail URL
 * @param string $title Film title
 * @return string Thumbnail URL
 */
function getThumbnailUrl($thumbnail, $title) {
    // If thumbnail is a placeholder or empty, generate a better one
    if (empty($thumbnail) || strpos($thumbnail, 'placeholder') !== false) {
        // Use a better placeholder service or generate from title
        $encodedTitle = urlencode($title);
        // Using placeholder.com with better styling
        return "https://via.placeholder.com/300x450/0f4c75/ffffff?text=" . $encodedTitle;
    }
    return $thumbnail;
}

/**
 * Generate a colored placeholder based on mood
 * @param string $title Film title
 * @param string $mood Film mood
 * @return string Thumbnail URL
 */
function generateMoodThumbnail($title, $mood) {
    $moodColors = [
        'energi' => ['bg' => 'FF0000', 'text' => 'FFFFFF'],
        'tenang' => ['bg' => '4A90E2', 'text' => 'FFFFFF'],
        'galau' => ['bg' => '6C757D', 'text' => 'FFFFFF'],
        'bahagia' => ['bg' => 'FFC107', 'text' => '000000'],
        'romantis' => ['bg' => 'E91E63', 'text' => 'FFFFFF'],
        'semangat' => ['bg' => '28A745', 'text' => 'FFFFFF']
    ];
    
    $colors = $moodColors[$mood] ?? ['bg' => '0f4c75', 'text' => 'ffffff'];
    $encodedTitle = urlencode(substr($title, 0, 20)); // Limit title length
    
    return "https://via.placeholder.com/300x450/" . $colors['bg'] . "/" . $colors['text'] . "?text=" . $encodedTitle;
}
?>

