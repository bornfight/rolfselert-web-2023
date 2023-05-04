<?php
get_header();

$projects = get_field('projects');
?>
<article id="page" class="page page--progress">

	<div class="pageInner">
		<header class="moduleHeader">
            <h2>In Progress</h2>
        </header>
		<div class="blockCollection">
			<?php foreach( $projects as $key => $project ) { ?>
                <div class="projectBlock">
                    <div class="projectBlock_content">
                        <div class="image" data-js-component="lightBox_new">
                            <?php if ( empty( $project['images'] ) ) { ?>
                                    <div class="image_inner"></div>
                            <?php } else { ?>
                                <div class="image_inner">
                                    <a id="project-id-<?= $key ?>" data-js-component="lightBoxTrigger" class="img" data-trigger="<?= $project['title']; ?>">
                                        <img src="<?= $project['hero'] ?>">
                                    </a>
                                </div>

                                <?php foreach ($project['images'] as $image) { ?>
                                    <div class="image_inner">
                                        <a href="<?= $image['image'] ?>" class="img" data-lightbox="<?= $project['title']; ?>">
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
</article>
<?php get_footer(); ?>

<script>
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const project = urlParams.get('id')

    let newURL = location.href.split("?")[0];
    window.history.pushState('object', document.title, newURL);

    if (project) {
        setTimeout( function () {
            document.getElementById('project-id-' + project).click()
        }, 500 )
    }
</script>
