<template>
    <div>
        <nav class="navbar bg-primary text-white shadow-sm">
            <h1>Items</h1>

            <div class="text-white">
                <router-link class="mr-2" :to="{ name: 'index', params: {items: items} }" replace>Overzicht</router-link>
                <router-link :to="{ name: 'create' }">Toevoegen</router-link>
            </div>
        </nav>

        <div class="container pt-4">
            <div class="row justify-content-center">
                <div class="col-12" ref="router_view_wrap">
                    <router-view v-if="is_mounted"></router-view>
                </div>
            </div>
        </div>
    </div>

</template>
<script>

    import { mapState, mapMutations } from 'vuex'

    export default {
        data() {
            return {
                is_mounted: false
            }
        },
        props: {
            initial_items: {}
        },
        computed: {
            ...mapState([
                'items'
            ])
        },
        mounted() {
            this.set_items(this.initial_items);
            this.is_mounted = true;
        },
        methods: {
            ...mapMutations([
                'set_items'
            ]),
            edit_item: function(item) {
                for(let key in this.items) {
                    if(this.items.hasOwnProperty(key)) {
                        if(this.items[key]['id'] === item['id']) {
                            this.items[key] = item;
                        }
                    }
                }
                this.$router.push({ name: 'show', params: {item: item}});
            },
        }
    }
</script>