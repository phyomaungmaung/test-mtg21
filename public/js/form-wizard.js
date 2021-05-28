/**
 * Created by vitou on 21/03/2017.
 */

$(document).ready(function () {


    //Initialize tooltips
    $('.nav-tabs > li a[title]').tooltip();

    //Wizard
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
        pauseVideo();
        $('.save-continue').removeClass('disabled');
        var $target = $(e.target);
        if ($target.parent().hasClass('disabled')) {
            return false;
        }

    });

    // $(".next-step").click(function (e) {
    //
    //     var $active = $('.wizard .nav-tabs li.active');
    //     $active.next().removeClass('disabled');
    //     nextTab($active);
    //
    // });
    $(".prev-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        prevTab($active);

    });
});

//pause video
function pauseVideo(){
    var vs =$('.videoPlayer');
    $.each(vs,function (i,e) {
        if($(e).is('video') && e.played){
            e.pause();
        }
    });

};

function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}
