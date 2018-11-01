<?php

class GP_Focus_First_Error extends GWPerk {

    public $version = GP_FOCUS_FIRST_ERROR;
    public $min_gravity_forms_version = '1.8';

	private static $instance = null;

	public static function get_instance( $perk_file ) {
		if( null == self::$instance ) {
			self::$instance = new self( $perk_file );
		}
		return self::$instance;
	}

    public function init() {

        $this->add_tooltip( $this->key( 'focus_first_error' ), sprintf(
            '<h6>%s</h6> %s',
            __( 'Focus first error', 'gravityperks' ),
            __( 'Upon validation error(s), this Gravity Perk will scroll the page down to the first error and give that input focus. This will allow users to immediately identify that there is a validation error and start them right at the the first field that needs their attention.', 'gravityperks' )
        ) );

        // # UI

        add_filter( 'gform_form_settings',          array( $this, 'add_focus_first_error_setting' ), 10, 2 );
        add_action( 'gform_pre_form_settings_save', array( $this, 'save_focus_first_error_setting' ), 10 );

        // # Functionality
        add_filter( 'gform_pre_render', array($this, 'first_error_focus') );

    }


    // Settings

	function add_focus_first_error_setting( $settings, $form ) {

		$is_enabled = ( rgar( $form, 'focusFirstError' ) ) ? 'checked="checked"' : "";

		$settings_group_name = __( 'Focus on First Error', 'gravityperks' );

		if ( empty( $settings[$settings_group_name] ) ) {
			$settings[$settings_group_name] = array();
		}

		$settings[$settings_group_name]['focusFirstError'] = '
            <tr>
                <th>' . __( 'First error', 'gravityforms' ) . ' ' . gform_tooltip( $this->key( 'focus_first_error' ), '', true ) . '</th>
                <td>
                    <input type="checkbox" id="focus_first_error" name="focus_first_error" value="1" ' . $is_enabled . ' onclick="SetFieldProperty( \'focusFirstError\', this.checked);" />
                    <label for="focus_first_error">' . __( 'Focus on error', 'gravityperks' ) . '</label>
                </td>
            </tr>
            ';

		return $settings;

	}


	function save_focus_first_error_setting( $form ) {
        $form['focusFirstError'] = rgpost( 'focus_first_error' );

        return $form;
        
    }



    // Functionality
    function first_error_focus( $form ){

        if( rgar( $form, 'focusFirstError' ) )
        {    
            add_filter( 'gform_confirmation_anchor_' . $form['id'], '__return_false' );
            ?>
             <script type="text/javascript">
             if( window['jQuery'] )
             {
                ( function( $ ) {
                    $( document ).bind( 'gform_post_render', function() 
                    { 
                        var $firstError = $( 'li.gfield.gfield_error:first' );
                        if( $firstError.length > 0 )
                        {
                            $firstError.find( 'input, select, textarea' ).eq( 0 ).focus();
                            document.body.scrollTop = $firstError.offset().top;
                        }
                    } );
                } )( jQuery );
             }
             </script>
        <?php 
        }
        return $form;
    }
 

    // Documentation

    public function documentation() {
        return array(
            'type'  => 'url',
            'value' => 'https://github.com/dhunink/gp-focus-first-error'
        );
    }

}

function gp_focus_first_error() {
    return GP_focus_first_error::get_instance( null );
}
