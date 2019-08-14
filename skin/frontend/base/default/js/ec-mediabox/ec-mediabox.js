(function ($) {
    var player = null;
    
    $.fn.ecMediabox = function(options) {

        //Get settings
        var settings = $.extend({
            popupSource: '#ec-media-popup',
            galleryMainImageContainer: '#ec-gallery-main-image-container',
            galleryMainYoutubeContainer: '#ec-gallery-main-youtube-container',
            galleryMainImageId: '#ec-gallery-main-image',
            thumbnailClass: '.ec-gallery-thumb',
            activeThumbnailClassString: 'ec-gallery-thumb-active',
            productPageMainImage: '.product-img-box .product-image img',
            productPageMainImageLink: '.product-img-box .product-image a'
        }, options );
        
        this.find('li a').each(function (index, element) {
            
            //Open up the popup if any of the thumbnails is clicked
            $(element).click(function(event) {
                openMediabox(event, $(this), settings); 
            });
            
            //Change the main product image and href on a hover on the product page
            $(element).hover(function(event) {
                $(settings.productPageMainImage).attr('src', $(this).attr('data-mainimage'));
                $(settings.productPageMainImage).attr('alt', $(this).attr('title'));
                $(settings.productPageMainImage).attr('title', $(this).attr('title'));
                $(settings.productPageMainImageLink).attr('href', $(this).attr('href'));
                $(settings.productPageMainImageLink).attr('title', $(this).attr('title'));
                
                if($(this).hasClass('ec-thumb-video')) {
                    $(settings.productPageMainImageLink).addClass('ec-thumb-video');
                    $(settings.productPageMainImageLink).attr('data-videoid', $(this).attr('data-videoid'));
                }
                else {
                    $(settings.productPageMainImageLink).removeClass('ec-thumb-video');
                    $(settings.productPageMainImageLink).removeAttr('data-videoid');
                }
            });
        });
        
        //When a gallery thumbnail is clicked show the correct image and highlight the selected thumbnail
        $(settings.thumbnailClass).click(function(event){
            var videoId;
            event.preventDefault();
            destroyPlayer();
            if($(this).hasClass('ec-thumb-video')) {
                videoId = $(this).attr('data-videoid');

                $(settings.galleryMainImageContainer).hide();
                $(settings.galleryMainYoutubeContainer).show();
                
                player = new YT.Player('ec-youtube-player', {
                    videoId: videoId,
                    events: {
                        'onReady': function(event) { event.target.playVideo(); },
                    }
                });
            }
            else {
                $(settings.galleryMainYoutubeContainer).hide();
                $(settings.galleryMainImageContainer).show();
                $(settings.galleryMainImageId).attr('src', $(this).attr('href'));
                $(settings.galleryMainImageId).attr('alt', $(this).attr('title'));
                $(settings.galleryMainImageId).attr('title', $(this).attr('title'));
            }
            $(settings.thumbnailClass).removeClass(settings.activeThumbnailClassString);
            $(this).addClass(settings.activeThumbnailClassString);
        });
        
        //When the main image is clicked show the correct image and highlight the selected thumbnail
        $(settings.productPageMainImageLink).click(function(event) {
            openMediabox(event, $(this), settings);            
        });
        
        //Finally, preload images
        this.find('li a').each(function (index, element) {
            var popupMainImage = new Image();
            var mainProductImage = new Image();
            
            mainProductImage.src = $(element).attr('data-mainimage');

            if(!($(element).hasClass('ec-thumb-video'))) {
               popupMainImage.src = $(element).attr('href'); 
            }
        });

        return this;
    };
    
    function openMediabox(event, element, settings) {
        event.preventDefault();
        $.magnificPopup.open({
            items: {
                src: settings.popupSource,
                type: 'inline'
            },
            callbacks: {
                close: function() { destroyPlayer(); }
            }
        });
        
        if(element.hasClass('ec-thumb-video')) {
            destroyPlayer();
            var videoId = element.attr('data-videoid');
            $(settings.galleryMainImageContainer).hide();
            $(settings.galleryMainYoutubeContainer).show();
            
            player = new YT.Player('ec-youtube-player', {
                videoId: videoId,
                events: {
                    'onReady': function(event) { event.target.playVideo(); },
                }
            });
            
            $(settings.thumbnailClass).removeClass(settings.activeThumbnailClassString);
            
            $(settings.thumbnailClass).each(function (index, el) {
                if($(el).attr('data-videoid') == videoId)
                    $(el).addClass(settings.activeThumbnailClassString);
            });
        }
        else {
            $(settings.galleryMainYoutubeContainer).hide();
            $(settings.galleryMainImageContainer).show();
            
            //Display the correct image in the main area
            var clickedHref = element.attr('href');
            $(settings.galleryMainImageId).attr('src', clickedHref);
            $(settings.galleryMainImageId).attr('alt', element.attr('title'));
            $(settings.galleryMainImageId).attr('title', element.attr('title'));
            
            $(settings.thumbnailClass).removeClass(settings.activeThumbnailClassString);
            
            $(settings.thumbnailClass).each(function (index, el) {
                if($(el).attr('href') == clickedHref)
                    $(el).addClass(settings.activeThumbnailClassString);
            });
        }
    };
    
    function destroyPlayer() {
        if(player != null) {
            player.destroy();
            player = null;
        }
    }
    
}(jQuery));
