<div class="relative <?php echo isset($args["class"]) ? $args["class"] : "" ?>">
    <h2 class="font-semibold text-base"><?php _e("Colors", "lumi"); ?></h2>
    <div class="relative mx-auto grid lg:grid-cols-4 md:grid-cols-12 grid-cols-6 gap-3 py-2">
        <?php foreach (get_lumi_categories([
            "taxonomy" => "pa_color", // old product_color
            "number" => 100,
        ]) as $key => $category) : ?>
            <a class="relative grid mx-auto" href="<?php echo get_lumi_filter_url($category); ?>">
                <div class="w-10 h-10 flex justify-center items-center mx-auto rounded-xl drop-shadow-lg border border-slate-300" style="background: <?php echo get_lumi_product_color($category->term_id) ?>;">
                    <?php if (in_array($category->slug, get_lumi_request_colors() ?? [])) : ?>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 <?php echo in_array($category->slug, ["white", "orange"]) ? "text-slate-700" : "text-white" ?>">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    <?php endif; ?>
                </div>
                <span class="truncate text-center text-[10px]"><?php echo ucfirst($category->name); ?></span>
                <?php clog($category) ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>