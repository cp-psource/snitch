<?php
/**
 * Plugin Name: CP Snitch
 * Description: Network monitor for ClassicPress. Connection overview for monitoring and controlling outgoing data traffic.
 * Author:      WMS N@W
 * Author URI:  https://n3rds.work/
 * Plugin URI:  https://n3rds.work/
 * License:     GPLv3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0
 * Version:     1.1.9
 * Text Domain: snitch
 *
 * @package Snitch
 */

/*
Copyright (C)  2013-2015 Sergej Müller
Copyright (C)  2015-2019 Pluginkollektiv
Copyright (C)  2023 WMS N@W

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/
require 'psource/psource-plugin-update/psource-plugin-updater.php';
use Psource\PluginUpdateChecker\v5\PucFactory;
$MyUpdateChecker = PucFactory::buildUpdateChecker(
	'https://n3rds.work//wp-update-server/?action=get_metadata&slug=snitch', 
	__FILE__, 
	'snitch' 
);
/* Quit */
defined( 'ABSPATH' ) || exit;

/* Constants */
define( 'SNITCH_FILE', __FILE__ );
define( 'SNITCH_DIR', dirname( __FILE__ ) );
define( 'SNITCH_BASE', plugin_basename( __FILE__ ) );
define( 'SNITCH_BLOCKED', 1 );
define( 'SNITCH_AUTHORIZED', -1 );
define( 'SNITCH_URL', plugin_dir_url( __FILE__ ) );

/* Actions */
add_action(
	'plugins_loaded',
	array(
		'Snitch',
		'instance',
	)
);

/* Hooks */
register_activation_hook(
	__FILE__,
	array(
		'Snitch',
		'activation',
	)
);
register_deactivation_hook(
	__FILE__,
	array(
		'Snitch',
		'deactivation',
	)
);
register_uninstall_hook(
	__FILE__,
	array(
		'Snitch',
		'uninstall',
	)
);


/* Autoload Init */
spl_autoload_register( 'snitch_autoload' );

/**
 * Autoload the class.
 *
 * @param string $class the class name.
 */
function snitch_autoload( $class ) {
	if ( in_array( $class, array( 'Snitch', 'Snitch_HTTP', 'Snitch_CPT', 'Snitch_Blocklist' ) ) ) {
		require_once(
			sprintf(
				'%s/inc/class-%s.php',
				SNITCH_DIR,
				strtolower( str_replace( '_', '-', $class ) )
			)
		);
	}
}
