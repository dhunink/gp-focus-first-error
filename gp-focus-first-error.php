<?php
/**
 * Plugin Name: GP First Error Focus
 * Description: Focus on the first occurence of a validation error, making forms more mobile friendly. A setting is added for every form to enable or disbale this functionality. Apart from the setting, the Gravity Perk is identical to this one: https://gravitywiz.com/make-gravity-forms-validation-errors-mobile-friendlyer/.
 * Plugin URI: https://dennishunink.nl
 * Version: 1.0.0
 * Author: Dennis Werkt, Dennis Hunink
 * Author URI: https://dennishunink.nl/
 * License: GPL2
 * Perk: True
 */

define( 'GP_FOCUS_FIRST_ERROR', '1.0.0' );

require 'includes/class-gp-bootstrap.php';

$gp_focus_first_error_bootstrap = new GP_Bootstrap( 'class-gp-focus-first-error.php', __FILE__ );