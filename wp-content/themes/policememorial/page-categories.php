<?php

/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @link              https://awesomecoder.dev/
 * @since             1.0.0
 * @package           lumi
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.

}

?>

<?php get_header(); ?>

<main id="main" class="<?php echo lumi_container("not-prose"); ?>">
    <div class="relative grid grid-cols-4 gap-4 py-4">
        <?php foreach (get_lumi_categories(["number" => 100]) as $key => $category) : ?>
            <a class="relative flex justify-center items-center flex-col" href="<?php echo get_term_link($category); ?>">
                <img class="rounded-full h-14 w-14 bg-gray-100 shadow" src="<?php echo get_lumi_categories_image($category->term_id) ?>" alt="">
                <span class="truncate w-16 text-center"><?php echo ucfirst($category->name); ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</main>

<?php get_footer(); ?>