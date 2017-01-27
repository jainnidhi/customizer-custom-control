<?php
/**
 * Custom Customizer controls.
 *
 * @since 1.0.0
 */
final class NJCustomizer_Control extends WP_Customize_Control {


	/**
	 * Renders the content for a control based on the type
	 * of control specified when this class is initialized.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @return void
	 */
	protected function render_content()
	{
		switch($this->type) {

			case 'nj-slider':
			$this->render_slider();
			break;

		}
	}

	/**
	 * Renders the title and description for a control.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @return void
	 */
	protected function render_content_title()
	{
		if(!empty($this->label)) {
			echo '<span class="customize-control-title">' . esc_html($this->label) . '</span>';
		}
		if(!empty($this->description)) {
			echo '<span class="description customize-control-description">' . $this->description . '</span>';
		}
	}

	/**
	 * Renders the connect attribute for a connected control.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @return void
	 */
	protected function render_connect_attribute()
	{
		if ( $this->connect ) {
			echo ' data-connected-control="'. $this->connect .'"';
		}
	}


	/**
	 * Renders the slider control.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @return void
	 */
	protected function render_slider()
	{
		$this->choices['min']   = ( isset( $this->choices['min'] ) )   ? $this->choices['min']   : '0';
		$this->choices['max']   = ( isset( $this->choices['max'] ) )   ? $this->choices['max']   : '100';
		$this->choices['step']  = ( isset( $this->choices['step'] ) )  ? $this->choices['step']  : '1';

		echo '<label>';
		$this->render_content_title();
		echo '<div class="wrapper">';
		echo '<input class="nj-range-input" type="range" min="' . $this->choices['min'] . '" max="' . $this->choices['max'] . '" step="' . $this->choices['step'] . '" value="' . $this->value() . '"';
		$this->link();
		echo 'data-original="' . $this->settings['default']->default . '">';
		echo '<div class="nj-range-value">';
		echo '<input type="text" id="nj-range-value-input" value="' . $this->value() . '">';
		echo '</div>';
		echo '<div class="nj-slider-reset">';
		echo '<span class="dashicons dashicons-image-rotate"></span>';
		echo '</div>';
		echo '</div>';
		echo '</label>';
	}

}
