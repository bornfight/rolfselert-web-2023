<?php get_header(); ?>
<article id="page" class="page page--progress">

	<div class="pageInner">

		<header class="moduleHeader"> <h2>In Progress</h2> </header>

		<div class="blockCollection">

			<?php
			$projects =  get_field('projects');
			//print_r($projects);
			foreach($projects as $key=>$project): ?>

			<div class="projectBlock">
				<div class="projectBlock_content">

					<div class="image" data-js-component="lightBox_new">
						
						<?php
							if( empty( $project['images'] )){ ?>
								<div class="image_inner"></div>	
							<?php
							}else{ ?>
								<div class="image_inner">
								<a data-js-component="lightBoxTrigger" class="img" data-trigger="<?= $project['title']; ?>"><img src="<?= $project['hero'] ?>"></a>
							</div>
							<?php
							foreach($project['images'] as $image): ?>
							<div class="image_inner">
								<a href="<?= $image['image'] ?>" class="img" data-lightbox="<?= $project['title']; ?>"><img src="<?= $image['image'] ?>"></a>
							</div>
							<?php endforeach;
							}
						?>
						
					</div>

					<div class="projectBlock_info">

							<h3><?= $project['title']; ?></h3>
							<?= $project['description']; ?>
						</div>
				</div>
			</div>

			<?php endforeach; ?>

		</div>
	</div>
</article>
<?php get_footer(); ?>
