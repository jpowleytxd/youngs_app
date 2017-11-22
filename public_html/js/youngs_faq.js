//------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------
//------------------------------------Youngs App--------------------------------------
//-----------------------------------FAQ Functions------------------------------------
//------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------

$(document).ready(function(){
    // Detect click on nav button
    $('.nav_button').on('click', function(event){
        event.preventDefault();
        event.stopPropagation();

        // Get target
        var target = $(this).data('target');

        $('section.active').removeClass('active');
        $('#' + target).addClass('active');

        // Remove active state from buttons
        $('.nav_button.active').removeClass('active');
        $(this).addClass('active');
    })
});