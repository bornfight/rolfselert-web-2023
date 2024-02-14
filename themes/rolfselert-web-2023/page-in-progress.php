<?php
get_header();

$projects = get_field('projects');
?>
<div id="page" class="page page--progress">
    <div class="contentWrapper" data-fade="in">

        <div class="pageInner">
            <header class="moduleHeader">
                <h2>In Progress</h2>
            </header>
            <div class="blockCollection">
                <?php foreach ($projects as $key => $project) { ?>
                    <div class="projectBlock">
                        <div class="projectBlock_content">
                            <div class="image" data-js-component="lightBox_new">
                                <?php if (empty($project['images'])) { ?>
                                    <div class="image_inner"></div>
                                <?php } else { ?>
                                    <div class="image_inner">
                                        <a id="project-id-<?= $key ?>" data-js-component="lightBoxTrigger" class="img"
                                           data-trigger="<?= $project['title']; ?>">
                                            <img src="<?= $project['hero'] ?>">
                                        </a>
                                    </div>

                                    <?php foreach ($project['images'] as $image) { ?>
                                        <div class="image_inner">
                                            <a href="<?= $image['image'] ?>" class="img"
                                               data-lightbox="<?= $project['title']; ?>">
                                                <img src="<?= $image['image'] ?>">
                                            </a>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="projectBlock_info">
                                <h3><?= $project['title']; ?></h3>
                                <?= $project['description']; ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <?php
    /*
      Contacts
    */
    $contacts = get_field('contacts', 'option');
    if(FALSE):
    // removed but not deleted
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
    endif;
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
</div>
<?php get_footer(); ?>

<script>
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const project = urlParams.get('id')

  let newURL = location.href.split("?")[0];
  window.history.pushState('object', document.title, newURL);

  if (project) {
    setTimeout(function () {
      document.getElementById('project-id-' + project).click()
    }, 500)
  }
</script>
