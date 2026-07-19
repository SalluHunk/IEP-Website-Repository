<?php
/**
 * CMS-005 — Recommended single Service template
 *
 * NOT required for this module's initial value — see README.md. This
 * is the recommendation for when individual service detail pages are
 * wanted, and file/SFTP access exists to place it at
 * greenly-child/single-cspt-service.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	$summary  = get_field( 'executive_summary' );
	$benefits = get_field( 'key_benefits' );
	$cta      = iep_get_service_cta( get_the_ID() );
	?>
	<main class="iep-service-single" style="padding:80px 40px;max-width:900px;margin:0 auto;">
		<h1 style="color:#1E3D34;"><?php the_title(); ?></h1>

		<?php if ( $summary ) : ?>
			<p style="font-size:20px;color:#5C6B6E;"><?php echo esc_html( $summary ); ?></p>
		<?php endif; ?>

		<?php the_content(); // renders Full Description if authored via the block/classic editor area ?>

		<?php if ( ! empty( $benefits ) ) : ?>
			<h2>Key Benefits</h2>
			<ul>
				<?php foreach ( $benefits as $row ) : ?>
					<li><?php echo esc_html( $row['benefit_text'] ); ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<a class="iep-btn" href="<?php echo esc_url( $cta['url'] ); ?>" style="display:inline-block;padding:18px 42px;background:#4C8B5A;color:#fff;border-radius:4px;text-decoration:none;">
			<?php echo esc_html( $cta['text'] ); ?>
		</a>
	</main>
	<?php
endwhile;

get_footer();
