<meta charset='utf-8' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/index.global.min.js'></script>
<script src="/js/gc/index.global.js"></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
<script>
    //Full Calendar
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'ja',
            dayCellContent: function(arg) {
                return arg.date.getDate();
            },
            height: "auto",
            googleCalendarApiKey: 'AIzaSyA5YVXfWRpXmcjD51G_QpEw2V6TgPerl2k',

            eventSources: [{
                    //スケジュール1
                    googleCalendarId: 'b1a34a28897861a9eb421e2883803167e0c07117e984e3bfbf10e2301e54b949@group.calendar.google.com',
                    className: 'calendar_1'

                },
                {
                    //スケジュール２
                    googleCalendarId: '7659558c60480afed1dcd82e0271bab2db25d85f67e11caba8126289ef0879aa@group.calendar.google.com',
                    className: 'calendar_2'
                }
            ],


            //events: 'chunousinrin@gmail.com',
            headerToolbar: {
                left: 'prev',
                center: 'title',
                right: 'next'
            },
            buttonText: {
                prev: '　◀',
                next: '▶　'
            },
            eventClick: function(info) {
                info.jsEvent.preventDefault();
            },
            eventDidMount: (e) => {
                tippy(e.el, {
                    content: e.event.title,
                });
            },
        });
        calendar.render();
    });
</script>

<div id='calendar'></div>