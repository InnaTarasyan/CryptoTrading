"use strict";
function CoinDetails() {

}



CoinDetails.prototype.init = function () {


  var ev_list = [];
  $.each(events, function(key, value) {

        var elem = {
            'title': JSON.parse(this['title']).en,
            'start': new Date(this['date_event']),
            'description': this['source'],
            'className': "m-fc-event--accent",
            "editable": true,
            "url": this['source'],
            // "extendedProps": {
            //    "source": this['source'],
            //    "proof" : this['proof'],
            //    "can_occur_before" :  this['can_occur_before'],
            // },

        };
        ev_list.push(elem);
  });


    $('#tradingview_ffbfc').css('height', '400px');

    var todayDate = moment().startOf('day');
    $('#m_portlet_calendar').find('.m-portlet__body').append('<div id="m_calendar"></div>');

    if ($('#m_calendar').length === 0) {
        return;
    }

    if (window.innerWidth >= 768 ) {
        $('#m_calendar').fullCalendar('changeView', 'agendaDay');
    } else {
        $('#m_calendar').fullCalendar('changeView', 'month');
    }


    $('#m_calendar').fullCalendar({
        //plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
        timeZone: 'UTC',
        header: {
            left: 'prev,next today',
            center: 'title',
             right: 'month,agendaWeek,agendaDay,listWeek'
           // right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        selectable: true,
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        navLinks: true,
        defaultDate: todayDate,
        events: ev_list,

        // eventRender: function(event, element) {
        //     if (element.hasClass('fc-day-grid-event')) {
        //         element.data('content', event.description);
        //         element.data('placement', 'top');
        //         mApp.initPopover(element);
        //     } else if (element.hasClass('fc-time-grid-event')) {
        //         element.find('.fc-title').append('<div class="fc-description"><a href="'+ event.description + '">' + event.description + '</a></div>');
        //     } else if (element.find('.fc-list-item-title').length !== 0) {
        //         element.find('.fc-list-item-title').append('<div class="fc-description"><a href="' + event.description + '">' + event.description + '</a></div>');
        //     }
        // },

    });

   // $('.fc-listWeek-button').click();
   // $('.fc-month-button').hide();
   // $('.fc-agendaWeek-button').hide();
   // $('.fc-agendaDay-button').hide();
   // $('.fc-listWeek-button').hide();


    var portlet = $('#m_portlet_tools').mPortlet();
    portlet.on('afterFullscreenOn', function(portlet) {
       $('#tradingview_chart').css('height', '100%');
    });

    portlet.on('afterFullscreenOff', function(portlet) {
       $('tradingview_chart').css('height', '400px');
    });

};

$(document).ready(function() {
    var coin = new CoinDetails();
    coin.init();
});

