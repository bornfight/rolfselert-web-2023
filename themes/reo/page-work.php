<?php get_header(); ?>
<article id="page" class="page page--work">
    <div class="contentWrapper" data-fade="in">
        <div class="page-work">
            <header class="moduleHeader">
                <h2>Work</h2>
            </header>
            <div class="page-work__wrapper">
                <?php for($i = 0; $i < 15; $i++) { ?>
                <a href="#" class="page-work__box">
                    <img src="https://picsum.photos/1200" alt="" class="page-work__image"/>
                    <h3 class="page-work__title">
                        Title
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
