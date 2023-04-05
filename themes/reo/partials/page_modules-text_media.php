<div class="text_media">
  
  <div class="text_media_item text_media_item--media">
    <div class="media_wrap media_wrap--tam">
      <?php 
      $media = $module['media'][0];
      if ($media['acf_fc_layout'] == 'image') : ?>
        <a href="<?= $media['image']['original_image']['url']; ?>" class="js--lightboxLink">
          <img src="<?= $media['image']['sizes']['text-media']; ?>" alt="" />
        </a>
        <a href="#" class="pinterest_link js--pinable"
             data-url="<?php the_permalink(); ?>"
             data-media="<?= $media['image']['original_image']['url']; ?>"
             data-description="<?php the_title(); ?>"></a>
      <?php elseif ($media['acf_fc_layout'] == 'video') : ?>
        <div class="videoWrapper">
          <iframe src="https://player.vimeo.com/video/<?= $media['vimeo_id']; ?>?api=1&amp;color=ffffff&amp;portrait=0&amp;badge=0&amp;badge=0&amp;title=0&amp;byline=0&amp;portrait=0" 
             class="videoWrapper_video js--videoTrigger_iframe"
             webkitallowfullscreen 
             mozallowfullscreen 
             allowfullscreen></iframe>
          <?php if ($media['poster_image']) : ?>
            <div class="videoWrapper_poster" 
                 data-js-component="videoTrigger"
                 style="background-image: url(<?= $media['poster_image']['sizes']['text-media']; ?>);"></div>
          <?php endif; ?>
        </div>
        
      <?php endif; ?>
    </div>
  </div>
  <div class="text_media_item text_media_item--text">
    <?= $module['text']; ?>
  </div>
</div>
