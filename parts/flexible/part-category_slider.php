<?php
$thisTitle = get_sub_field('title') ? get_sub_field('title') : $title;
$number = get_sub_field('number_of_output_positions') ? get_sub_field('number_of_output_positions') : 15;

$getSelectedCategory = get_sub_field('select_category') ? get_sub_field('select_category') : $cat;
$mainCat = 'type_of_agreement';
$catSection = $getSelectedCategory;
$counter = 0;

$terms = get_term_by('slug', $catSection, $mainCat);


$arg = array(
    'post_type' => 'real_estate',
    'order' => 'ASC',
    'orderby' => 'post_date',
    'post__not_in' => array($postId),
    'posts_per_page' => $number,
    'tax_query' => array(
        'relation' => 'AND',
        array(
            'taxonomy' => $mainCat,
            'field' => 'slug',
            'terms' => $catSection,
            'operator' => 'IN',
        ),

    ),

);
if ($cat) {
    $arg['meta_query'][] = array(
        array(
            'key' => 'property_name',
            'value' => $propertyName,
            'compare' => '='
        )
    );
}
$slider = new WP_Query($arg);
?>

<?php if ($slider->found_posts) { ?>
    <section class="category_slider">

        <div class="category_slider__header">

            <?php if ($thisTitle): ?>
                <h2 class="title-section"><?= $thisTitle; ?></h2>
            <?php endif; ?>
            <?php


            if (!$cat) {
                if (get_category_link($terms->term_id)) { ?>
                    <a class="category_slider__link"
                       href="<?= get_category_link($terms->term_id); ?>"><?php _e('Show All Properties', 'test'); ?></a>
                <?php } ?>
            <?php } ?>
        </div>

        <?php


        if ($slider->have_posts()) : ?>

            <?php
            $terms = get_term_by('slug', $catSection, $mainCat);

            //  get_category_link($terms->term_id); ?>


            <div class="real-estate-objects real-estate-slider-category_slider">
                <?php while ($slider->have_posts()) : $slider->the_post(); ?>
                    <div class="real-estate__item">

                        <?php $image_id = get_post_thumbnail_id();
                        $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
                        ?>


                        <?php if ($image = get_attached_img_url(get_the_ID(), 'medium')): ?>
                            <div class="img-wrapper">
                                <img src="<?= $image; ?>" alt="<?= $image_alt; ?>">
                                <div class="real-estate-objects__links">
                                    <?php
                                    $taxonomy = $mainCat;
                                    $terms = get_terms($taxonomy);
                                    $test = '';
                                    if ($terms) {
                                        foreach ($terms as $term) {
                                            if (has_term($term->slug, $mainCat)) { ?>
                                                <!--                                                <p style="color: white;">--><?php //var_dump(get_term_link($terms)); ?><!--</p>-->
                                                <!--                                            <p>--><?php //echo get_term_link($term, $mainCat); ?><!--</p>-->
                                                <?php if ($link = get_term_link($term, $mainCat)): ?>
                                                    <a class="cat_link cat_link-first"
                                                       href="<?php echo $link; ?>"><?php _e(strtoupper($term->name), 'test'); ?></a>
                                                    <?php $link; ?>
                                                <?php endif; ?>
                                                <?php
                                            }
                                        }
                                    };
                                    ?>



                                    <?php
                                    $taxonomy = 'types_of_real_estate';
                                    $terms = get_terms($taxonomy);
                                    if ($terms) {
                                        foreach ($terms as $term) {
                                            if (has_term($term->slug, $taxonomy)) {
                                                $titleCat = $term->name;
                                                if ($link): ?>
                                                    <a class="cat_link cat_link-second"
                                                       href="<?php echo $link . $term->slug; ?>"><?php _e(strtoupper($titleCat), 'test'); ?></a>
                                                <?php endif; ?>
                                                <?php
                                            }
                                        }
                                    };
                                    ?>
                                </div>


                            </div>
                        <?php endif; ?>


                        <div class="real-estate__content">
                            <?php if (get_the_title()): ?>
                                <a class="product-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            <?php endif; ?>
                            <a href="#map-<?= $catSection . '-' . $counter; ?>" data-fancybox
                               class="real-estate__description">
                                <svg width="13" height="15" viewBox="0 0 13 15" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.4545 6.22727C12.4545 10.6818 6.72727 14.5 6.72727 14.5C6.72727 14.5 1 10.6818 1 6.22727C1 4.70831 1.60341 3.25155 2.67748 2.17748C3.75155 1.10341 5.20831 0.5 6.72727 0.5C8.24624 0.5 9.70299 1.10341 10.7771 2.17748C11.8511 3.25155 12.4545 4.70831 12.4545 6.22727Z"
                                          stroke="#8F8F8F" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M6.7294 7.81818C7.78377 7.81818 8.63849 6.96345 8.63849 5.90909C8.63849 4.85473 7.78377 4 6.7294 4C5.67504 4 4.82031 4.85473 4.82031 5.90909C4.82031 6.96345 5.67504 7.81818 6.7294 7.81818Z"
                                          stroke="#8F8F8F" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <?php $region = get_field('emirate');
                                $community = get_field('community');
                                ?>
                                <?php if ($region && $community): ?>
                                    <span><?php echo($region . ', ' . $community) ?></span>
                                <?php endif; ?>



                                <?php
                                $lat = get_field('latitude');
                                $lng = get_field('longitude');
                                if ($lat && $lng): ?>
                                    <span id="map-<?= $catSection . '-' . $counter; ?>" class="map-container">
                                    <span class="acf-map" data-zoom="16">
                                        <span class="marker" data-lat="<?php echo esc_attr($lat); ?>"
                                              data-lng="<?php echo esc_attr($lng); ?>"></span>
                                    </span>
                                </span>
                                    <?php $counter++; ?>
                                <?php endif; ?>


                            </a>

                            <?php if (get_field('price')): ?>
                                <p class="price"><?= number_format(get_field('price')); ?> AED</p>
                            <?php endif; ?>

                            <div class="real-estate__details">

                                <div class="bads details-item">
                                    <p>5</p>
                                    <i></i>
                                    <span><?php _e('Bads', 'test'); ?></span>
                                </div>

                                <?php if (get_field('no_of_bathroom')): ?>
                                    <div class="baths details-item">
                                        <p><?php the_field('no_of_bathroom'); ?></p>

                                        <i></i>
                                        <span><?php _e('Baths', 'test'); ?></span>
                                    </div>
                                <?php endif; ?>

                                <?php if (get_field('unit_builtup_area')): ?>
                                    <div class="square details-item">
                                        <p><?php the_field('unit_builtup_area'); ?></p>
                                        <i></i>
                                        <span><?php _e('Square (ft)', 'test'); ?></span>
                                    </div>
                                <?php endif; ?>


                            </div>

                        </div>


                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif;
        wp_reset_query(); ?>

    </section>
<?php } ?>