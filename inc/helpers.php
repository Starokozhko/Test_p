<?php
/**
 * Output HTML markup of template with passed args
 *
 * @param string $file File name without extension (.php)
 * @param array $args Array with args ($key=>$value)
 * @param string $default_folder Requested file folder
 *
 * */
function show_template( $file, $args = null, $default_folder = 'parts' ) {
	echo return_template( $file, $args, $default_folder );
}
/**
 * Return HTML markup of template with passed args
 *
 * @param string $file File name without extension (.php)
 * @param array $args Array with args ($key=>$value)
 * @param string $default_folder Requested file folder
 *
 * @return string template HTML
 * */
function return_template( $file, $args = null, $default_folder = 'parts' ) {
    $file = $default_folder . '/' . $file . '.php';
    if ( $args ) {
        extract( $args );
    }
    if ( locate_template( $file ) ) {
        ob_start();
        include( locate_template( $file ) ); //Theme Check free. Child themes support.
        $template_content = ob_get_clean();

        return $template_content;
    }

    return '';
}

/**
 * Get Post Featured image
 *
 * @var int $id Post id
 * @var string $size = 'full' featured image size
 *
 * @return string Post featured image url
 */
function get_attached_img_url( $id = 0, $size = "medium_large" ) {
    $img = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), $size );

    return $img[0];
}