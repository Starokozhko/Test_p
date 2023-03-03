<?php if ( have_rows( 'sections' ) ): ?>

    <?php while ( have_rows( 'sections' ) ): the_row(); ?>

        <?php if ( get_row_layout() ): ?>
            <?php if ( get_sub_field( 'switcher' ) == 'on' ): ?>
                <?php show_template( 'flexible/part-' . get_row_layout() ) ?>
            <?php endif; ?>
            <?php //elseif ( get_row_layout() == 'image' ): ?>

        <?php endif; ?>
    <?php endwhile; ?>
<?php endif; ?>
