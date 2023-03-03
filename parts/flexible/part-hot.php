<section class="hot">

    <?php $number = get_sub_field('number_of_output_positions') ? get_sub_field('number_of_output_positions') : 15; ?>

    <?php $arg = array(
        'post_type' => 'real_estate',
        'order' => 'ASC',
        'orderby' => 'menu_order',
        'posts_per_page' => $number,
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'priority_status',
                'field' => 'slug',
                'terms' => 'hot',
                'operator' => 'IN',
            ),
        ),
    );
    $slider = new WP_Query($arg);
    if ($slider->have_posts()) : ?>
        <div class="real-estate-slider-hot">
            <?php while ($slider->have_posts()) : $slider->the_post(); ?>
                <div class="real-estate-hot__item">

                    <?php $image_id = get_post_thumbnail_id();
                    $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
                    ?>
                    <a class="" href="<?php the_permalink(); ?>">
                        <label class="label-hot">
                            <svg width="10" height="15" viewBox="0 0 10 15" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.77044 14.375C3.83116 14.3749 2.91357 14.0927 2.13664 13.5648C1.3597 13.037 0.759258 12.2879 0.413161 11.4147C0.0670637 10.5415 -0.00872509 9.58449 0.195621 8.6677C0.399967 7.75092 0.875023 6.91667 1.55919 6.27312C2.39794 5.48375 4.45794 4.0625 4.14544 0.9375C7.89544 3.4375 9.77044 5.9375 6.02044 9.6875C6.64544 9.6875 7.58294 9.6875 9.14544 8.14375C9.31419 8.62687 9.45794 9.14625 9.45794 9.6875C9.45794 10.9307 8.96408 12.123 8.08501 13.0021C7.20593 13.8811 6.01365 14.375 4.77044 14.375Z"
                                      fill="white"/>
                            </svg>
                            <span>Hot</span></label>
                        <?php if ($image = get_attached_img_url(get_the_ID(), 'medium')): ?>
                        <span class="img-wrapper">
                            <img src="<?= $image; ?>" alt="<?= $image_alt; ?>">
                        </span>
                        <?php endif; ?>

                        <?php if( get_the_title() ): ?>
                            <p><?php echo mb_strimwidth(get_the_title(), 0, 30, '...'); ?></p>
                        <?php endif; ?>


                    </a>

                </div>
            <?php endwhile; ?>
        </div>
    <?php endif;
    wp_reset_query(); ?>


</section>