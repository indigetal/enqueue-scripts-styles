In cases where you want specific CSS or JS files to apply to certain pages or Custom Post Types (CPTs) rather than globally across the entire website, you wouldn't enqueue those files in the typical way via `wp_enqueue_style` or `wp_enqueue_script`.

Instead, you might conditionally load these assets directly within your pages, templates or functions based on specific conditions using `<link>` tags for CSS and `<script>` tags for JavaScript.

### Here's a general approach:

#### For CSS:

Let's say you have a CSS file named special.css that you want to apply to a particular page. You could simply add `<link rel="stylesheet" href="' . WP_CONTENT_URL . '/enqueued-scripts-styles/css/special.css">` to that page.

For a specific Custom Post Type archive you could add a check within your template file (page.php, single.php, or a custom template) to conditionally load this CSS file:

```php
<?php
// For a specific page (e.g., ID 10)
if (is_page(10)) {
    echo '<link rel="stylesheet" href="' . WP_CONTENT_URL . '/enqueued-scripts-styles/css/special.css">';
}

// For a specific Custom Post Type archive (e.g., 'your_custom_post_type')
if (is_post_type_archive('your_custom_post_type')) {
    echo '<link rel="stylesheet" href="' . WP_CONTENT_URL . '/enqueued-scripts-styles/css/special.css">';
}
?>
```

This code checks if the current page is the one with the ID 10 or if it's an archive of a specific Custom Post Type (your_custom_post_type). If the condition is met, it outputs the `<link>` tag to include the special.css file.

#### For JavaScript:

Similar to CSS, for JavaScript files (special.js, for example), you'd include them directly to a page using `<script src="' . WP_CONTENT_URL . '/enqueued-scripts-styles/js/special.js"></script>` or conditionally within your templates with:

```php
<?php
// For a specific page (e.g., ID 10)
if (is_page(10)) {
    echo '<script src="' . WP_CONTENT_URL . '/enqueued-scripts-styles/js/special.js"></script>';
}

// For a specific Custom Post Type archive (e.g., 'your_custom_post_type')
if (is_post_type_archive('your_custom_post_type')) {
    echo '<script src="' . WP_CONTENT_URL . '/enqueued-scripts-styles/js/special.js"></script>';
}
?>
```

These snippets show how to conditionally load CSS or JS files based on specific criteria, such as page IDs or Custom Post Type archives. Modify these conditions according to your needs and add them within the appropriate template files or functions to target specific content.
