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
        };
        ev_list.push(elem);
    });

    $('#tradingview_ffbfc').css('height', '400px');

    var todayDate = moment().startOf('day');
    $('#m_portlet_calendar').find('.m-portlet__body').append('<div id="m_calendar"></div>');

    if ($('#m_calendar').length === 0) {
        return;
    }

    // Determine initial view based on screen size
    var isMobile = window.innerWidth < 768;

    // Get current language from localStorage or default to English
    const currentLang = localStorage.getItem('selectedLanguage') || 'en';
    
    // Language-specific calendar configurations
    const calendarConfigs = {
        en: {
            buttonText: {
                prev: "Prev",
                next: "Next",
                today: "Today",
                month: "Month",
                week: "Week",
                day: "Day",
                list: "List"
            },
            allDayText: "All Day",
            noEventsMessage: "No events"
        },
        ru: {
            buttonText: {
                prev: "Пред",
                next: "След",
                today: "Сегодня",
                month: "Месяц",
                week: "Неделя",
                day: "День",
                list: "Список"
            },
            allDayText: "Весь день",
            noEventsMessage: "Нет событий"
        },
        hy: {
            buttonText: {
                prev: "Նախ",
                next: "Հաջորդ",
                today: "Այսօր",
                month: "Ամիս",
                week: "Շաբաթ",
                day: "Օր",
                list: "Ցուցակ"
            },
            allDayText: "Ամբողջ օր",
            noEventsMessage: "Իրադարձություններ չկան"
        },
        fi: {
            buttonText: {
                prev: "Edell",
                next: "Seur",
                today: "Tänään",
                month: "Kuukausi",
                week: "Viikko",
                day: "Päivä",
                list: "Lista"
            },
            allDayText: "Koko päivä",
            noEventsMessage: "Ei tapahtumia"
        }
    };

    const config = calendarConfigs[currentLang] || calendarConfigs.en;

    $('#m_calendar').fullCalendar({
        timeZone: 'UTC',
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listWeek'
        },
        defaultView: isMobile ? 'listWeek' : 'month',
        handleWindowResize: true,
        windowResize: function(view) {
            var shouldUseMobile = window.innerWidth < 768;
            var newView = shouldUseMobile ? 'listWeek' : 'month';
            $('#m_calendar').fullCalendar('changeView', newView);
        },
        displayEventTime: false,
        contentHeight: 'auto',
        buttonText: config.buttonText,
        allDayText: config.allDayText,
        noEventsMessage: config.noEventsMessage,
        selectable: true,
        editable: true,
        eventLimit: true,
        navLinks: true,
        defaultDate: todayDate,
        events: ev_list,
        eventRender: function(event, element) {
            // Improve readability of long titles
            element.attr('title', event.title);
            element.find('.fc-title').css({ 'white-space': 'normal', 'overflow': 'visible' });
        },
        viewRender: function(view, element) {
            // Update calendar language when view changes
            setTimeout(() => {
                const currentLang = localStorage.getItem('selectedLanguage') || 'en';
                updateCalendarContent(currentLang);
            }, 100);
        }
    });

    // Update calendar language after initialization
    setTimeout(() => {
        updateCalendarContent(currentLang);
    }, 500);

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

