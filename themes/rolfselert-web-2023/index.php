<?php
get_header();

// Page Hero
$splash_video = get_field( 'splash_video', 'option' );
$main_video   = get_field( 'main_video_vimeo_id', 'option' );
$mp4_file     = $splash_video[0]['mp4_file'];
$ogg_file     = $splash_video[0]['ogg_file'];
$webm_file    = $splash_video[0]['webm_file'];
$mobile_image = $splash_video[0]['mobile_image'];

// Featured Work
$featured_work = get_field( 'featured_work', 'option' );

// WIP module
$use_work_in_progress_page = get_field( 'use_work_in_progress_page', 'option' ) ?? false;
$projects                  = [];
$progress_page             = '';
$work_page                 = get_field( 'work_page', 'option' );

if ( $use_work_in_progress_page ) {
    $progress_page = get_field( 'work_in_progress_page', 'option' );
    $projects      = get_field( 'projects', $progress_page );
} else {
	$work_in_progress_list = get_field( 'work_in_progress', 'option' );
}
?>
<article id="page" class="page page--home">
    <div class="pageHero">
        <div class="pageHero_inner">
            <?php if (!isMobile()) : ?>
                <div class="pageHero_video"<?php if (!empty($main_video)) : ?> data-js-component="heroVideo"<?php endif; ?>>
                    <div class="pageHero_video_inner">

                        <video class="pageHero_video--splash js--heroVideo_splash" autoplay loop muted>
                            <?php if (!empty($mp4_file)) : ?>
                                <source src="<?= $mp4_file['url']; ?>" type="video/mp4"/>
                            <?php endif; ?>
                            <?php if (!empty($ogg_file)) : ?>
                                <source src="<?= $ogg_file['url']; ?>" type="video/ogg"/>
                            <?php endif; ?>
                            <?php if (!empty($webm_file)) : ?>
                                <source src="<?= $webm_file['url']; ?>" type="video/webm"/>
                            <?php endif; ?>
                        </video>
                        <div class="pageHero_video_mask"></div>

                        <?php if (!empty($main_video)) : ?>
                            <div class="pageHero_video--main js--heroVideo_main videoWrapper">
                                <iframe src="https://player.vimeo.com/video/<?= $main_video; ?>?api=1&amp;player_id=heroVideo_main&amp;color=ffffff&amp;portrait=0&amp;badge=0&amp;badge=0&amp;title=0&amp;byline=0&amp;portrait=0"
                                        id="heroVideo_main"
                                        class="videoWrapper_video js--videoTrigger_iframe js--heroVideo_iframe"
                                        frameborder="0"
                                        height="100%"
                                        width="100%"
                                        webkitallowfullscreen
                                        mozallowfullscreen
                                        allowfullscreen></iframe>
                                <div class="videoWrapper_poster js--heroVideo_trigger"
                                     data-js-component="videoTrigger"></div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else : ?>
                <?php if (!empty($webm_file)) : ?>
                    <img src="<?= $mobile_image['sizes']['hero-image']; ?>"
                         alt=""
                         class="pageHero_image js--fadeImage"
                         data-js-component="fadeImage"/>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <div id="work" class="page_module page_module--featured_work">
        <div class="contentWrapper" data-fade="in">
            <header class="moduleHeader">
                <h2>Featured Work</h2>
            </header>
            <div class="featured_work">
                <?php
                foreach ($featured_work as $work) :
                    $project = $work['project'][0];
                    $permalink = get_permalink($project->ID);
                    $image = $work['image']['sizes']['featured-work'];
                    ?>
                    <div id="featured_work_item--<?= $project->ID; ?>"
                         class="featured_work_item<?php if (!$project): ?> featured_work_item--no-project<?php endif; ?>">
                        <div class="featured_work_inner">
                            <img src="<?= $image; ?>" alt="<?= $project->post_title; ?>" class="featured_work_image"/>
                            <h3 class="featured_work_title">
                                <?php if ($project): ?>
                                <a href="<?= $permalink; ?>" data-pjax>
                                    <?php endif; ?>
                                    <?= $project->post_title; ?>
                                    <?php if ($project): ?>
                                </a>
                            <?php endif; ?>
                            </h3>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- NEW SEE MORE BUTTON-->
            <a href="<?= get_permalink( $work_page ) ?>" class="featured-work__link">
                <span>see all work</span>
                <i class="featured-work__arrow"></i>
<!--                <i class="featured-work__link-icon">-->
<!--                    --><?php //= file_get_contents(get_template_directory() . '/img/arrow-right.svg'); ?>
<!--                </i>-->
            </a>
            <!-- END SEE MORE BUTTON-->

        </div>
    </div>

    <?php if ( ! empty( $projects ) ) { ?>
        <div id="wip" class="page_module page_module--wip">
        <div class="contentWrapper">
            <header class="moduleHeader">
                <h2>Work in progress</h2>
            </header>
            <div class="wip">
                <div class="wip__wrap">
                    <?php
                    foreach ( $projects as $key => $project ) {
                        if ( $key > 4 ) {
                            break;
                        }
                    ?>
                        <a href="<?= get_permalink( $progress_page ) ?>?id=<?= $key ?>" class="wip__box" data-pjax>
                            <img src="<?= $project['hero'] ?>" alt="<?= $project['title'] ?>" class="wip__image"/>
                            <span class="wip__title">
                                <?= $project['title'] ?>
                            </span>
                        </a>
                    <?php } ?>
                </div>
            </div>
            <a href="<?= get_permalink( $progress_page ) ?>" class="wip__link">
                <span>see all work in progress</span>
                <i class="wip__arrow"></i>
                <!--                <i class="wip__link-icon">-->
<!--                    --><?php //= file_get_contents(get_template_directory() . '/img/arrow-right.svg'); ?>
<!--                </i>-->
            </a>
        </div>
    </div>
    <?php } ?>

    <?php
    /*
      About
    */
    $about_text = get_field('about_text', 'option');
    ?>

    <div id="about" class="page_module page_module--about">
        <div class="contentWrapper">
            <!--      <header class="moduleHeader">-->
            <!--        <h2>About</h2>-->
            <!--      </header>-->
            <div class="about_text">
                <?= $about_text; ?>
            </div>
        </div>
    </div>

    <?php
    /*
      Partners
    */
    $partners = get_field('partners', 'option');
    ?>
    <div class="page_module page_module--partners page_module--alt">
        <div class="contentWrapper">
            <div class="partners">
                <?php
                $i = 1;
                foreach ($partners as $partner) : ?>
                    <div class="partners_item" <?php if ($i % 2 == 0) : ?>data-fade="right"
                         <?php else : ?>data-fade="left"<?php endif; ?>>
                        <h3><?= $partner['name']; ?> – <?= $partner['title']; ?></h3>
                        <?php if ($partner['image']) : ?>
                            <div class="partners_media">
                                <div class="media_wrap media_wrap--headshot">
                                    <img src="<?= $partner['image']['sizes']['headshot']; ?>"
                                         alt="<?= $partner['name']; ?> – <?= $partner['title']; ?>"/>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="partners_text">
                            <?= $partner['text']; ?>
                        </div>
                    </div>
                    <?php
                    $i++;
                endforeach; ?>
            </div>
        </div>
    </div>

    <?php
    /*
      Contacts
    */
    $contacts = get_field('contacts', 'option');
    ?>
    <div id="contact" class="page_module page_module--cto">
        <div class="contentWrapper">
            <header class="moduleHeader">
                <h2>Contact</h2>
            </header>
            <div class="contact">
                <?php
                foreach ($contacts as $contact) :
                    $image = $contact['icon']['url'];
                    $type = '';

                    if ($contact['contact_info'][0]['type'] === 'contact_email: Email Link') {
                        $linkAtrib = 'mailto:' . $contact['contact_info'][0]['link'];
                    } else if ($contact['contact_info'][0]['type'] === 'contact_phone: Phone Number') {
                        $linkAtrib = 'tel:' . $contact['contact_info'][0]['link'];
                    } else {
                        $linkAtrib = $contact['contact_info'][0]['link'];
                    }

                    ?>
                    <div class="contacts_item" data-fade="up" data-delay-buffer="150" class="">
                        <a href="<?= $linkAtrib ?>">
                            <div class="iconContain">
                                <img src="<?= $image; ?>" alt="" class="contacts_icon"/>
                            </div>
                            <div class="contacts_item_text">
                                <?= $contact['text']; ?>
                            </div>
                        </a>
                    </div>
                <?php
                endforeach;
                ?>
            </div>
        </div>
    </div>

    <?php
    /*
      Call to Action
    */
    $cta = get_field('cta', 'option');
    ?>
    <div class="page_module page_module--cta page_module--alt">
        <div class="cta_text" data-fade="true">
            <?= $cta; ?>
        </div>
    </div>
</article>
<?php get_footer(); ?>
