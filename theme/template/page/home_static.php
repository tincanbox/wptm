<div class="theme-font-color">

<?php
$index = 0;
$slugs = explode(',', WPTM::option('top_static_primary_posts'));
foreach ($slugs as $slug) { ?>
    <?php

    $slug = trim($slug);
    $post = get_page_by_path($slug);

    if(empty($post)) continue;

    $ratio = 75;
    $args = ['name' => $slug, 'post_type' => 'post', 'post_status' => 'publish', 'numberposts' => 1];
    $index ++;
    ?>

    <div class="inner-content comfortable">

        <div class="app-promo-section row">
            <div class="col-12 col-md-5 <?php echo ($index % 2 === 0) ? 'd-block' : 'd-md-none' ; ?>">
                <div
                    class="d-none d-md-block app-section-catch-image"
                    style="padding-bottom: 75%; background-image:url('<?php echo get_the_post_thumbnail_url($post); ?>');"
                    >
                </div>
                <div
                    class="d-block d-md-none app-section-catch-image"
                    style="padding-bottom: 88%; background-image:url('<?php echo get_the_post_thumbnail_url($post); ?>');"
                    >
                </div>
            </div>
            <div class="d-md-none" style="padding:1rem;"></div>
            <div class="col-12 col-md-7" style="align-self: center;">
                <h5 class="app-caption" style="margin-bottom: 1.25rem;">
                    <img class="app-caption-acce" src="<?php echo get_bloginfo('template_directory') . "/static/image/caption-left.png"; ?>">
                    <span><?php
                        echo get_the_title($post);
                    ?></span>
                    <img class="app-caption-acce" src="<?php echo get_bloginfo('template_directory') . "/static/image/caption-right.png"; ?>">
                </h5>

                <p class="app-section-excerpt" style="min-height: 4.8rem; line-height: 2.4rem;">
                <?php echo get_the_excerpt($post); ?>
                </p>

                <div class="text-right">
                    <a class="app-view-more font-ornament" href="<?php echo get_permalink($post); ?>">VIEW MORE &raquo;</a>
                </div>

            </div>
            <div class="col-12 col-md-5 d-none <?php echo ($index % 2 === 0) ? '' : 'd-md-block' ; ?>">
                <div
                    class="d-none d-md-block app-section-catch-image"
                    style="padding-bottom: 75%; background-image:url('<?php echo get_the_post_thumbnail_url($post); ?>');"
                    >
                </div>
                <div
                    class="d-block d-md-none app-section-catch-image"
                    style="padding-bottom: 88%; background-image:url('<?php echo get_the_post_thumbnail_url($post); ?>');"
                    >
                </div>
            </div>
        </div>

    </div>
<?php } ?>

<?php

$wp_query = new WP_Query(array_merge(array(
  'posts_per_page'   => 4,
  #'offset'           => 0,
  #'category'         => '',
  'orderby'          => 'date',
  'order'            => 'DESC',
  #'include'          => '',
  #'exclude'          => '',
  #'meta_key'         => '',
  #'meta_value'       => '',
  'post_type'        => 'topic',
  #'post_mime_type'   => '',
  #'post_parent'      => '',
  #'author'     => '',
  'post_status'      => 'publish',
  'suppress_filters' => true
), @$query ? $query : array()));

$posts = $wp_query->get_posts();
$post_type_option = WPTM::option('post_type.topic');

?>
<div class="inner-content">

    <div class="row">
        <div class="col-12">
            <div class="app-normal-content app-contact-method">
                <h5 class="app-caption" style="margin-bottom: 1.25rem;">
                    <img class="app-caption-acce" src="<?php echo get_bloginfo('template_directory') . "/static/image/caption-left.png"; ?>">
                    <span>TOPICS</span>
                    <img class="app-caption-acce" src="<?php echo get_bloginfo('template_directory') . "/static/image/caption-right.png"; ?>">
                </h5>

                <?php foreach ($posts as $post) { ?>
                    <div class="app-content-row">
                        <a class="link animatable theme-font-color"
                            href="<?php echo get_the_permalink($post); ?>"
                            >
                            <?php if (WPTM::option('post_show_date') && @$post_type_option['show_date']) { ?>
                                <span class="font-ornament">
                                    <?php echo get_the_date(null, $post); ?>
                                </span>
                            <?php } ?>
                            <?php if (WPTM::option('post_show_time') && @$post_type_option['show_time']) { ?>
                                <span>
                                    <?php echo get_the_time(null, $post); ?>
                                </span>
                            <?php } ?>
                            <span>&nbsp; | &nbsp;</span>
                            <?php echo get_the_title($post); ?>
                        </a>
                    </div>
                <?php } ?>

                <div class="text-right">
                    <a class="app-view-more font-ornament" href="<?php echo get_post_type_archive_link('topic'); ?>">VIEW MORE &raquo;</a>
                </div>

            </div>
        </div>
    </div>

</div>

<?php
$slugs = explode(',', WPTM::option('top_static_secondary_posts'));
foreach ($slugs as $slug) {
    $slug = trim($slug);
    $page = get_page_by_path($slug);

    if (empty($page)) continue; 

    ?>
    <div class="inner-content">

        <div class="row">
            <div class="col-12">
                <div class="app-normal-content">
                    <h5 class="app-caption" style="margin-bottom: 1.25rem;">
                        <img class="app-caption-acce" src="<?php echo get_bloginfo('template_directory') . "/static/image/caption-left.png"; ?>">
                        <span><?php echo get_the_title($page); ?></span>
                        <img class="app-caption-acce" src="<?php echo get_bloginfo('template_directory') . "/static/image/caption-right.png"; ?>">
                    </h5>

                    <div class="app-content-row">
                        <span
                            class="animatable theme-font-color"
                            >
                            <?php echo $page->post_excerpt; ?>
                        </span>
                    </div>

                    <div class="text-right">
                        <a
                            class="app-view-more font-ornament"
                            href="<?php echo get_permalink( get_page_by_path( $slug ) ); ?>">VIEW MORE &raquo;</a>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <?php

}


$contact = get_page_by_path( 'contact' );

if ($contact) {
    ?>
    <div class="inner-content">

        <div class="row">
            <div class="col-12">
                <div class="app-normal-content app-contact-method">
                    <h5 class="app-caption" style="margin-bottom: 1.25rem;">
                        <img class="app-caption-acce" src="<?php echo get_bloginfo('template_directory') . "/static/image/caption-left.png"; ?>">
                        <span>CONTACT</span>
                        <img class="app-caption-acce" src="<?php echo get_bloginfo('template_directory') . "/static/image/caption-right.png"; ?>">
                    </h5>
                    <div class="app-content-row">
                        <span><?php echo $contact->post_excerpt; ?></span>
                    </div>
                    <div style="text-align:center;">
                        <a href="<?php echo get_permalink($contact); ?>" class="app-contact-button link button type1" style="font-size: 1.2rem; margin-top: 1.6rem;">
                            <span>お問い合わせページ</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php

}

?>
</div>
