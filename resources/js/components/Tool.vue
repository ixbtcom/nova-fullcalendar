<template>
    <div>
        <FullCalendar
            @dateClick="handleDateClick"
            @eventClick="handleEventClick"
            @eventMouseEnter="handleMouseEnter"
            @eventMouseLeave="handleMouseLeave"
            ref="fullCalendar"
            :plugins="calendarPlugins"
            :weekends="calendarWeekends"
            :events="calendarEvents"
            :default-view="calendarDefaultView"
            :default-date="calendarDefaultDate"
            :default-timed-event-duration="calendarDefaultEventDuration"
            :locales="calendarLocales"
            :views="calendarCustomViews"
            :header="{
                left: 'prev next today',
                center: 'title',
                right: 'dayGridMonth, listLong, twoWeeks'
            }"
        />
    </div>
</template>

<script>

    import FullCalendar from "@fullcalendar/vue";
    import dayGridPlugin from "@fullcalendar/daygrid";
    import timeGridPlugin from "@fullcalendar/timegrid";
    import interactionPlugin from "@fullcalendar/interaction";
    import listViewPlugin from "@fullcalendar/list"
    import ruLocale from "@fullcalendar/core/locales/ru"

    export default {
        components: {
            FullCalendar
        },
        methods: {
            handleDateClick(info) {
                console.log(info);
            },
            handleEventClick(info) {
                console.log(info);


            },
            handleMouseEnter(info) {
                console.log(info);
            },
            handleMouseLeave(info) {
                console.log(info);
            },
        },
        data() {
            let $nowDate = new Date();
            let $startDate = new Date($nowDate.getFullYear(),$nowDate.getMonth(),1);
            return {
                calendarPlugins: [
                    dayGridPlugin,
                    interactionPlugin,
                    listViewPlugin
                ],
                calendarWeekends: true,
                calendarDefaultDate: $startDate,
                calendarDefaultView: 'listLong',
                calendarLocales: [ruLocale],
                calendarCustomViews: {
                    listLong:
                        {
                            type: 'listMonth',
                            buttonText: 'Месяц списком'
                        },
                        twoWeeks:
                            {
                                type: 'list',
                                duration: {days:14},
                                buttonText: 'Две недели'
                            }

                },

                calendarDefaultEventDuration: '00:01',
                calendarEvents: [],

            };
        },
        mounted() {
            //console.log('mounted()');

            axios.get('/nova-vendor/fullcalendar/events').then(response => {
                this.events = response.data['events'];
                this.config = response.data['config'];
                if (this.events) {
                    this.calendarEvents = [];
                    this.events.forEach((event) => {
                       // console.log(event.pubdatetime);
                       // console.log(event.title);
                        this.calendarEvents.push({
                            id: event.id,
                            url: 'resources/'+this.config['resourceBaseUrl'] +'/'+ event.id + '/edit',
                            title: event.title,
                            start: event.pubdatetime,

                        })
                    })
                }
            });
        },
    }

</script>

<style>
    @import "~@fullcalendar/core/main.css";
    @import "~@fullcalendar/daygrid/main.css";
    @import "~@fullcalendar/timegrid/main.css";
    @import "~@fullcalendar/list/main.css";
</style>
