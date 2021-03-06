<?php

/**
 * Plugin Name: WP GraphQL MB Relationships
 * Plugin URI: https://github.com/hsimah/wp-graphql-mb-relationships
 * Description: WP GraphQL provider for MB Relationships
 * Author: hsimah
 * Author URI: http://www.hsimah.com
 * Version: 0.3.0
 * Text Domain: wpgraphql-mb-relationships
 * License: GPL-3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package  WPGraphQL_MB_Relationships
 * @author   hsimah
 * @version  0.3.0
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

if (!class_exists('WPGraphQL_MB_Relationships')) {

	add_action('admin_init', function () {
		$min_versions = [
			'wpgraphql' => '0.8.1',
			'metabox'		=> '5.2.10',
		];
		
		if (
			class_exists('MBR_Loader') &&
			class_exists('WPGraphQL') &&
			(defined('WPGRAPHQL_VERSION') && version_compare(WPGRAPHQL_VERSION, $min_versions['wpgraphql'], 'lt')) &&
			(defined('RWMB_VER') && version_compare(RWMB_VER, $min_versions['metabox'], 'lt'))
		) {
			/**
			 * For users with lower capabilities, don't show the notice
			 */
			if (!current_user_can('manage_options')) {
				return false;
			}

			add_action(
				'admin_notices',
				function () use ($min_versions) {
?>
				<div class="error notice">
					<p>
						<?php _e(vsprintf('Both WPGraphQL (v%s+) and MB Relationships (v%s+) must be active for "wp-graphql-mb-relationships" to work', $min_versions), 'wpgraphql-mb-relationships'); ?>
					</p>
				</div>
<?php
				}
			);

			return false;
		}
	});

	require_once __DIR__ . '/class-mb-relationships.php';
  \WPGraphQL_MB_Relationships::instance();

}
