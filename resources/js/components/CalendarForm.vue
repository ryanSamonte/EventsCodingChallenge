<template>
    <div>
        <form>
            <div class="form-group">
                <label for="event_name">Event</label>
                <input v-model="event_name" type="text" class="form-control form-control-sm" id="event_name">
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="from_date">From</label>
                    <input v-model="from_date" type="date" class="form-control form-control-sm" id="from_date">
                </div>

                <div class="form-group col-md-6">
                    <label for="to_date">To</label>
                    <input v-model="to_date" type="date" class="form-control form-control-sm" id="to_date">
                </div>
            </div>

            <div class="text-center mt-3">
                <div class="form-check form-check-inline">
                    <input v-model="days" class="form-check-input" type="checkbox" id="monday" value="1">
                    <label class="form-check-label" for="monday">Mon</label>
                </div>

                <div class="form-check form-check-inline">
                    <input v-model="days" class="form-check-input" type="checkbox" id="tuesday" value="2">
                    <label class="form-check-label" for="tuesday">Tue</label>
                </div>

                <div class="form-check form-check-inline">
                    <input v-model="days" class="form-check-input" type="checkbox" id="wednesday" value="3">
                    <label class="form-check-label" for="wednesday">Wed</label>
                </div>

                <div class="form-check form-check-inline">
                    <input v-model="days" class="form-check-input" type="checkbox" id="thursday" value="4">
                    <label class="form-check-label" for="thursday">Thu</label>
                </div>

                <div class="form-check form-check-inline">
                    <input v-model="days" class="form-check-input" type="checkbox" id="friday" value="5">
                    <label class="form-check-label" for="friday">Fri</label>
                </div>

                <div class="form-check form-check-inline">
                    <input v-model="days" class="form-check-input" type="checkbox" id="saturday" value="6">
                    <label class="form-check-label" for="saturday">Sat</label>
                </div>

                <div class="form-check form-check-inline">
                    <input v-model="days" class="form-check-input" type="checkbox" id="sunday" value="0">
                    <label class="form-check-label" for="sunday">Sun</label>
                </div>
            </div>

            <div class="text-center mt-3">
                <button v-on:click="() => clickHandler()" type="button" class="btn btn-primary">Save</button>
            </div>
        </form>

        <notifications group="notification" />
    </div>
</template>

<script>
import {retrieve_calendar_trigger} from "../app.js";

export default {
    data() {
        return {
            endpoint: "/api/event",
            event_name: "",
            from_date: "",
            to_date: "",
            days: []
        }
    },
    methods: {
        async clickHandler() {
            try{
                let calendar_form_data = {
                    event_name: this.event_name,
                    from_date: this.from_date,
                    to_date: this.to_date,
                    days: this.days
                };
                
                let config = {
                    headers: { "Content-type": "application/json" }
                };

                    let response = await axios.post(
                        this.endpoint, calendar_form_data, config
                    );

                    if(response.data.data.is_success){
                        this.$notify({
                            group: "notification",
                            type: "success",
                            text: response.data.data.message
                        });
                    }else{
                        this.$notify({
                            group: "notification",
                            type: "success",
                            text: response.data.data.message
                        });
                    }

                    retrieve_calendar_trigger.$emit('fireMethod');
            } catch (error) {
                const error_message = _.toArray(error.response.data.errors).join(', ');

                this.$notify({
                    group: "notification",
                    type: "error",
                    text: error_message
                });

                return false;
            }
        }
    }
}
</script>