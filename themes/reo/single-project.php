<?php get_header(); ?>
<article id="page" class="page page--project">
  <?php
    /*
      The Loop
    */
    if ( have_posts() ) :
      while ( have_posts() ) :
        the_post(); ?>

        <?php
        /*
          Page Hero
        */

        $hero = get_field( 'page_hero' );
        $video = get_field( 'page_video' );

        if ( empty( $video ) ) : ?>
          <div class="pageHero">
            <div class="pageHero_inner">

                <?php if (!empty($hero)) :
                  $hero_image = $hero[0]['image']['sizes']['hero-image'];
                ?>
                <img src="<?= $hero_image; ?>"
                     alt=""
                     class="pageHero_image js--fadeImage"
                     data-js-component="fadeImage" />
              <?php endif; ?>
            <a href="#" class="pageHero_more"></a>
          </div>
        </div>


        <?php
        else: ?>

          <div class="pageHero videoPopoutPlayer">
            <div class="pageHero_inner" data-js-component="videoPopoutPlayer" data-id="<?= $video[0]['video_id']; ?>">
                <img class="popoutPlay" src="<?php echo get_template_directory_uri(); ?>/img/newPlay.svg" width="" height="" alt="" />

                <video class="pageHero_video--splash js--heroVideo_splash js--videoPopoutPlayer" autoplay loop muted>
                  <source src="<?= $video[0]['video']['url']; ?>" type="video/mp4" />
                </video>

                <?php
                  $hero_image = $hero[0]['image']['sizes']['hero-image'];
                ?>

                <img src="<?= $hero_image; ?>"
                     alt=""
                     class="pageHero_image js--fadeImage"
                     data-js-component="fadeImage" />


                <div class="pageHero_video_mask"></div>
            </div>
            <a href="#" class="pageHero_more"></a>
          </div>

        <?php
        endif
        ?>


        <?php
        /*
          Page Header
        */
          $intro = get_field('intro_module');

        ?>

        <div class="introModule" data-js-component="introModule">
          <div class="introModule_content">
            <h1><?= $intro[0]['title']?></h1>
            <div class="lead lead--large">
              <?= $intro[0]['lead_large']?>
            </div>
            <div class="lead lead--small">
              <?= $intro[0]['lead_small']?>
            </div>
          </div>
        </div>


        <!-- <header class="pageHeader">
          <div class="contentWrapper">

          </div>
        </header> -->
<?php
        /*
          Page Modules
        */
        $modules = get_field('page_modules');
        $i = 0;
        foreach ($modules as $module) :
          $template = 'partials/page_modules-' . $module['acf_fc_layout'] . '.php';
          $has_rule = ($modules[$i+1]['acf_fc_layout'] == 'horizontal_rule') ? true : false;
          if ( file_exists(dirname(__FILE__) . '/'. $template) ) :

echo '<!-- =============== ' . $module['acf_fc_layout'] . ' =============== -->
';
?>
          <div class="page_module page_module--<?= $module['acf_fc_layout']; ?><?php if ($has_rule) :?> page_module--rule<?php endif;?><?php if ($module['acf_fc_layout'] == 'quote') :?> page_module--alt<?php endif;?>">
            <div class="contentWrapper">
              <?php include ($template); ?>
            </div>
          </div>

        <?php
          endif;
          $i++;
        endforeach;
      ?>

</article>

<div class="popout_overlay">
  <div class="popout_container">
  <div class="video_popout">
    <iframe src="https://player.vimeo.com/video/<?= $video[0]['video_id']; ?>"
                     id="heroVideo_main"
                     class="videoWrapper_video singlePage_video"
                     frameborder="0"
                      width="560" height="349"
                     webkitallowfullscreen
                     mozallowfullscreen
                     allowfullscreen>
    </iframe>
  </div>
  </div>
</div>

  <?php
      endwhile;
    endif;
  ?>
<?php get_footer(); ?>
