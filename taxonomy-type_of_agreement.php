<?php
/**
 * Page
 */
get_header(); ?>

    <div class="hero">
        <div class="container">
            <?php if (term_description(get_queried_object()->term_id, 'type_of_agreement')): ?>
                <div class="hero__content text-center">
                    <h1 class="page-title"><?php echo term_description(get_queried_object()->term_id, 'type_of_agreement'); ?></h1>
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php

$urlPage = $_SERVER['REQUEST_URI'];
$withuotChars = trim($urlPage, '/');
$pathUrl = explode('/', $withuotChars);
$getSelectedCategory = '';
$secondTax = '';


if (sizeof($pathUrl) == 3) {

    $ThirdNesting = true;
    $catSlugUrl = $_SERVER['SCRIPT_URI'];
    $getSelectedCategory = $pathUrl[1];
    $mainCat = 'types_of_real_estate';
    $subCat = 'type_of_agreement';
    $nextTax = 'bedrooms';
    $firstCat = $pathUrl[0];
    $thirdCat = $pathUrl[2];
    $catSection = $getSelectedCategory;
    $secondTax = $mainCat;


} else if (sizeof($pathUrl) >= 2) {

    $ThirdNesting = false;
    $catSlugUrl = $_SERVER['SCRIPT_URI'];
    $getSelectedCategory = $pathUrl[1];
    $mainCat = 'types_of_real_estate';
    $subCat = 'type_of_agreement';
    $nextTax = 'bedrooms';
    $catSection = $getSelectedCategory;
    $firstCat = $pathUrl[0];
    $secondTax = $mainCat;

} else if (sizeof($pathUrl) == 1) {

    $ThirdNesting = false;
    $getSelectedCategory = $pathUrl[0];
    $mainCat = 'type_of_agreement';
    $subCat = 'types_of_real_estate';
    $firstCat = $getSelectedCategory;
    $catSection = $getSelectedCategory;
    $catSlugUrl = $_SERVER['SCRIPT_URI'];

 } ?>

<?php



$counter = 0;

?>

<?php $arg = array(
    'post_type' => 'real_estate',
    'order' => 'ASC',
//    'orderby' => 'post_date',
    'orderby' => array(
        'meta_value' => 'DESC',
        'post_date' => 'DESC',
    ),
    'meta_query' => array(
        'relation' => 'OR',
        array(
            'key' => 'priority_status',
            'compare' => 'NOT EXISTS',
        ),
        array(
            'key' => 'priority_status',
            'value' => 'hot',
            'compare' => '=',
        ),
    ),
    'posts_per_page' => -1,
    'tax_query' => array(
        'relation' => 'AND',
        array(
            'taxonomy' => $mainCat, //'types_of_real_estate'
            'field' => 'slug',
            'terms' => $catSection, // $pathUrl[1];
            'operator' => 'IN',
        ),
        array(
            'taxonomy' => 'type_of_agreement',
            'field' => 'term_id',
            'terms' => get_queried_object_id(), // 14 Buy
            'compare' => 'IN'
        ),

    ),
);

if (!empty($ThirdNesting)) {
    $arg['tax_query'][] =  array(
            'taxonomy' => $nextTax, // 'bedrooms'
            'field' => 'slug',
            'terms' => $thirdCat,  // 'bedroom3'
            'hide_empty' => true,
            'compare' => 'IN'
        );
}


$items = new WP_Query($arg);


if ($items->have_posts()) : ?>

    <?php
    $terms = get_term_by('slug', $catSection, $mainCat);  ?>

    <div class="container">


        <?php
        // перевіряємо, чи ми знаходимося в категорії "type_of_agreement"
        $current_category = get_queried_object();


        // отримуємо всі категорії, які не є порожніми в таксономії "types_of_real_estate" і які належать до поточної категорії "type_of_agreement"
        $newTerms = get_terms(array(
            'taxonomy' => $subCat,
            'hide_empty' => true,

            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => $mainCat,
                    'terms' => get_queried_object_id(),
                    'compare' => 'IN'
                ),
                array(
                    'taxonomy' => $subCat,
                    'compare' => 'IN'
                )
            )
        ));
        $taxonomyShow = $nextTax ? $nextTax : $subCat;

        $args = array(
            'post_type' => 'taxonomy',
            'taxonomy' => $taxonomyShow,
            'hide_empty' => true,
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'type_of_agreement',
                    'field' => 'term_id',
                    'terms' => get_queried_object_id(),
                    'compare' => 'IN'
                ),
                array(
                    'taxonomy' => $taxonomyShow,
                    'hide_empty' => true,
                    'compare' => 'IN'
                )
            )
        );
        if (!empty($nextTax)) {
            $args['tax_query'][] = array(
                'taxonomy' => $mainCat,
                'hide_empty' => true,
                'compare' => 'IN'
            );
        }

        $test = get_terms($args);


        $newTerms = $test;
        // виводимо список категорій
        if (!empty($newTerms) && !$ThirdNesting) {
            echo '<ul  class="list_category">';
            foreach ($newTerms as $term) {

                // рахуємо кількість об'єктів які входять в обидві категорії
                $real_estate_count = 0;
                $argsNew = array(
                    'post_type' => 'real_estate',
                    'tax_query' => array(
                        'relation' => 'AND',
                        array(
                            'taxonomy' => 'type_of_agreement',
                            'field' => 'slug',
                            'terms' => $firstCat,
                            'compare' => 'IN'
                        ),
                        array(
                            'taxonomy' => $taxonomyShow,
                            'field' => 'slug',
                            'terms' => $term->slug,
                            'compare' => 'IN'
                        ),

                    ),
                    'posts_per_page' => -1
                );


                if (!empty($nextTax)) {
                    $argsNew['tax_query'][] =   array(
                        'taxonomy' => $mainCat,
                        'field' => 'slug',
                        'terms' => $getSelectedCategory,
                        'compare' => 'IN'
                    );
                }

                $query = new WP_Query($argsNew);

                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        $real_estate_count++;
                    }
                }

                wp_reset_postdata();


                if ($real_estate_count != 0) {

                    echo '<li><a href="' . ($catSlugUrl ? $catSlugUrl : get_term_link($terms)) . $term->slug . '">' . $term->name . ' (' . $real_estate_count . ')</a></li>';
                }
            }
            echo '</ul>';
        }

        ?>

        <div class="real-estate-objects real-estate-single-category">

            <?php while ($items->have_posts()) : $items->the_post(); ?>


                <div class="real-estate__item">

                    <?php $image_id = get_post_thumbnail_id();
                    $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
                    ?>


                    <?php if ($image = get_attached_img_url(get_the_ID(), 'medium')): ?>
                        <div class="img-wrapper">
                            <img src="<?= $image; ?>" alt="<?= $image_alt; ?>">
                            <div class="real-estate-objects__links">
                                <?php
                                $taxonomy = 'type_of_agreement';
                                $terms = get_terms($taxonomy);

                                if ($terms) {
                                    foreach ($terms as $term) {
                                        if (has_term($term->slug, $taxonomy)) {

                                            $titleCat = '';
                                            switch ($term->name) {
                                                case 'Sale':
                                                    $titleCat = 'Buy';
                                                    break;
                                                default:
                                                    $titleCat = $term->name;
                                            }
                                            ?>


                                            <?php if ($link = get_term_link($term->slug, $taxonomy)): ?>
                                                <a class="cat_link cat_link-first" href="<?php echo $link; ?>"><?php _e(strtoupper($titleCat), 'test'); ?></a>
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
                                            if ($link = get_term_link($term->slug, $taxonomy)): ?>
                                            <?php

                                                $customLink = '';
                                                if($catSlugUrl != ''){

                                                    if (sizeof($pathUrl) >= 2) {
                                                        $customLink = $catSlugUrl;
                                                    } else {

                                                        $customLink = $catSlugUrl.$term->slug;
                                                    }

                                                }

                                            ?>
                                                <a class="cat_link cat_link-second" href="<?= $customLink; ?>"><?php _e(strtoupper($titleCat), 'test'); ?></a>
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
    </div>
<?php endif;
wp_reset_query(); ?>





<?php get_footer(); ?>