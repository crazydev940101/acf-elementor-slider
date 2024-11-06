<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

use Elementor\Controls_Manager;

class Elementor_ACF_Image_Slider_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'acf-image-slider'; // Unique name for your widget
    }

    public function get_title() {
        return esc_html__( 'ACF Image Slider', 'acf-elementor-slider' );
    }

    public function get_icon() {
        return 'eicon-slider-3'; // Icon for the widget
    }

    public function get_categories() {
        return [ 'basic' ]; // Category in the Elementor editor
    }

    protected function register_controls() {

        // Add controls for the widget (optional)
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Slider Settings', 'acf-elementor-slider' ),
            ]
        );

        $this->add_control(
            'acf_field_name',
            [
                'label'   => esc_html__( 'ACF Field Name', 'acf-elementor-slider' ),
                'type'    => Controls_Manager::TEXT,
                'default' => 'your_acf_field_name', // Default ACF field name
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        // Fetch the ACF field value (image array)
        $acf_field_name = $this->get_settings_for_display( 'acf_field_name' );
        $images = get_field( $acf_field_name );
    
        if ( $images ) : ?>
            <div class="acf-image-slider">
                <!-- Main Image -->
                <div class="acf-main-image">
                    <img id="main-image" src="<?php echo esc_url( $images[0]['url'] ); ?>" alt="<?php echo esc_attr( $images[0]['alt'] ); ?>" />
                </div>

                <!-- Thumbnails (static below the main image) -->
                <div class="acf-thumbnails">
                    <?php foreach ( $images as $index => $image ) : ?>
                        <div class="acf-thumbnail" data-index="<?php echo $index; ?>" data-src="<?php echo esc_url( $image['url'] ); ?>">
                            <img src="<?php echo esc_url( $image['sizes']['thumbnail'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" />
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Navigation Arrows -->
                <div class="acf-slider-nav">
                    <button class="acf-prev">&#x2190;</button>
                    <button class="acf-next">&#x2192;</button>
                </div>
            </div>
        <?php else : ?>
            <p><?php _e( 'No images found in the ACF field.', 'acf-elementor-slider' ); ?></p>
        <?php endif;

    }
    
    
    

    protected function content_template() {
        ?>
        <#
        var images = settings.acf_field_name;
        if ( images.length ) { #>
            <div class="acf-image-slider">
                <!-- Main Image -->
                <div class="acf-main-image">
                    <!-- Use the full-size image for the main image -->
                    <img src="{{ images[0].url }}" alt="{{ images[0].alt }}" />
                </div>
    
                <!-- Thumbnails -->
                <div class="acf-thumbnails">
                    <# _.each( images, function( image, index ) { #>
                        <div class="acf-thumbnail" data-index="{{ index }}">
                            <!-- Use the thumbnail size for the thumbnails -->
                            <img src="{{ image.sizes.thumbnail }}" alt="{{ image.alt }}" />
                        </div>
                    <# }); #>
                </div>
    
                <!-- Navigation Arrows -->
                <div class="acf-slider-nav">
                    <button class="acf-prev">&#x2190;</button>
                    <button class="acf-next">&#x2192;</button>
                </div>
            </div>
        <# } else { #>
            <p>{{ 'No images found in the ACF field.' }}</p>
        <# } #>
        <?php
    }
    
}
