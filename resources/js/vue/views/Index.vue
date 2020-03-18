<template>
    <div>
        <div class="card">
            <div class="card-header">
                Overzicht
            </div>
            <div class="card-body">
                <template v-if="Object.keys(items).length > 0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th>Titel</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="item in items" v-on:click="$router.push({ name: 'show', params: { id: '' + item['id'], items: items } })" v-bind:class="{'bg-success-light': item['completed']}">
                                <td>{{ item['title'] }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </template>
                <template v-else="">
                    <p class="mb-0">Er zijn nog geen items toegevoegd</p>
                </template>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapState } from 'vuex'

    export default {
        computed: {
            ...mapState([
                'items'
            ])
        },
    }
</script>