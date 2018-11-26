<template>
    <div>
        <b-container class="bv-example-row">
            <b-row>
                <b-table :items="items" :fields="fields">
                    <template slot="table-caption">
                        This is a table caption.
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
                fields: [ 'first_name', 'last_name', 'age' ],
                items: [
                    { age: 40, first_name: 'Dickerson', last_name: 'Macdonald' },
                    { age: 21, first_name: 'Larsen', last_name: 'Shaw' },
                    { age: 89, first_name: 'Geneva', last_name: 'Wilson' }
                ]
            }
        }
    }
</script>

<style lang="scss">

</style>
