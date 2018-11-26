<template>
    <div>
        <b-container class="bv-example-row">
            <b-row>
                <h1>Contact List</h1>
                <b-table striped hover :items="items" :fields="fields">
                    <template slot="show_details" slot-scope="row">
                        <!-- we use @click.stop here to prevent emitting of a 'row-clicked' event  -->
                        <b-button size="sm" @click.stop="row.toggleDetails" class="mr-1">
                            {{ row.detailsShowing ? 'Hide' : 'Show'}} Communications
                        </b-button>
                        <!-- In some circumstances you may need to use @click.native.stop instead -->
                        <!-- As `row.showDetails` is one-way, we call the toggleDetails function on @change -->
                        <!--<b-form-checkbox @click.native.stop @change="row.toggleDetails" v-model="row.detailsShowing">
                            Details via check
                        </b-form-checkbox>-->
                    </template>
                    <template slot="row-details" slot-scope="row">
                        <b-table striped hover :items="getComm(row.item.id)" :fields="logHeader"></b-table>
                    </template>
                    <template slot="table-caption">
                        Expand rows to see communication history
                    </template>
                </b-table>
            </b-row>
        </b-container>
    </div>
</template>

<script>
    export default {
        name: 'app',
        data () {
            return {
                fields: [
                    {
                        key: 'id',
                        sortable: true
                    },
                    {
                        key: 'name',
                        sortable: true
                    },
                    {
                        key: 'phone',
                        sortable: true
                    },
                    {
                        key: 'show_details',
                        sortable: false
                    },
                ],
                items: [],
                logHeader: [ 'id', 'phone', 'type', 'incoming', 'outgoing', 'datetime', 'duration'],
                details: [],
            }
        },
        methods: {
            getComm: function (id) {
                return this.details[id];
            }
        },
        mounted () {
            let that = this;
            this.$http.get('http://127.0.0.1:8008/api/v1/contacts')
                .then(response => {
                    // JSON responses are automatically parsed.
                    response.data.data.forEach(function (item) {
                        that.items.push(item.contact);
                        that.details[item.contact.id] = item.communications;
                    });
                })
                .catch(e => {
                    console.log(e);
                })
        }
    }
</script>

<style lang="scss">

</style>
