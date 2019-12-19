<template>
    <div>

        <h1 class="mb-3 text-90 font-normal text-2xl">Календарь выпуска материалов</h1>

        <div class="w-full">
            <FullCalendar
                @dateClick="handleDateClick"
                @eventClick="handleEventClick"
                @eventMouseEnter="handleMouseEnter"
                @eventMouseLeave="handleMouseLeave"
                ref="fullCalendar"
                :plugins="calendarPlugins"
                :weekends="calendarWeekends"
                :event-sources="calendarActive"
                :default-view="calendarDefaultView"
                :default-date="calendarDefaultDate"
                :default-timed-event-duration="calendarDefaultEventDuration"
                :locales="calendarLocales"
                :views="calendarCustomViews"
                :event-background-color="calendarEventColor"
                :custom-buttons="calendarCustomButtons"
                content-height="auto"
                :header="{
                left: 'prev next today',
                center: 'title',
                right: 'dayGridMonth, listLong, twoWeeks'
            }"
            />
        </div>
        <div class="panel my-8 w-full">
            <label for="calendarSelect" class="inline-block text-80 pt-2 leading-tight mb-2">Выбранные календари</label>
            <multiselect
                id="calendarSelect"
                v-model="calendarActive"
                :options="calendarEventSources"
                :multiple="true"
                :searchable="false"
                :close-on-select="false"
                track-by="modelClass"
                group-values="calendars"
                group-label="resource"
                label="title"
            />
            <div class="help-text help-text mt-2">Настроить список календарей можно в вашем профиле</div>

        </div>
    </div>

</template>

<script>

    import FullCalendar from "@fullcalendar/vue";
    import dayGridPlugin from "@fullcalendar/daygrid";
    import vSelect from 'vue-select'
    import Multiselect from 'vue-multiselect'
    import interactionPlugin from "@fullcalendar/interaction";
    import listViewPlugin from "@fullcalendar/list"
    import ruLocale from "@fullcalendar/core/locales/ru"

    export default {
        components: {
            FullCalendar, Multiselect
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
            let $startDate = new Date($nowDate.getFullYear(), $nowDate.getMonth(), 1);
            return {
                calendarPlugins: [
                    dayGridPlugin,
                    interactionPlugin,
                    listViewPlugin
                ],
                calendarActive: [],
                calendarWeekends: true,
                calendarDefaultDate: $startDate,
                calendarDefaultView: 'listLong',
                calendarEventSources: [],
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
                            duration: {days: 14},
                            buttonText: 'Две недели'
                        }

                },

                calendarDefaultEventDuration: '00:01',
                //calendarEvents: [],

            };
        },
        mounted() {
            //console.log('mounted()');
            axios.get('/nova-vendor/fullcalendar/calendars').then(response => {
                this.calendarActive = response.data['calendars'];
                this.calendarEventSources = response.data['allcalendars'];

            });
            /*
            axios.get('/nova-vendor/fullcalendar/events').then(response => {
                this.events = response.data;

                if (this.events) {
                    this.calendarEvents = [];
                    this.events.forEach((event) => {
                       // console.log(event.pubdatetime);
                       // console.log(event.title);
                        let $color = 'blue';
                        if(event.publish == 'no')
                        {
                            $color = 'red';
                        }
                        this.calendarEvents.push({
                            id: event.id,
                            url: 'resources/'+this.config['resourceBaseUrl'] +'/'+ event.id + '/edit',
                            backgroundColor: $color,
                            title: event.title,
                            start: event.pubdatetime,

                        })
                    })
                }
            });
            */
        },
    }

</script>


