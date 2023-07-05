<?php
/* Template Name: Work Template */
get_header();
require_once( 'page-work-functions.php' );

$cur  = intval( $_GET['page'] ?? 1 );
$max  = intval( max_pages() );
$prev = ( $cur - 1 ) < 1 ? false : intval( $cur - 1 );
$next = ( $cur + 1 ) > $max ? false : intval( $cur + 1 );
?>
<article id="page" class="page page--work">
    <div class="pageInner">
        <header class="moduleHeader">
            <h2>Work</h2>
        </header>
    </div>
    <div class="contentWrapper" data-fade="in">
        <div class="page-work">
            <div class="page-work__wrapper">
                <?php foreach ( get_paged_projects( $_GET ) as $project ) { ?>
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
                <?php if ( $next ) { ?>
                    <a href="?page=<?= $next ?>" class="page-work__next-arrow">
		                <?= file_get_contents(get_template_directory() . '/img/chevron-right.svg'); ?>
                    </a>
                <?php } ?>

	            <?php if ( $prev ) { ?>
                    <a href="?page=<?= $prev ?>" class="page-work__back-arrow">
                        <?= file_get_contents(get_template_directory() . '/img/chevron-left.svg'); ?>
                    </a>
	            <?php } ?>
                <?php if ( $max > 1 ) { ?>
                    <ul class="page-work__list">
                        <?php for ( $i = 1; $i <= $max; $i++ ) { ?>
                            <li class="page-work__number <?= $i === $cur ? 'is-active' : '' ?>">
		                        <?php if ( $i === $cur ) { ?>
                                    <span style="color: #fff;"><?= $i ?></span>
		                        <?php } else { ?>
                                    <a href="?page=<?= $i ?>"><?= $i ?></a>
		                        <?php } ?>
                            </li>
                            <!--<li class="page-work__dots">-->
                            <!--    ...-->
                            <!--</li>-->
                        <?php } ?>
                    </ul>
                <?php } ?>
            </div>
        </div>
    </div>
</article>
<?php get_footer(); ?>
