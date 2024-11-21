jQuery(document).ready(function($) {
    var $mainImage = $('#main-image'); // Main image element
    var $thumbnails = $('.acf-thumbnail'); // All thumbnail elements
    var currentIndex = 0; // Start with the first image

    // Update main image and highlight the selected thumbnail
    function updateMainImage(index) {
        var $selectedImage = $thumbnails.eq(index);
        var imageUrl = $selectedImage.data('src'); // Full-size image URL from data-src

        // Remove the "visible" class to start fade-out effect for main image
        $mainImage.removeClass('visible'); 

        // Wait for the fade-out to complete before updating the image source
        setTimeout(function() {
            // After fade out, update the main image's src
            $mainImage.attr('src', imageUrl);
            // Add the "visible" class back to start fade-in effect
            $mainImage.addClass('visible');
        }, 500); // Time should match the CSS transition duration (0.5s = 500ms)

        // Remove the 'selected' class from all thumbnails and reset their styles
        $thumbnails.removeClass('selected').css({
            'opacity': '0.7',    // Reset opacity
            'filter': 'brightness(100%)'  // Reset brightness
        });

        // Add the 'selected' class and update the style of the clicked thumbnail
        $selectedImage.addClass('selected').css({
            'opacity': '1',    // Full opacity for the selected thumbnail
            'filter': 'brightness(120%)'  // Slightly increase brightness for the selected thumbnail
        });
    }

    // Click event for thumbnails
    $thumbnails.on('click', function() {
        currentIndex = $(this).data('index'); // Get the index of the clicked thumbnail
        updateMainImage(currentIndex); // Update main image and highlight the thumbnail
    });

    // Next button functionality
    $('.acf-next').on('click', function() {
        currentIndex = (currentIndex + 1) % $thumbnails.length; // Go to the next image (loop around)
        updateMainImage(currentIndex); // Update main image and highlight the thumbnail
    });

    // Previous button functionality
    $('.acf-prev').on('click', function() {
        currentIndex = (currentIndex - 1 + $thumbnails.length) % $thumbnails.length; // Go to the previous image (loop around)
        updateMainImage(currentIndex); // Update main image and highlight the thumbnail
    });

    // Initialize: Set the first image as active
    updateMainImage(currentIndex);


    // Trigger when the ACF field name control is updated
    // var widgetId = '#elementor-widget-' + settings.widget_id;

    // // Listen for changes to the ACF field name input
    // $(widgetId).find('.elementor-control-acf_field_name input').on('input', function() {
    //     // You can handle your custom logic here, such as reloading the preview or something else
    //     console.log('ACF Field name changed to: ' + $(this).val());

    //     // Optionally, trigger content_template re-render here
    //     // For example:
    //     $(widgetId).find('.elementor-widget-container').trigger('content-changed');
    // });
    
});
