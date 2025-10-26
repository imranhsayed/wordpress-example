<?php
/**
 * Test file to check block rendering
 * Access via: /wp-content/themes/aquila/test-block-render.php
 */

require_once '../../../wp-load.php';

echo '<h1>Block Registration Test</h1>';

$registry = WP_Block_Type_Registry::get_instance();
$notice_block = $registry->get_registered('aquila/notice');

if ($notice_block) {
    echo '<h2>✅ Block IS registered</h2>';
    echo '<pre>';
    echo 'Block Name: ' . $notice_block->name . "\n";
    echo 'Has render_callback: ' . (isset($notice_block->render_callback) ? 'YES' : 'NO') . "\n";
    echo 'Render callback: ';
    var_dump($notice_block->render_callback);
    echo "\n\nFull block object:\n";
    print_r($notice_block);
    echo '</pre>';
} else {
    echo '<h2>❌ Block is NOT registered</h2>';
}

// Get the post
$post = get_post(23);
if ($post) {
    echo '<h2>Post Content (raw):</h2>';
    echo '<textarea style="width:100%;height:300px;">';
    echo esc_textarea($post->post_content);
    echo '</textarea>';
    
    echo '<h2>Post Content (rendered):</h2>';
    echo '<div style="border:2px solid blue; padding:20px;">';
    echo apply_filters('the_content', $post->post_content);
    echo '</div>';
}

