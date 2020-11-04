<template>
    <FullCalendar
        :options="calendarOptions" />
</template>

<style scoped>
@import "./../../css/style.css";
</style>

<script>
import FullCalendar from '@fullcalendar/vue'
import { Calendar } from '@fullcalendar/core';
import listPlugin from '@fullcalendar/list';
import dayGridPlugin from '@fullcalendar/daygrid';
import {retrieve_calendar_trigger} from "../app.js";

export default {
    components: {
        FullCalendar
    },
    data() {
        return {
            calendarOptions: {
                plugins: [ dayGridPlugin ],
                initialView: "dayGridMonth",
                events: [],
                eventDisplay: 'background',
            }
        }
    },
    mounted() {
        this.retrieveEvents();
    },
    created() {
        retrieve_calendar_trigger.$on('fireMethod', () => {
            this.retrieveEvents();
        })
    },
    methods: {
        async retrieveEvents() {
            let config = {
                headers: { "Content-type": "application/json" }
            };

                let response = await axios.get(
                    'api/events', config
                );
                
                this.calendarOptions.events = response.data;
        }
    }
}
</script>