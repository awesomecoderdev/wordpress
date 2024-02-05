<!-- <section id="breadcrumb" class="relative border-t border-primary-50/50 dark:border-slate-50/25 text-slate-500 dark:text-white">
    <div class="relative container text-sm font-normal py-2 flex flex-wrap justify-start items-center">
        <?php
        woocommerce_breadcrumb([
            // 'delimiter'   => ' &#47; ',
            'delimiter' => '
            <span  class="flex items-center justify-center px-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                    <path fill-rule="evenodd" d="M10.21 14.77a.75.75 0 01.02-1.06L14.168 10 10.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                    <path fill-rule="evenodd" d="M4.21 14.77a.75.75 0 01.02-1.06L8.168 10 4.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                </svg>
            </span>
            '
            // 'before' => '<span class="breadcrumb-title">' . __('This is where you are:', 'woothemes') . '</span>'
        ]);
        ?>
    </div>
</section> -->

<?php if (lumi_path("categories") || lumi_path("brand")) : ?>
    <div class="relative border-b border-primary-50/50 dark:border-slate-50/25 md:pb-0 pb-2"></div>
<?php endif; ?>


<section id="categories" class="relative border-b border-primary-50/50 dark:border-slate-50/25 text-slate-500 dark:text-white">
    <div class="relative container text-sm font-normal py-2 flex flex-wrap justify-evenly items-center">
        <?php foreach (get_lumi_categories([
            "number" => 12,
            'parent'        => 0,
        ]) as $key => $category) : ?>
            <a class="lg:px-4 px-2 py-1 <?php echo  $category->term_id == get_queried_object_id() ? "bg-primary-500 rounded-full text-white" : "" ?>" href="<?php echo get_term_link($category); ?>">
                <?php echo $category->name; ?>
            </a>
        <?php endforeach; ?>
    </div>
</section>