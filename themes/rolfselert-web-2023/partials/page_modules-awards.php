<div class="award">
    <h2>Awards</h2>

  <div class="awards_item awards_item--media" data-fade="up" data-delay-buffer="150">
    <?php foreach($module['awards'] as $award) : ?>
      <div class="media_wrap media_wrap--award" data-fade="up" data-delay-buffer="150">
        <img class="awardImage" src="<?= $award['image']['url']; ?>" alt="" />
      </div>
    <?php endforeach; ?>
  </div>

  <?php if ($module['text']) : ?>
  <div class="awards_item awards_item--text" data-fade="up" data-delay-buffer="150">
    <?= $module['text']; ?>

    <?php if ($module['attr']) : ?>
    <div class="attribution">- AIA Westchester Hudson Valley Committee</div>
    <?php endif; ?> 

  </div>
  <?php endif; ?>

</div>

