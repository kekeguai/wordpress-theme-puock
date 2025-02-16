<?php if (in_array(pk_get_option('index_mode', ''), array('cms', 'company'))
    && (pk_is_checked('cms_show_2box') || pk_is_checked('company_show_2box'))): ?>
    <?php dynamic_sidebar('index_cms_layout_top') ?>
    <div class="row row-cols-1 <?php pk_open_box_animated('animated fadeInUp') ?> " id="magazines">
        <?php
        $cms_mode = pk_get_option('index_mode', '') == 'cms' ? 'cms' : 'company';
        $cms_cats_str = pk_get_option($cms_mode . '_show_2box_id', '');
        if (!empty($cms_cats_str)) {
            $cms_cats = is_array($cms_cats_str) ? $cms_cats_str : explode(",", $cms_cats_str);
            if (count($cms_cats) > 0) {
                $cms_cats_num = pk_get_option($cms_mode . '_show_2box_num', '6');
                foreach ($cms_cats as $catId):
                    $cache_key = sprintf(PKC_CMS_2BOX_POSTS, $catId);
                    $posts = pk_cache_get($cache_key);
                    if (!$posts) {
                        $posts = query_posts(array(
                            'cat' => $catId,
                            'posts_per_page' => $cms_cats_num,
                            'orderby' => 'DESC'
                        ));
                        wp_reset_query();
                        pk_cache_set($cache_key, $posts);
                    }
                    $post_index = 0;
                    ?>
                    <?php if ($posts && count($posts) > 0) : ?>
                    <div class="col-md-6 pr-0 magazine">
                        <div class="p-block">
                            <div>
                                <span class="t-lg puock-text pb-2 d-inline-block border-bottom border-primary"><?php echo get_post_category_link('ta3 a-link', '<i class="fa fa-layer-group"></i>&nbsp;', $catId) ?></span>
                            </div>
                            <?php foreach ($posts as $post) : setup_postdata($post); ?>
                                <?php if ($post_index == 0): ?>
                                    <div class="mtb10 magazine-media-item">
                                        <a class="img" <?php pk_link_target() ?> href="<?php the_permalink() ?>">
                                            <img title="<?php the_title() ?>"
                                                 alt="<?php the_title() ?>" <?php echo pk_get_lazy_img_info(get_post_images(), 'w-100 round-3', 120, 80) ?>/>
                                        </a>
                                        <div class="t-line-1">
                                            <h2 class="t-lg t-line-1"><a class="a-link"
                                                                         title="<?php the_title() ?>" <?php pk_link_target() ?>
                                                                         href="<?php the_permalink() ?>"><?php the_title() ?></a>
                                            </h2>
                                            <div class="t-md c-sub text-2line"><?php the_excerpt() ?></div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="media-link media-row-2">
                                        <div class="t-lg t-line-1 row">
                                            <div class="col-lg-9 col-12 text-nowrap text-truncate">
                                                <i class="fa fa-angle-right t-sm c-sub mr-1"></i>
                                                <a class="a-link t-w-400 t-md"
                                                   title="<?php the_title() ?>" <?php pk_link_target() ?>
                                                   href="<?php the_permalink() ?>"><?php the_title() ?></a>
                                            </div>
                                            <div class="col-lg-3 text-end d-none d-lg-block">
                                                <span class="c-sub t-sm"><?php pk_get_post_date() ?></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif;
                                $post_index++; ?>
                            <?php endforeach;
                            unset($posts); ?>
                        </div>
                    </div>
                <?php endif; endforeach;
            }
        } ?>
    </div>
    <?php dynamic_sidebar('index_cms_layout_bottom') ?>
<?php endif; ?>
