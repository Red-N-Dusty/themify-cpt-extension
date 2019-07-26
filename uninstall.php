<?php
defined( 'WP_UNINSTALL_PLUGIN' ) or die( 'No direct access allowed.' );

$options = array(
  'nmco_return_url',
  'nmco_cpt_post_types',
);

foreach ( $options as $option ) {
  delete_option( $option );
  delete_site_option( $option );
}