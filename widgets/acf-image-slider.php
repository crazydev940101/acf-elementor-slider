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
        return 'eicon-slider-3d'; // Icon for the widget
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
                'default' => 'room_slides', // Default ACF field name
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
                 <!-- Main Image (All preloaded images hidden initially) -->
                <div class="acf-main-image">
                    <?php foreach ( $images as $index => $image ) : ?>
                        <img id="main-image-<?php echo $index; ?>" src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" class="acf-main-image-img" />
                    <?php endforeach; ?>
                </div>

                <!-- Thumbnails (static below the main image) -->
                <div class="acf-thumbnails-wrapper">
                    
                    <div class="acf-thumbnails">
                        <?php foreach ( $images as $index => $image ) : ?>
                            <div class="acf-thumbnail" data-index="<?php echo $index; ?>" data-src="<?php echo esc_url( $image['url'] ); ?>">
                                <img src="<?php echo esc_url( $image['sizes']['thumbnail'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" />
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
        <!-- Thumbnails Navigation Arrows -->
                    <div class="acf-thumbnails-slider-nav">    
                        <a href="#" class="acf-thumbnail-nav left">&#10094;</a> <!-- Left Arrow -->
                        <a href="#" class="acf-thumbnail-nav right">&#10095;</a> <!-- Right Arrow -->
                    </div>

                <!-- Navigation Arrows -->
                <div class="acf-slider-nav">
                    <a href="#" class="acf-prev">&#10094;</a>
                    <a href="#" class="acf-next">&#10095;</a>
                </div>
            </div>
        <?php else : ?>
            <p><?php _e( 'No images found in the ACF field.', 'acf-elementor-slider' ); ?></p>
        <?php endif;

    }
    
    protected function content_template() {
        ?>
        <#
        var images = settings.acf_field_name; // Get the ACF field name from settings
        if ( images && images.length ) { #>
            <div class="acf-image-slider">
                <!-- Main Image -->
                <div class="acf-main-image">
                    <img id="main-image" src="{{ images[0].url }}" alt="{{ images[0].alt }}" />
                </div>
    
                <!-- Thumbnails -->
                <div class="acf-thumbnails">
                    <# _.each( images, function( image, index ) { 
                        // Check if the sizes object exists and fallback if necessary
                        var thumbnailUrl = '';
                        if (image.sizes && image.sizes.thumbnail) {
                            thumbnailUrl = image.sizes.thumbnail; // Use thumbnail size
                        } else if (image.sizes && image.sizes.medium) {
                            thumbnailUrl = image.sizes.medium; // Use medium size if no thumbnail
                        } else if (image.sizes && image.sizes.large) {
                            thumbnailUrl = image.sizes.large; // Fallback to large size
                        } else {
                            thumbnailUrl = image.url; // If no sizes available, use the full URL
                        }
                    #>
                        <div class="acf-thumbnail" data-index="{{ index }}" data-src="{{ image.url }}">
                            <img src="{{ thumbnailUrl }}" alt="{{ image.alt }}" />
                        </div>
                    <# }); #>
                </div>
    
                <!-- Navigation Arrows -->
                <div class="acf-slider-nav">
                    <button class="acf-prev">&#10014;</button>
                    <button class="acf-next">&#10015;</button>
                </div>
            </div>
        <# } else { #>
            <p>{{ 'No images found in the ACF field.' }}</p>
        <# } #>
        <?php
    }
    
        
}
