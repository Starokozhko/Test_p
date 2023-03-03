<?php
/**
 * Template Name: Home Page
 */
get_header(); ?>

<?php $heroModifi = ''; ?>
<?php if (have_rows('sections')): ?>
    <?php while (have_rows('sections')): the_row(); ?>
        <?php if (get_row_layout() == 'hot'): ?>
            <?php $heroModifi = 'with_hot' ?>
        <?php endif; ?>
    <?php endwhile; ?>
<?php endif; ?>

    <div class="hero <?= $heroModifi; ?>">
        <div class="container">
            <?php if (get_the_title()): ?>
                <div class="hero__content text-center">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                </div>
            <?php endif; ?>
        </div>
    </div>


    <div class="container">
        <?php show_template('part-flexible'); ?>
    </div>


<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <?php if (get_the_content() != ''): ?>
            <!-- BEGIN of main content -->
            <div class="container">
                <div class="row col">
                    <?php the_content(); ?>
                </div>
            </div>
            <!-- END of main content -->
        <?php endif; ?>
    <?php endwhile; ?>
<?php endif; ?>


<?php get_footer(); ?>