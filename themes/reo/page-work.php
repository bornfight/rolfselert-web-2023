<?php
get_header();
require_once( 'page-work-functions.php' );
?>
<article id="page" class="page page--work">
    <div class="contentWrapper" data-fade="in">
        <div class="page-work">
            <header class="moduleHeader">
                <h2>Work</h2>
            </header>
            <div class="page-work__wrapper">
                <?php foreach ( get_projects() as $project ) { ?>
                    <?php $image = get_project_image( $project ) ?>
                    <a href="<?= get_permalink( $project ) ?>" class="page-work__box">
                        <img src="<?= $image ?>" alt="<?= get_the_title( $project ) ?>" class="page-work__image"/>
                        <h3 class="page-work__title">
                            <?= get_the_title( $project ) ?>
                        </h3>
                    </a>
                <?php } ?>
            </div>
            <div class="page-work__pagination">
                <a href="#" class="page-work__next-arrow">
                    <?= file_get_contents(get_template_directory() . '/img/chevron-right.svg'); ?>
                </a>
                <a href="#" class="page-work__back-arrow">
                    <?= file_get_contents(get_template_directory() . '/img/chevron-left.svg'); ?>
                </a>
                <ul class="page-work__list">
                    <li class="page-work__number is-active">
                        <a href="">1</a>
                    </li>
                    <li class="page-work__number">
                        <a href="">2</a>
                    </li>
                    <li class="page-work__number">
                        <a href="">3</a>
                    </li>
                    <li class="page-work__dots">
                        ...
                    </li>
                    <li class="page-work__number">
                        <a href="">23</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</article>
<?php get_footer(); ?>
