var CalendarExternalEvents = function() {

    var initExternalEvents = function() {
        $('#m_calendar_external_events .fc-event').each(function() {

            // store data so the calendar knows to render an event upon drop
            $(this).data('event', {
                title: $.trim($(this).text()), // use the element's text as the event title
                stick: true, // maintain when user navigates (see docs on the renderEvent method)
                className: $(this).data('color'),
                description: 'Lorem ipsum dolor eius mod tempor labore'
            });

            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 999,
                revert: true, // will cause the event to go back to its
                revertDuration: 0 //  original position after the drag
            });
        });
    }

    var initCalendar = function() {
        var todayDate = moment().startOf('day');
        var YM = todayDate.format('YYYY-MM');
        var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
        var TODAY = todayDate.format('YYYY-MM-DD');
        var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');

        var calendar = $('#m_calendar');

        calendar.fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listWeek'
            },
			 eventClick:  function(event, jsEvent, view) {
				 if(event.addClass == 'class') {
            $('#exampleModalLabel').html(event.description);
            $('#classBox').modal();
				 } else {
					 
				 }
			 },
			firstDay: 1, //Calendar start on this day
			nowIndicator: true,
            eventLimit: true, // allow "more" link when too many events
            navLinks: true,
            events: [
                {
                   title:"Art Class",
					start: '16:00', // a start time (9am in this example)
					end: '17:00', // an end time (3:45pm in this example)
					description: 'Art Class',
					selectAllow: 'true',
					addClass: 'class',
					dow: [ 2 ], // Repeat first 5 days of week
                    className: "m-fc-event--brand m-fc-event--solid-brand"
                },
				{
                   title:"Pumpkin Carving",
					start: '09:00', // a start time 
					end: '10:30', // an end time 
					description: 'Pumpkin Carving',
					selectAllow: 'true',
					addClass: 'class',
					dow: [ 3 ], // Repeat first 5 days of week
                    className: "m-fc-event--brand m-fc-event--solid-brand"
                }
                
            ],

            editable: true,
            droppable: true, // this allows things to be dropped onto the calendar
			themeButtonIcons: {
				prev: 'fa fa-angle-left',
				next: 'fa fa-angle-right',
			},

            drop: function(date, jsEvent, ui, resourceId) {
                var sdate = $.fullCalendar.moment(date.format());  // Create a clone of the dropped date.
                sdate.stripTime();        // The time should already be stripped but lets do a sanity check.
                sdate.time('08:00:00');   // Set a default start time.

                var edate = $.fullCalendar.moment(date.format());  // Create a clone.
                edate.stripTime();        // Sanity check.
                edate.time('12:00:00');   // Set a default end time.

                $(this).data('event').start = sdate;
                $(this).data('event').end = edate;

                // is the "remove after drop" checkbox checked?
                if ($('#m_calendar_external_events_remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    $(this).remove();
                }
            },
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            initExternalEvents();
            initCalendar(); 
        }
    };
}();

jQuery(document).ready(function() {
    CalendarExternalEvents.init();
});