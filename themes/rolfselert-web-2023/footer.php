
      </div><!-- /#pjax-fragment -->
    </div><!-- /#pjax-container -->
    <footer class="globalFooter">
      <div class="contentWrapper">
        <p class="copyright">
          &copy; <?= date("Y"); ?>  <?php bloginfo('name'); ?> PLLC
        </p>

        <?php
          $social_links = get_field('social_links', 'option');
        ?>
        <div class="socialLinks">
          <?php foreach($social_links as $link) : ?>
            <a href="<?= $link['link'];?>" target="_blank" class="socialLinks_item">
              <img src="<?= $link['icon']['url']; ?>" alt="<?= $link['title']; ?>" class="icon_social" />
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </footer>
  </div>
  <!-- /.siteWrapper -->

  <script src="<?php echo get_template_directory_uri(); ?>/static/dist/vendor.js?v=1.14"></script>
  <script src="<?php echo get_template_directory_uri(); ?>/static/dist/bundle.js?v=1.14"></script>
</body>
</html>
