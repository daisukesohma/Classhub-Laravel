$(function() {
    $('ul.pagination').hide();
    $('.show-more-container').jscroll({
        autoTrigger: false,
        loadingHtml: '<img class="center-block" src="https://media0.giphy.com/media/3oEjI6SIIHBdRxXI40/giphy.gif?cid=790b76115d09219658764b4859ebe006&rid=giphy.gif" alt="Loading..." />', // MAKE SURE THAT YOU PUT THE CORRECT IMG PATH
        padding: 0,
        debug: true,
        nextSelector: '.show-more-button',
        contentSelector: 'div.show-more-container',
        callback: function() {
            $('.show-more-button-container').first().remove();
            $(".col-eq-height").matchHeight();
        }
    });
});
