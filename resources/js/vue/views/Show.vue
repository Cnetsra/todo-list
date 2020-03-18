<template>
    <div class="card">
        <div class="card-header">
            Bekijken
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3 px-3 pb-3 border-secondary border-bottom">
                <button v-on:click="update_completed()" ref="change-completed-button" class="btn">{{ btn_text }}</button>
                <div class="d-flex justify-content-end">
                    <button v-on:click="$router.push({ name: 'edit', params: { id: '' + current_item['id'] } })" class="btn btn-warning mr-2">Bewerk</button>
                    <button v-on:click="destroy()" class="btn btn-danger">Verwijder</button>
                </div>
            </div>
            <div ref="item-content" class="d-flex justify-content-between p-3">
                <div class="mr-4">
                    <h4>{{ title }}</h4>
                    <p>
                        {{ description }}
                    </p>
                </div>
                <img v-if="image_link" class="item-img" :src="image_link">
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState, mapGetters, mapMutations } from 'vuex'

    export default {
        data() {
            return {
                btn_text: '',
                title: '',
                description: '',
                image_link: ''
            }
        },
        props: {
            id: String,
        },
        computed: {
            ...mapState([
                'current_id'
            ]),
            ...mapGetters([
                'current_item'
            ])
        },
        mounted() {
            this.set_current_id(this.id);

            if(Object.keys(this.current_item).length === 0) {
                this.$router.push({ name: 'index' });
            }
            this.title = this.current_item['title'];
            this.description = this.current_item['description'];
            if(this.current_item['image']) {
                this.image_link = '/images/' + this.current_item['id'] + '/' + this.current_item['image'];
            }
            if(this.current_item['completed']) {
                this.$refs['item-content'].classList.add('bg-success-light');
                this.$refs['change-completed-button'].classList.add('btn-secondary');
                this.btn_text = 'Onvoltooid';
            } else {
                this.$refs['change-completed-button'].classList.add('btn-success');
                this.btn_text = 'Voltooid';
            }
        },
        methods: {
            ...mapMutations([
                'set_current_id',
                'update_item_completed',
                'destroy_item'
            ]),
            update_completed: function () {
                axios.put('/change-completed', {
                    id: this.id
                });
                this.$refs['item-content'].classList.toggle('bg-success-light');
                this.$refs['change-completed-button'].classList.toggle('btn-success');
                this.$refs['change-completed-button'].classList.toggle('btn-secondary');
                this.btn_text = this.btn_text === 'Voltooid' ? 'Onvoltooid' : 'Voltooid';

                this.update_item_completed(this.current_item);
            },
            destroy: function() {
                axios.delete('/destroy', { data: { id: this.current_item['id']} });
                this.destroy_item(this.current_item);
                this.$router.push({ name: 'index' });
            }
        }
    }
</script>