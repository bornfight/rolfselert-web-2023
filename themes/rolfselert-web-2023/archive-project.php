<?php
/* Template Name: Work Template */
get_header();
require_once('page-work-functions.php');

$cur = intval($_GET['page'] ?? 1);
$max = intval(max_pages());
$prev = ($cur - 1) < 1 ? false : intval($cur - 1);
$next = ($cur + 1) > $max ? false : intval($cur + 1);
?>
<div id="page" class="page page--work">
    <div class="contentWrapper" data-fade="in">
        <div class="pageInner page-work">
            <header class="moduleHeader">
                <h2>Work</h2>
            </header>
            <div class="page-work__wrapper">
                <?php foreach (get_paged_projects($_GET) as $project) { ?>
                    <?php $image = get_project_image($project) ?>

                    <a href="<?= get_permalink($project) ?>" class="page-work__box">
                        <img src="<?= $image ?>" alt="<?= get_the_title($project) ?>" class="page-work__image"/>
                        <h3 class="page-work__title">
                            <?= get_the_title($project) ?>
                        </h3>
                    </a>
                <?php } ?>
            </div>
            <div class="page-work__pagination">
                <?php if ($next) { ?>
                    <a href="?page=<?= $next ?>" class="page-work__next-arrow">
                        <?= file_get_contents(get_template_directory() . '/img/chevron-right.svg'); ?>
                    </a>
                <?php } ?>

                <?php if ($prev) { ?>
                    <a href="?page=<?= $prev ?>" class="page-work__back-arrow">
                        <?= file_get_contents(get_template_directory() . '/img/chevron-left.svg'); ?>
                    </a>
                <?php } ?>
                <?php if ($max > 1) { ?>
                    <ul class="page-work__list">
                        <?php for ($i = 1; $i <= $max; $i++) { ?>
                            <li class="page-work__number <?= $i === $cur ? 'is-active' : '' ?>">
                                <?php if ($i === $cur) { ?>
                                    <span style="color: #fff;"><?= $i ?></span>
                                <?php } else { ?>
                                    <a href="?page=<?= $i ?>"><?= $i ?></a>
                                <?php } ?>
                            </li>
                        <?php } ?>
                    </ul>
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
    <?php
    endif;
    ?>

</div>
<?php get_footer(); ?>
