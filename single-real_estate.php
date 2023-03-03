<?php
/**
 * Page
 */
get_header(); ?>


    <main class="main-content">

        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <div class="container">
                    <article <?php post_class(); ?>>
                        <div class="object">
                            <?php if (has_post_thumbnail()) : ?>
                                <div title="<?php the_title_attribute(); ?>" class="thumbnail">
                                    <?php the_post_thumbnail('large'); ?>

                                    <div class="links">
                                        <?php
                                        $titleCat = '';
                                        $titleSlug = '';
                                        $taxonomy = 'type_of_agreement';
                                        $terms = get_terms($taxonomy);
                                        //                                var_dump($terms);
                                        if ($terms) {
                                            foreach ($terms as $term) {
                                                if (has_term($term->slug, $taxonomy)) {

                                                    $titleCat = $term->name;
                                                    $titleSlug = $term->slug;
                                                    ?>


                                                    <?php if ($link = get_term_link($term->slug, $taxonomy)): ?>
                                                        <a class="cat_link cat_link-first"
                                                           href="<?php echo $link; ?>"><?php _e(strtoupper($titleCat), 'test'); ?></a>
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
                            <div class="object__costs">
                                <?php if (get_field('property_ref_no')): ?>
                                    <p class="object-details__label"><?php _e('Unit Reference: ', 'test'); ?><span
                                                id="property_ref_no"><?php the_field('property_ref_no'); ?></span></p>
                                <?php endif; ?>

                                <?php $price = get_field('price'); ?>
                                <?php if ($price): ?>
                                    <p class="price"><?= number_format($price); ?> AED</p>

                                    <?php $request = wp_remote_get('https://api.metropolitan.realestate/currency/?key=testMetropolitanWP');
                                    $body = wp_remote_retrieve_body($request);
                                    $data = json_decode($body);
                                    $exchangeRate = $data->AED_USD;
                                    ?>
                                    <p class="price-usd"><?= number_format(round($price * $exchangeRate, 0)); ?> USD</p>
                                <?php endif; ?>


                                <?php ?>


                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        var customFieldValue = document.getElementById('property_ref_no').textContent;
                                        var form = document.getElementById('test');
                                        form.value = customFieldValue;
                                    });
                                </script>

                                <?php if (get_field('contact_form')): ?>
                                    <a href="#contact-form" data-fancybox
                                       class="btn"><?= _e('Leave a Request', 'test'); ?></a>
                                    <div class="contact-form__wrapper" style="display: none" id="contact-form">
                                        <?php if (get_field('title_popup', 'option')): ?>
                                            <p><?php the_field('title_popup', 'option'); ?></p>
                                        <?php endif; ?>
                                        <?php if (get_field('subtitle_popup', 'option')): ?>
                                            <p><strong><?php the_field('subtitle_popup', 'option'); ?></strong></p>
                                        <?php endif; ?>
                                        <?php echo get_field('contact_form'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="object__information">
                                <h1 class="object__title"><?php the_title(); ?></h1>
                                <a href="#map-single" data-fancybox
                                   class="object__map">
                                    <svg width="13" height="15" viewBox="0 0 13 15" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12.4545 6.22727C12.4545 10.6818 6.72727 14.5 6.72727 14.5C6.72727 14.5 1 10.6818 1 6.22727C1 4.70831 1.60341 3.25155 2.67748 2.17748C3.75155 1.10341 5.20831 0.5 6.72727 0.5C8.24624 0.5 9.70299 1.10341 10.7771 2.17748C11.8511 3.25155 12.4545 4.70831 12.4545 6.22727Z"
                                              stroke="#222222" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M6.7294 7.81818C7.78377 7.81818 8.63849 6.96345 8.63849 5.90909C8.63849 4.85473 7.78377 4 6.7294 4C5.67504 4 4.82031 4.85473 4.82031 5.90909C4.82031 6.96345 5.67504 7.81818 6.7294 7.81818Z"
                                              stroke="#222222" stroke-linecap="round" stroke-linejoin="round"/>
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
                                        <span id="map-single" class="map-container">
                                    <span class="acf-map" data-zoom="16">
                                        <span class="marker" data-lat="<?php echo esc_attr($lat); ?>"
                                              data-lng="<?php echo esc_attr($lng); ?>"></span>
                                    </span>
                                </span>
                                        <?php $counter++; ?>
                                    <?php endif; ?>


                                </a>


                                <div class="object__description">

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


                                    <?php if (get_field('parking')): ?>
                                        <div class="parking details-item">
                                            <p><?php _e('Attached Garage', 'test'); ?></p>
                                            <span><?php _e('Parking', 'test'); ?></span>
                                        </div>
                                    <?php endif; ?>

                                </div>

                                <div class="object__details">

                                    <h2><?php _e('Project Details', 'test'); ?></h2>

                                    <div class="object__list">
                                        <?php if (get_field('property_ref_no')): ?>
                                            <p class="list-label"><?php _e('Unit Reference', 'test'); ?></p>
                                            <p class="list-value"><?php the_field('property_ref_no'); ?></span></p>
                                        <?php endif; ?>
                                        <?php if (get_field('parking')): ?>
                                            <p class="list-label"><?php _e('Parking Slot', 'test'); ?></p>
                                            <p class="list-value"><?php the_field('parking'); ?></span></p>
                                        <?php endif; ?>
                                        <?php if (get_field('property_name')): ?>
                                            <p class="list-label"><?php _e('Property Name', 'test'); ?></p>
                                            <p class="list-value"><?php the_field('property_name'); ?></span></p>
                                        <?php endif; ?>

                                        <?php if (get_field('ad_type')): ?>
                                            <?php
                                            $term_id = get_field('ad_type');
                                            $taxonomy = 'type_of_agreement';
                                            $category_name = '';
                                            $term = get_term_by('id', $term_id, $taxonomy);
                                            if ($term) {
                                                $category_name = $term->name;
                                            }
                                            ?>
                                            <p class="list-label"><?php _e('Purpose', 'test'); ?></p>
                                            <p class="list-value"><?= _e('For ', 'test'); ?><?= strtolower($category_name); ?></span></p>
                                        <?php endif; ?>

                                        <?php if (get_field('listing_date')): ?>
                                            <?php
                                            $dateString = get_field('listing_date');
                                            $date = DateTime::createFromFormat('Y-m-d h:i:s A', $dateString);
                                            $formattedDate = $date->format('j F Y');
                                            ?>
                                            <p class="list-label"><?php _e('Addeed on', 'test'); ?></p>
                                            <p class="list-value"><?= $formattedDate; ?></span></p>
                                        <?php endif; ?>


                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php show_template('flexible/part-category_slider', array('cat' => $titleSlug, 'title' => 'Similar Property', 'propertyName' => get_field('property_name'), 'postId' => get_the_ID())) ?>
                </div>
                </article>
            <?php endwhile; ?>
        <?php endif; ?>

    </main>

<?php get_footer(); ?>