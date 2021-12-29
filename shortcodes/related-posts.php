<?php


function sr_related_post_fnc($atts)
{

	$post_id = get_the_ID();
	$cat_ids = array();
	$categories = get_the_category($post_id);

	if (!empty($categories) && !is_wp_error($categories)) :
		foreach ($categories as $category) :
			array_push($cat_ids, $category->term_id);
		endforeach;
	endif;

	$current_post_type = get_post_type($post_id);

	$query_args = shortcode_atts(array(
		'category__in'   => $cat_ids,
		'post_type'      => $current_post_type,
		'post__not_in'    => array($post_id),
		'posts_per_page'  => '10',
	),$atts);
	$related_cats_post = new WP_Query($query_args);


	ob_start();
?>


	<div class="custom-post-slider-sr">
		<div class="splide">
			<div class="splide__track">
				<div class="splide__list">
					<!-- slide items start  -->
					<?php

					if ($related_cats_post->have_posts()) :
						while ($related_cats_post->have_posts()) : $related_cats_post->the_post(); ?>
							<!-- slide item  -->
							<div class="splide__slide">
								<div class="post-image">
									<a href="<?php the_permalink() ?>">
										<?php

										if(has_post_thumbnail()){
											the_post_thumbnail();
										}else{
												echo "Show another default image here";
										}
										?>

									</a>
								</div>
								<div>
									<h2 class="post-title">
										<a href="<?php the_permalink() ?>"><?php the_title() ?></a>
									</h2>
								</div>
								<div>
									<p class="post-content">

										<?php
												echo wp_trim_words(get_the_content(), 50);
										 ?>
									</p>
								</div>
							</div>
					<?php endwhile;

						// Restore original Post Data
						wp_reset_postdata();
					endif;

					?>



					<!-- slide item end  -->
				</div>
			</div>
		</div>
	</div>






<?php
	wp_enqueue_style('splide-core-min-css', get_stylesheet_directory_uri() . '/assets/splide-core.min.css', [], time());
	wp_enqueue_style('splide-min-css', get_stylesheet_directory_uri() . '/assets/splide.min.css', ['splide-core-min-css'], time());
	wp_enqueue_style('splide-custom-css', get_stylesheet_directory_uri() . '/assets/splide.custom.css', ['splide-core-min-css', 'splide-min-css'], time());
	wp_enqueue_script('splide-js', get_stylesheet_directory_uri() . '/assets/splide.min.js', [], time(), true);
	wp_enqueue_script('sr-post-custom-js', get_stylesheet_directory_uri() . '/assets/splide-custom.js', ['splide-js'], time(), true);

	return	ob_get_clean();
}
add_shortcode('sr_related_posts', 'sr_related_post_fnc');
