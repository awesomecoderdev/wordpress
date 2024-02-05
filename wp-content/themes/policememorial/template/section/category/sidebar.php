<?php
$categories = get_lumi_categories(["number" => 100]);
?>
<div class="relative <?php echo isset($args["class"]) ? $args["class"] : "" ?>">
    <h2 class="font-semibold text-base"><?php _e("Categories", "lumi"); ?></h2>
    <div class="relative grid border-b">
        <?php foreach ($categories as $key => $category) : ?>
            <a class="relative flex justify-between items-center <?php echo $key >= 10 ? "hidden sidebar-categories" : "" ?>" href="<?php echo get_term_link($category); ?>">
                <span><?php echo $category->name; ?></span>
                <span>(<?php echo $category->count; ?>)</span>
            </a>
        <?php endforeach; ?>
        <?php if (count($categories) > 10) : ?>
            <div class="relative w-full flex items-center justify-center mx-auto py-3 cursor-pointer" id="sidebar-categories-dropdown">
                <div class="relative bg-primary-500 rounded-full">
                    <svg class="transform sidebar-categories-arrow" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.5927 6.79261C12.4539 6.65465 12.2661 6.57721 12.0704 6.57721C11.8747 6.57721 11.687 6.65465 11.5482 6.79261L8.88895 9.41483L6.26673 6.79261C6.12794 6.65465 5.9402 6.57721 5.74451 6.57721C5.54881 6.57721 5.36107 6.65465 5.22228 6.79261C5.15286 6.86147 5.09775 6.9434 5.06014 7.03367C5.02254 7.12393 5.00317 7.22075 5.00317 7.31854C5.00317 7.41632 5.02254 7.51314 5.06014 7.60341C5.09775 7.69368 5.15286 7.7756 5.22228 7.84446L8.36302 10.9852C8.43189 11.0546 8.51381 11.1097 8.60408 11.1473C8.69434 11.185 8.79116 11.2043 8.88895 11.2043C8.98674 11.2043 9.08356 11.185 9.17382 11.1473C9.26409 11.1097 9.34601 11.0546 9.41488 10.9852L12.5927 7.84446C12.6621 7.7756 12.7172 7.69368 12.7548 7.60341C12.7924 7.51314 12.8118 7.41632 12.8118 7.31854C12.8118 7.22075 12.7924 7.12393 12.7548 7.03367C12.7172 6.9434 12.6621 6.86147 12.5927 6.79261Z" fill="#F7F8F6" />
                    </svg>
                </div>
            </div>
        <?php else : ?>
            <span class="h-2"></span>
        <?php endif; ?>
    </div>
</div>