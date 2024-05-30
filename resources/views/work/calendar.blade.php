@extends('adminlte::page')

@section('title')
<?php
$cname = DB::table('conf_registername')
    ->where('RegisterID', '1')
    ->get();
echo $cname[0]->RegisterName . "　-カレンダー-";
?>
@endsection

@section('content_header')
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
                left: 'prev,today,next',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek,timeGridDay,listMonth'
            },
            buttonText: {
                month: '月',
                week: '週',
                day: '日',
                list: '一覧',
                today: '今月',
                prev: '前月',
                next: '次月'
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
<style>
    @page {
        size: A4 landscape;
        margin: 0;
    }

    #calendar {
        width: 100%;
        height: 100%;
    }

    #calendar table {
        border-collapse: collapse;
    }

    #calendar table th,
    #calendar table td {
        border: 1px solid silver;
    }

    #calendar a {
        color: black;
        text-decoration: none;
    }

    #calendar h2 {
        font-size: 1.25rem;
    }


    .fc-button {
        padding: 0.2em 0.5em !important;
    }

    .fc-day-today {
        background-color: gold !important;
        /*background-color: rgba(248, 181, 0, 0.3) !important;*/
    }

    .fc-header-toolbar,
    .fc-toolbar {
        margin: 0 !important;
        padding: 0 !important;
        margin-bottom: 0.5em !important;
    }

    .fc-h-event {
        background-color: rgba(112, 189, 41, 1) !important;
        border: none !important;
    }


    th.fc-day-sat a,
    td.fc-day-sat a {
        color: blue !important;
    }

    th.fc-day-sun a,
    td.fc-day-sun a {
        color: red !important;
    }

    .calendar_2 {
        background-color: #3c97ff99 !important;
    }

    .fc-daygrid-event-dot {
        border-color: rgba(112, 189, 41, 1) !important;
    }
</style>
@stop

@section('content')

<div class="bg-white" id='calendar'></div>


@stop

@section('js')

@stop