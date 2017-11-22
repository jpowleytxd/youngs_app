//------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------
//------------------------------------Youngs App--------------------------------------
//------------------------------Card Flipping Functions-------------------------------
//------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------

var backCardHeight = "auto";
var prelimDone = false;

$(window).on("load", function(){
    // Get Prelim dimensions
    appendDimensions();

    CSSPlugin.defaultTransformPerspective = 1000;
    
    //Set each tiles backface
    TweenMax.set($(".tile_back"), {rotationY:-180});

    // FOREACH tile build the animation
    $(".tile_outer").each(function(i,element) {
        // Setup variables used in animation
        var frontCard = $(this).children(".tile_front"),
        backCard = $(this).children(".tile_back"),
        tl = new TimelineMax({paused:true});
        
        // Get heights from tile_outer
        var frontHeight = $(element).data('front');
        var backHeight = $(element).data('back') + 40;

        // Check if back height is higher than front height
        var tileHeight = backHeight;
        if((backHeight) < frontHeight){
            tileHeight = frontHeight;
        }
        tileHeight = tileHeight + "px";

        // Build timeline structure
        tl  .to($(this), 1, {
                height: tileHeight,
                zIndex: 100,
                marginTop: "20px"
            }, 0)
            .to(frontCard, 1, {
                rotationY: 180,
                height: tileHeight
            }, 0)
            .to(backCard, 1, {
                height: tileHeight,
                rotationY: 0
            }, 0)
            .to(element, .5, {
                z: 50
            }, 0)
            .to(element, .5, {
                z: 0
            }, .5);
        
        element.animation = tl;
    
    });

    // Detect click on offer tile
    $('.tile_outer').on('click', function(event){
        event.stopPropagation();

        // Check if object already flipped
        if($(this).hasClass('flipped')){
            // Tile already flipped, flip over and remove class
            this.animation.reverse();
            $(this).removeClass('flipped');
        } else{
            // Tile not flipped, flip over and add class
            this.animation.play();
            $(this).addClass('flipped');
        }
    })

    // For each offer that will expire
    setInterval(function(){
        $('.expires').each(function(index, element){
            var currentDate = new Date();
            currentDate = "01/01/2019 " + currentDate.getHours() + ":" + currentDate.getMinutes() + ":" + currentDate.getSeconds();
            var expiryDate = "01/01/2019 " + $(element).data('hour') + ":" + $(element).data('minute') + ":" + $(element).data('second');

            if(Date.parse(currentDate) > Date.parse(expiryDate)){
                expireTile(element);
            }

        });
    }, 1000);

    // Detect click on view button and prevent click through
    $('.tile_button').on('click', function(event){
        event.stopPropagation();
    });
});

// Wait for all images to load then display the back of tiles
$(window).on("load", function(){
    $.when(prelimDone === true).then(function(){
        $('.tile_back').each(function(value, element){
            // Change to block type
            $(element).css({
                "display" : "block"
            });
        });
    });
});

/**
 * Function to transition out tiles
 * {Object} tile        - tile to be removed
 */
function expireTile(tile){
    // Setup variables used in animation
    var frontCard = $(tile).children(".tile_front");
    var frontCardImg = $(frontCard).children('img');
    var backCard = $(tile).children(".tile_back");

    var tl = new TimelineMax({
        paused: true,
        onComplete: function(){
            $(tile).remove();
        }
    });
    
    // Build timeline structure
    tl.to($(tile), 1.5, {
            height: "0px",
            marginBottom: "0px",
            opacity: 0
        }, 0)
        .to(frontCard, 1.5, {
            height: "0px"
        }, 0)
        .to(frontCardImg, 1.5, {
            height: "0px"
        }, 0)
        .to(backCard, 1.5, {
            height: "0px",
            paddingTop: "0px",
            paddingBottom: "0px"
        }, 0);
    
    tile.animation = tl;
    tile.animation.play();

}

/**
 * Function to append dimensions onter tile data
 */
function appendDimensions(){
    // For all tiles
    $('.tile_outer').each(function(index, element){
        // Get fron tile image height and apply to data attribute
        var frontHeight = Math.abs($(element).find('.tile_front img').height());
        $(element).data("front", frontHeight);
        console.log("Tile Front Height: " + $(element).data('front'));

        // Get height from tile back auto height and apply to data attribute
        var backHeight = Math.abs($(element).find('.tile_back').height());
        $(element).data("back", backHeight);
        console.log("Tile Back Height: " + backHeight);

        // Adjust current dimensions for front facing tiles
        $(element).css({
            "height" : frontHeight
        });

        $(element).find('.tile_front img').css({
            "height" : frontHeight
        });

        $(element).find('.tile_back').css({
            "height" : frontHeight
        });

        prelimDone = true;
    });
}   