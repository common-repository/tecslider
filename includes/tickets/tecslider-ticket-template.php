<?php
/**
 * Event Tickets Button
 *
 * @author   mywptrek
 * @since  2.2.0
 * @package  tecslider
 */

$tribe_event = tribe_get_event( $event->ID );
if ( ! class_exists( 'Tribe__Tickets__Tickets' ) ) {
	return;
}
if ( empty( $tribe_event->cost ) ) {
	return;
}

?>
<div class="tec-ticket-info">
	<?php if ( $tribe_event->tickets->exist() && $tribe_event->tickets->in_date_range() && ! $tribe_event->tickets->sold_out() ) : ?>
		<a
			href="<?php echo esc_url( $tribe_event->tickets->link->anchor ); ?>"
			class="tec-ticket-label"
		>
			<?php echo esc_html( $tribe_event->tickets->link->label ); ?>
		</a>
	<?php endif; ?>
	<?php if ( $tribe_event->tickets->sold_out() ) : ?>
		<span class="tec-ticket-soldout">
			<?php echo esc_html( $tribe_event->tickets->stock->sold_out ); ?>
		</span>
	<?php endif; ?>
	<span class="tec-ticket-price">
		<?php echo esc_html( $tribe_event->cost ); ?>
	</span>
	<?php if ( ! empty( $tribe_event->tickets->stock->available ) && $tribe_event->tickets->in_date_range() ) : ?>
		<span class="tec-ticket-stock">
			<?php echo esc_html( $tribe_event->tickets->stock->available ); ?>
		</span>
	<?php endif; ?>
</div>