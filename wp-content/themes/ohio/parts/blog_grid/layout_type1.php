<?php

$ohio_post = OhioHelper::get_storage_item_data();
global $post;
$anim_attrs = '';
if (in_array($ohio_post['animation_type'], array('sync', 'async'))) {
    OhioHelper::add_required_script( 'aos' );

    $anim_attrs .= ' data-aos-once="true"';
    $anim_attrs .= ' data-aos="' . esc_attr($ohio_post['animation_effect']) . '"';
    if ($ohio_post['animation_type'] == 'async') {
        $anim_attrs .= '';
    }
}
if( isset( $ohio_post['meta_visibility'] ) && is_array( $ohio_post['meta_visibility'] ) ) extract( $ohio_post['meta_visibility'] );

$blog_grid_class = '';
if (in_array('sticky', get_post_class('', $ohio_post['post_id']))) {
    $blog_grid_class .= ' sticky';
}
if ($ohio_post['boxed']) {
    $blog_grid_class .= ' boxed';
}
if ($ohio_post['media']['blockquote']) {
    $blog_grid_class .= ' type-blockquote';
}
if ($ohio_post['media']['audio']) {
    $blog_grid_class .= ' type-audio';
}
if (!$ohio_post['preview']) {
    $blog_grid_class .= ' no-preview';
}
if ( $ohio_post['metro_style'] ) {
    $blog_grid_class .= ' metro-style';
}
if (!has_post_thumbnail() && strpos($post->post_content,'[gallery') === false){
    $blog_grid_class .= ' without-media';
}

$hover_effect = $ohio_post['hover_effect'];
$parallax_class = "";

switch ($hover_effect) {
    case 'type2':
        $hover_effect_class = 'hover-color-overlay';
        break;
    case 'type3':
        $hover_effect_class = 'hover-greyscale';
        break;
    case 'type4':
        $hover_effect_class = 'hover-parallax-img';
        $parallax_class = 'parallax-holder';
        break;
    default:
        $hover_effect_class = 'hover-scale-img';
        break;
}

?>
<div class="blog-grid blog-grid-type-1<?php echo esc_attr($blog_grid_class); ?> <?php echo esc_attr($hover_effect_class) ?>" <?php echo esc_attr($anim_attrs); ?>>
    <figure class="blog-grid-image">
        <?php if ($ohio_post['media']['video']) : // Video format ?>
            <?php vprintf('%s', $ohio_post['media']['video']); ?>

        <?php elseif ($ohio_post['media']['audio']) : // Audio format ?>
            <?php vprintf('%s', $ohio_post['media']['audio']); ?>

        <?php elseif ($ohio_post['media']['gallery']) : // Gallery format ?>
            <?php vprintf('%s', $ohio_post['media']['gallery']); ?>

        <?php elseif ($ohio_post['media']['blockquote']) : // Blockquote format ?>
            <?php $ohio_post['preview'] = wp_kses($ohio_post['media']['blockquote'], 'post'); ?>

        <?php elseif ($ohio_post['media']['image']) : // Feature image format ?>

            <a data-cursor-class="cursor-link" class="<?php echo esc_attr( $parallax_class ); ?>" href="<?php echo esc_url($ohio_post['url']); ?>">
                <?php if ( $ohio_post['media']['image'] && !$ohio_post['metro_style'] ) : ?>
                    <img class="parallax" src="<?php echo esc_url($ohio_post['media']['image']); ?>"
                     alt="<?php echo esc_attr($ohio_post['title']); ?>">
                <?php else: ?>
                    <div class="blog-metro-image parallax" <?php if ( $ohio_post['metro_style'] ) { echo ' data-ohio-bg-image="' . esc_url( $ohio_post['media']['image'] ) . '"'; } ?>></div>
                <?php endif; ?>
            </a>

        <?php endif; ?>

        <div class="blog-grid-meta">
            <?php if ( $author_visibility ) : ?>
                <div class="meta-holder">
                    <?php echo get_avatar( get_the_author_meta('email'), '50', true, get_the_author(), array('class' => 'author-avatar') ); ?>
                    <div class="author-attributes">
                        <div class="author"><?php esc_html_e('Posted by', 'ohio'); ?> <b><?php echo esc_html($ohio_post['author']); ?></b></div>
                        <span class="date"><?php echo esc_html($ohio_post['date']); ?></span>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </figure>

    <div class="blog-grid-content text-<?php echo esc_attr($ohio_post['alignment']); ?>">
        <div class="post-details">
            <?php if ( $category_visibility ) : ?>
                <div class="category-holder">
                    <?php if (in_array('sticky', get_post_class('', $ohio_post['post_id']))) : ?>
                        <span class="category category-sticky"><?php esc_html_e('Featured', 'ohio'); ?></span>
                    <?php endif; ?>

                    <?php foreach ($ohio_post['categories'] as $_category) : ?>
                        <a class="category" href="<?php echo esc_url(get_category_link($_category->cat_ID)); ?>"><?php echo esc_html($_category->name); ?></a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if ( $reading_time_visibility ) : ?>
                <span class="post-meta-estimate">
                    <?php echo esc_html($ohio_post['reading_estimate']) . ' ' . esc_html__( 'min read', 'ohio' ); ?>
                </span>
            <?php endif; ?>
        </div>
        <h3 class="blog-grid-headline">
            <?php if (in_array('sticky', get_post_class('', $ohio_post['post_id']))) : ?>
                <svg class="sticky-icon" width="14" height="20" viewBox="0 0 14 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.6667 2.22222V15.6667L8.4 13.4444L7 12.5556L5.6 13.4444L2.33333 15.6667V2.22222H11.6667ZM14 0H0V20L7 15.2222L14 20V0Z" fill="#232226"/></svg>
            <?php endif; ?>
            <a class="underline" href="<?php echo esc_url($ohio_post['url']); ?>">
                <?php echo esc_html($ohio_post['title']); ?>
            </a>
        </h3>

        <?php if ( $short_description_visibility ) : ?>
            <?php
            if (preg_match('/<!--more(.*?)?-->/', $post->post_content)) {
                echo '<p>';
                $allowed_html = array(
                    'a' => array(
                        'href'  => true,
                        'title' => true,
                        'class' => true
                    ),
                    'br'     => array(),
                );
                echo wp_kses(get_the_content(), $allowed_html);
                echo '</p>';
            } elseif ($ohio_post['media']['blockquote']) {
                echo wp_kses($ohio_post['media']['blockquote'], 'post');
            } else {
                the_excerpt();
            }
            ?>
        <?php endif; ?>

        <?php if ( $read_more_visibility ) : ?>
            <a href="<?php echo esc_url($ohio_post['url']); ?>" class="btn btn-link brand-color-hover">
                <?php esc_html_e( 'Read More', 'ohio' ); ?>
                <i class="ion-right ion"><svg class="arrow-icon" width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 7H16M16 7L11 1M16 7L11 13" stroke-width="2"/></svg></i>
            </a>
        <?php endif; ?>
    </div>
</div>