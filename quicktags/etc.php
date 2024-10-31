<?php


defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


if ( ! function_exists ( 'oxsn_banner_quicktags' ) ) {

	add_action( 'admin_print_footer_scripts', 'oxsn_banner_quicktags' );
	function oxsn_banner_quicktags() {

		if ( wp_script_is( 'quicktags' ) ) {

		?>

			<script type="text/javascript">
				QTags.addButton( 'oxsn_banner_quicktag', '[oxsn_banner]', '[oxsn_banner page_id="" class=""]', '[/oxsn_banner]', 'oxsn_banner', 'Banner', 201 );
			</script>

		<?php

		}

	}

}


?>