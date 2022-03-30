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

function showHomeHeroSearch() {
    $('#home-default').hide();
    $('#start-browsing').show();
}

$(".toggle-password").click(function () {
    $(this).toggleClass("fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
});

/* starts : visitClass JS */

$('#visitClass').on('show.bs.modal', function (e) {
    //alert("hi");
    var button = $(e.relatedTarget); // Button that triggered the modal
    var recipient = button.data('whatever'); // Extract info from data-* attributes
    if (recipient == "live") {
        $('.c-modal.visit-class').addClass('show-all-actions');
    }
});
$('#visitClass').on('hidden.bs.modal', function (e) {
    if ($('.c-modal.visit-class').hasClass('show-all-actions')) {
        $('.c-modal.visit-class').removeClass('show-all-actions');
    }
});
$('#visitClass .table.data tbody td:first-child').on('click', function (e) {
    if ($(this).parent().hasClass('active')) {
        $(this).parent().removeClass('active');
    } else {
        $('#visitClass .table.data tbody tr').removeClass('active');
        $(this).parent().addClass('active');
    }
});
/* end : visitClass JS */

// Help
function toggleHelp(arg) {
    if (arg == "parent") {
        $('.hero-img .btn-teacher').addClass('btn-transparent');
        $('.hero-img .btn-parent').removeClass('btn-transparent');
        $('.faqs.teachers').removeClass('active');
        $('.faqs.parents').addClass('active');
    }
    if (arg == "teacher") {
        $('.hero-img .btn-parent').addClass('btn-transparent');
        $('.hero-img .btn-teacher').removeClass('btn-transparent');
        $('.faqs.parents').removeClass('active');
        $('.faqs.teachers').addClass('active');
    }
}

$(document).ready(function () {
    // Add smooth scrolling to all links
    $(".terms a, .sidenav a").on('click', function (event) {

        // Make sure this.hash has a value before overriding default behavior
        if (this.hash !== "") {
            // Prevent default anchor click behavior
            event.preventDefault();

            // Store hash
            var hash = this.hash;

            // Using jQuery's animate() method to add smooth page scroll
            // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
            $('html, body').stop().animate({
                scrollTop: $(hash).offset().top - 100,
            }, 800, 'swing', function () {

                // Add hash (#) to URL when done scrolling (default click behavior)
                // window.location.hash = hash;
            });
        } // End if
    });

});


$('.tab-bediscover a').on('click', function (e) {
    $('.benefits').hide();
})

$('.tab-discover a').on('click', function (e) {
    $('.benefits').show();
})

$('.tab-bediscover a').on('click', function (e) {
    $('.earning-suggested').show();
})

$('.tab-discover a').on('click', function (e) {
    $('.earning-suggested').hide();
})


/* Starts : new help page */
$('.page-help .all-faqs .main a').on('click', function (e) {
    $('.page-help .all-faqs').hide();
    $('.page-help .answers').show();
})
$('.page-help .answers .question .btm-link a').on('click', function (e) {
    $('.page-help .all-faqs').show();
    $('.page-help .answers').hide();
})
$('.page-help .dmenu-head').on('click', function (e) {
    $('.page-help .dmenu').toggleClass("open");
})
$('.page-help .la-close').on('click', function (e) {
    $('.page-help .dmenu').removeClass("open");
    // Prevent default anchor click behavior
    //event.preventDefault();
    //event.stopPropagation();
})
$('.page-help .dmenu li a').on('click', function (e) {
    $('.page-help .dmenu').removeClass("open");

})
/* End : new help page */

/* Range Slider Price Filtering */

var nonLinearStepSlider = document.getElementById('price-range-slider');

noUiSlider.create(nonLinearStepSlider, {
    start: [
        filter.price_from ? filter.price_from : 0, 
        filter.price_to ? filter.price_to : 100
    ],
    step: 10,
    connect: true,
    range: {
        'min': [0],
        'max': [100]
    }
});
var nonLinearStepSliderValueElement = document.getElementById('price-range-slider-value');
$('#price-values input[name="price_from"]').val(filter.price_from ? filter.price_from : 0);
$('#price-values input[name="price_to"]').val(filter.price_to ? filter.price_to : 100);

nonLinearStepSlider.noUiSlider.on('update', function (values) {
    nonLinearStepSliderValueElement.innerHTML = values.join(' - €');
    $('#price-values input[name="price_from"]').val(Math.floor(values[0]));
    $('#price-values input[name="price_to"]').val(Math.floor(values[1]));
});

var nonLinearStepSliderMob = document.getElementById('price-range-slider-mob');

noUiSlider.create(nonLinearStepSliderMob, {
    start: [
        filter.price_from ? filter.price_from : 0, 
        filter.price_to ? filter.price_to : 100
    ],
    step: 10,
    connect: true,
    range: {
        'min': [0],
        'max': [100]
    }
});
var nonLinearStepSliderValueElementMob = document.getElementById('price-range-slider-value-mob');
$('#price-values-mob input[name="price_from"]').val(filter.price_from ? filter.price_from : 0);
$('#price-values-mob input[name="price_to"]').val(filter.price_to ? filter.price_to : 100);

nonLinearStepSliderMob.noUiSlider.on('update', function (values) {
    nonLinearStepSliderValueElementMob.innerHTML = values.join(' - €');
    $('#price-values-mob input[name="price_from"]').val(Math.floor(values[0]));
    $('#price-values-mob input[name="price_to"]').val(Math.floor(values[1]));
});

/* Time Filtering */
$('.timepicker_from').timepicker({
    timeFormat: 'h:mm p',
    interval: 60,
    minTime: '7',
    maxTime: '10:00pm',
    defaultTime: filter.from ? filter.from : '7:00',
    startTime: '7:00',
    dynamic: false,
    dropdown: true,
    scrollbar: true
});

$('.timepicker_to').timepicker({
    timeFormat: 'h:mm p',
    interval: 60,
    minTime: '7',
    maxTime: '10:00pm',
    defaultTime: filter.to ? filter.to : '10:00pm',
    startTime: '7:00',
    dynamic: false,
    dropdown: true,
    scrollbar: true
});
