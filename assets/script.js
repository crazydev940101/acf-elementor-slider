jQuery(document).ready(function($) {
    var $mainImages = $('.acf-main-image img'); // All main images (preloaded)
    var $thumbnails = $('.acf-thumbnail'); // All thumbnail elements
    var $thumbnailWrapper = $('.acf-thumbnails-wrapper'); // Wrapper for thumbnails
    var currentIndex = 0; // Start with the first image

    // Initialize: Hide all images except the first one
    $mainImages.hide();
    $mainImages.eq(currentIndex).show().addClass('active'); // Show the first image

    // Update the main image and highlight the selected thumbnail
    function updateMainImage(index) {
        // Hide the currently active image and show the selected one
        $mainImages.filter('.active').fadeOut(100, function() {
            // Remove 'active' class from the current image
            $(this).removeClass('active');
            
            // Fade in the selected image and add the 'active' class to it
            $mainImages.eq(index).fadeIn(100).addClass('active');
        });

        // Remove the 'selected' class from all thumbnails and reset their styles
        $thumbnails.removeClass('selected').css({
            'opacity': '0.7',
            'filter': 'brightness(100%)'
        });

        // Add the 'selected' class and update the style of the clicked thumbnail
        var $selectedImage = $thumbnails.eq(index);
        $selectedImage.addClass('selected').css({
            'opacity': '1',
            'filter': 'brightness(120%)'
        });

        if ($selectedImage.offset()) {
            // Scroll the thumbnail slider to the active thumbnail
            var thumbnailOffset = $selectedImage.offset().left - $thumbnailWrapper.offset().left;
            var wrapperWidth = $thumbnailWrapper.width();
            var thumbnailWidth = $selectedImage.outerWidth(true);

            if (thumbnailOffset < 0) {
                // Scroll left if the selected thumbnail is out of view
                $thumbnailWrapper.scrollLeft($thumbnailWrapper.scrollLeft() + thumbnailOffset);
            } else if (thumbnailOffset + thumbnailWidth > wrapperWidth) {
                // Scroll right if the selected thumbnail is out of view on the right
                $thumbnailWrapper.scrollLeft($thumbnailWrapper.scrollLeft() + thumbnailOffset - wrapperWidth + thumbnailWidth);
            }
        }
    }

    // Click event for thumbnails
    $thumbnails.on('click', function() {
        currentIndex = $(this).data('index'); // Get the index of the clicked thumbnail
        updateMainImage(currentIndex); // Update main image and highlight the thumbnail
    });

    // Next button functionality for main image
    $('.acf-next').on('click', function(e) {
        e.preventDefault(); // Prevent the default action (if any)
        currentIndex = (currentIndex + 1) % $thumbnails.length; // Go to the next image (loop around)
        updateMainImage(currentIndex); // Update main image and highlight the thumbnail
    });

    // Previous button functionality for main image
    $('.acf-prev').on('click', function(e) {
        e.preventDefault(); // Prevent the default action (if any)
        currentIndex = (currentIndex - 1 + $thumbnails.length) % $thumbnails.length; // Go to the previous image (loop around)
        updateMainImage(currentIndex); // Update main image and highlight the thumbnail
    });

    // Left arrow functionality for thumbnail slider
    $('.acf-thumbnail-nav.left').on('click', function(e) {
        e.preventDefault();
        var currentScroll = $thumbnailWrapper.scrollLeft();
        $thumbnailWrapper.animate({ scrollLeft: currentScroll - 150 }, 300); // Scroll left by 150px
    });

    // Right arrow functionality for thumbnail slider
    $('.acf-thumbnail-nav.right').on('click', function(e) {
        e.preventDefault();
        var currentScroll = $thumbnailWrapper.scrollLeft();
        $thumbnailWrapper.animate({ scrollLeft: currentScroll + 150 }, 300); // Scroll right by 150px
    });

    // Initialize: Set the first image as active
    updateMainImage(currentIndex);
});
