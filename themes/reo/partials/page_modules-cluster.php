<?php
  $layout = $module['layout'];

  $c1_size = ($layout == 'left_small') ? 'small' : 'large';
  $c2_size = ($layout == 'left_small') ? 'large' : 'small';
?>
<div class="cluster">
  <div class="cluster_col cluster_col--<?= $c1_size; ?>" data-fade="up" data-delay-buffer="150">
    <?php foreach($module['column_1'] as $content) : ?>
      <div class="cluster_item cluster_item--<?= $content['acf_fc_layout']; ?>" data-fade="up" data-delay-buffer="250">
        <?php if ($content['acf_fc_layout'] == 'image') : ?>
          <div class="media_wrap media_wrap--c1il">
            <a href="<?= $content['image']['original_image']['url']; ?>" class="js--lightboxLink">
              <img src="<?= $content['image']['sizes']['cluster-col-1-large']; ?>" 
                   alt="<?= $content['image']['alt']; ?>" 
                   class="img--<?= $content['width']?> img--<?= $content['alignment']?>" />
            </a>
             <a href="#" class="pinterest_link js--pinable"
                 data-url="<?php the_permalink(); ?>"
                 data-media="<?= $content['image']['original_image']['url']; ?>"
                 data-description="<?php the_title(); ?>"></a>
          </div>
        <?php elseif ($content['acf_fc_layout'] == 'quote') : ?>
          <div class="quote">
            <p><?= $content['text']; ?></p>
          </div>
        <?php elseif ($content['acf_fc_layout'] == 'video_popout') : ?>
          <div class="quote videoPopoutModule" data-js-component="videoPopoutPlayer" data-id="<?= $content['video_id'] ?>">
            <div class="media_wrap media_wrap--c1il">
              <div class="playOuter">
                <?= file_get_contents(get_template_directory() .'/img/play.svg'); ?>
              </div>
              <img src="<?= $content['image']; ?>">
            </div>
          </div>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="cluster_col cluster_col--<?= $c2_size; ?>" data-fade="up" data-delay-buffer="150">
    <?php foreach($module['column_2'] as $content) : ?>
      <div class="cluster_item cluster_item--<?= $content['acf_fc_layout']; ?>" data-fade="up" data-delay-buffer="250">
        <?php if ($content['acf_fc_layout'] == 'image') : ?>
          <div class="media_wrap media_wrap--c2il">
            <a href="<?= $content ['image']['original_image']['url']; ?>" class="js--lightboxLink">
              <img src="<?= $content ['image']['sizes']['cluster-col-2-large']; ?>" alt="<?= $content['image']['alt']; ?>" class="img--<?= $content['width']?>  img--<?= $content['alignment']?>" />
            </a>
             <a href="#" class="pinterest_link js--pinable"
                 data-url="<?php the_permalink(); ?>"
                 data-media="<?= $content['image']['original_image']['url']; ?>"
                 data-description="<?php the_title(); ?>"></a>
          </div>
        <?php elseif ($content['acf_fc_layout'] == 'quote') : ?>
          <div class="quote">
            <p><?= $content['text']; ?></p>
          </div>
        <?php elseif ($content['acf_fc_layout'] == 'image_quote') : ?>
            <div class="cluster_item cluster_item--image" data-fade="up" data-delay-buffer="250">
              <div class="media_wrap media_wrap--c2is">
                <a href="<?= $content['image']['original_image']['url']; ?>" class="js--lightboxLink">
                  <img src="<?= $content['image']['sizes']['cluster-col-2-small']; ?>" alt="<?= $content['image']['alt']; ?>" />
                </a>
                 <a href="#" class="pinterest_link js--pinable"
                     data-url="<?php the_permalink(); ?>"
                     data-media="<?= $content['image']['original_image']['url']; ?>"
                     data-description="<?php the_title(); ?>"></a>
              </div>
            </div>
            <div class="cluster_item cluster_item--quote" data-fade="up" data-delay-buffer="250">
              <div class="quote">
                <p><?= $content['text']; ?></p>
              </div>
            </div>
        <?php endif; ?>

      </div>
    <?php endforeach; ?>
  </div>
</div>
