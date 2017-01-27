<?php
/**
 * WordPress Customizer Framework
 * Version 1.0.0
 *
 * Copyright (c) 2017
 */
class NJCustomizer {

    /**
     * An array of Customizer options.
     *
     * @since 1.0.0
     * @access private
     * @var array $_options
     */
    static private $_options = array();

    /**
	 * Cache for the get_theme_mods call.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var array $_mods
	 */
	static private $_mods = false;


    static public function init()
    {
        add_action( 'customize_controls_print_styles',           __CLASS__ . '::controls_print_styles' );
        add_action( 'customize_controls_print_footer_scripts',   __CLASS__ . '::controls_print_footer_scripts', 1000 );
        add_action( 'customize_register',                        __CLASS__ . '::register' );
    }

    static public function controls_print_styles()
    {
        ?>
        <style type="text/css">
        .customize-control-nj-slider .nj-range-input {
            -webkit-appearance: none;
            -webkit-transition: background .3s;
            -moz-transition: background .3s;
            transition: background .3s;
            background-color: rgba(0,0,0,.1);
            height: 5px;
            width: calc(100% - 74px);
            padding: 0;
        }
        .customize-control-nj-slider .nj-range-input:hover {
            background-color: rgba(0,0,0,.25);
        }
        .customize-control-nj-slider .nj-range-input:focus {
            box-shadow: none;
            outline: none;
        }
        .customize-control-nj-slider .nj-range-input::-webkit-slider-thumb {
        	-webkit-appearance: none;
        	width: 15px;
        	height: 15px;
        	border-radius: 50%;
        	-webkit-border-radius: 50%;
        	background-color: #3498D9;
        }
        .customize-control-nj-slider .nj-range-input::-moz-range-thumb {
        	width: 15px;
        	height: 15px;
        	border: none;
        	border-radius: 50%;
        	background-color: #3498D9;
        }
        .customize-control-nj-slider .nj-range-input::-ms-thumb {
        	width: 15px;
        	height: 15px;
        	border-radius: 50%;
        	border: 0;
        	background-color: #3498D9;
        }
        .customize-control-nj-slider .nj-range-input::-moz-range-track {
        	border: inherit;
        	background: transparent;
        }
        .customize-control-nj-slider .nj-range-input::-ms-track {
        	border: inherit;
        	color: transparent;
        	background: transparent;
        }
        .customize-control-nj-slider .nj-range-input::-ms-fill-lower,
        .customize-control-nj-slider .nj-range-input::-ms-fill-upper {
        	background: transparent;
        }
        .customize-control-nj-slider .nj-range-input::-ms-tooltip {
        	display: none;
        }
        .customize-control-nj-slider .nj-range-value {
            display: inline-block;
            padding: 0 5px;
            position: relative;
            top: 1px;
        }
        .customize-control-nj-slider input#nj-range-value-input {
            width: 42px;
            height: 23px;
            font-size: 13px;
        }
        .customize-control-nj-slider .nj-slider-reset {
            color: rgba(0,0,0,.2);
            float: right;
            -webkit-transition: color .5s ease-in;
            -moz-transition: color .5s ease-in;
            -ms-transition: color .5s ease-in;
            -o-transition: color .5s ease-in;
            transition: color .5s ease-in;
        }
        .customize-control-nj-slider .nj-slider-reset span {
            font-size: 16px;
            line-height: 22px;
            cursor: pointer;
        }
        </style>
        <?php
    }

    static public function controls_print_footer_scripts()
    {
        ?>



        <script type="text/javascript">
        (function($) {
            var api = wp.customize;
            /**
        	 * Helper class for the main Customizer interface.
        	 *
        	 * @since 1.0.0
        	 * @class NJCustomizer
        	 */
            NJCustomizer = {
                /**
        		 * Initializes our custom logic for the Customizer.
        		 *
        		 * @since 1.0.0
        		 * @method init
        		 */
        		init: function()
        		{
                    NJCustomizer._initControls();
        		},


                _initControls: function()
                {
                    // Initialize the slider control.
                    api.controlConstructor['nj-slider'] = api.Control.extend({
                        ready: function() {
                            NJCustomizer._initSliderControl();
                        }
                    });

                },

                /**
        		 * Initializes the slider control.
        		 *
        		 * @since 1.0.0
        		 * @method _initSliderControl
        		 */
        		_initSliderControl: function()
        		{
                    $( '.customize-control-nj-slider .nj-slider-reset' ).on('click', function () {
                        var $slider       = $( this ).closest( 'label' ).find( '.nj-range-input' ),
                            $text_input   = $( this ).closest( 'label' ).find( '#nj-range-value-input' );
                            default_value = $slider.data( 'original' );

                        $slider.val( default_value );
                        $slider.change();
                        $text_input.val( default_value );
                    });

                    $( '.customize-control-nj-slider .nj-range-input' ).each(function() {
                        var $slider     = $(this),
                            $text_input = $( this ).closest( 'label' ).find( '#nj-range-value-input' );
                            value       = $slider.attr( 'value' );

                        $slider.on('input', function () {
                            value = $slider.attr( 'value' );
                            $text_input.val( value );
                        });

                        $text_input.on('keyup change', function(){
                            $slider.val($text_input.val());
                            $slider.change();
                        });

                    });
                },

            }

            NJCustomizer.init();

        })(jQuery);
        </script>



        <?php
    }

    static public function register( $customizer )
    {
		require_once get_template_directory() . '/inc/class-customizer-control.php';

    }


    /**
	 * Called by the customize_save_after action to refresh
	 * the cached CSS when Customizer settings are saved.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	static public function save( $customizer )
	{

	}


	/**
	 * Sanitize callback for Customizer number settings.
	 *
	 * @since 1.0.0
	 * @return int
	 */
	static public function sanitize_number( $val )
	{
		return is_numeric( $val ) ? $val : 0;
	}

}
NJCustomizer::init();
