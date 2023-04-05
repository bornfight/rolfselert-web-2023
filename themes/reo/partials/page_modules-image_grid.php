<div class="image_grid">
  <?php foreach($module['images'] as $image) : ?>
    <div class="media_wrap media_wrap--grid" data-fade="up" data-delay-buffer="150">
      <a href="<?= $image['image']['original_image']['url']; ?>" class="js--lightboxLink">
        <img src="<?= $image['image']['sizes']['image-grid']; ?>" alt="" />
      </a>
      <a href="#" class="pinterest_link js--pinable"
         data-url="<?php the_permalink(); ?>"
         data-media="<?= $image['image']['url']; ?>"
         data-description="<?php the_title(); ?>"></a>
    </div>
  <?php endforeach; ?>
</div>
