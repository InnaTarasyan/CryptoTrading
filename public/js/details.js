"use strict";
function CoinDetails() {

}

CoinDetails.prototype.init = function () {

  var ev_list = [];
  $.each(events, function(key, value) {
        var elem = {
            'title': this['caption'],
            'start': new Date(this['start_date']),
            'description': this['caption_ru'],
            'className': "m-fc-event--accent"

        };
        ev_list.push(elem);
  });

    var todayDate = moment().startOf('day');
    $('#m_portlet_calendar').find('.m-portlet__body').append('<div id="m_calendar"></div>');

    if ($('#m_calendar').length === 0) {
        return;
    }


    $('#m_calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listWeek'
        },
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        navLinks: true,
        defaultDate: todayDate,
        events: ev_list,

        eventRender: function(event, element) {
            if (element.hasClass('fc-day-grid-event')) {
                element.data('content', event.description);
                element.data('placement', 'top');
                mApp.initPopover(element);
            } else if (element.hasClass('fc-time-grid-event')) {
                element.find('.fc-title').append('<div class="fc-description">' + event.description + '</div>');
            } else if (element.find('.fc-list-item-title').lenght !== 0) {
                element.find('.fc-list-item-title').append('<div class="fc-description">' + event.description + '</div>');
            }
        }
    });

   $('.fc-listWeek-button').click();
   $('.fc-month-button').hide();
   $('.fc-agendaWeek-button').hide();
   $('.fc-agendaDay-button').hide();
   $('.fc-listWeek-button').hide();
};

$(document).ready(function() {
    var coin = new CoinDetails();
    coin.init();
});