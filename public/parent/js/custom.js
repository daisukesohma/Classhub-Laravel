// favourites
function toggleFavSelect(arg) {
    if (arg == "fav") {
        $('.fav-select').removeClass('show-select');
        $('.fav-select').addClass('show-fav');
        $('.fav-select-links').removeClass('show-link-cancel');
        $('.fav-select-links').addClass('show-link-select');
    }
    if (arg == "select") {
        $('.fav-select').removeClass('show-fav');
        $('.fav-select').addClass('show-select');
        $('.fav-select-links').removeClass('show-link-select');
        $('.fav-select-links').addClass('show-link-cancel');
    }
    /* if (arg == "swap") {
        //alert("in swap");
        if ($('.fav-select').hasClass('show-fav')) {
            //  alert("in show-fav");
            $('.fav-select').removeClass('show-fav');
            $('.fav-select').addClass('show-select');
        } else {
            //alert("not in show-fav");
            $('.fav-select').addClass('show-fav');
            $('.fav-select').removeClass('show-select');
        }
    } */
}

// inbox
function toggleInbox(arg) {
    $('div.col-inbox').removeClass('col-md-6').addClass('col-md-12')

    if (arg == "all") {
        $('.inbox-chat').removeClass('show-inbox-unread-only');
        $('.fav-select').addClass('show-inbox-column-only');
        $('.link-unread').removeClass('active');
        $('.link-all').addClass('active');
        $('.list-inbox div').removeClass('active')
    }
    if (arg == "unread") {
        $('.inbox-chat').addClass('show-inbox-unread-only');
        $('.fav-select').removeClass('show-inbox-column-only');
        $('.link-unread').addClass('active');
        $('.link-all').removeClass('active');
        $('.inbox-chat .col-chat').removeClass('show')
    }
}

// show chat column
function showChatColumn(arg) {

    var windowSize = $(window).width();
    if (windowSize <= 1024) {
        $('.col-inbox').addClass('hide');
        $('.col-chat-mobile-nav').addClass('show');
        $('.topbar.row.nav').addClass('hide');

    } else {
        $(this).addClass("active");
        $('.col-inbox').removeClass('col-md-12');
        $('.col-inbox').addClass('col-md-6');

    }
    $('.col-chat').addClass('show');
}

function bankToMobileInboxList() {
    $('.col-inbox').removeClass('hide');
    $('.col-chat').removeClass('show');
    $('.col-chat-mobile-nav').removeClass('show');
    $('.topbar.row.nav').removeClass('hide');
}

$(document).ready(function () {
    var windowSize = $(window).width();
    if (windowSize > 1024) {
        $(".list-inbox .list .btn").click(function () {
            $(".list-inbox .list").removeClass("active");
            // $(".tab").addClass("active"); // instead of this do the below 
            $(this).parent('.list').addClass("active");
        });
    }


});
