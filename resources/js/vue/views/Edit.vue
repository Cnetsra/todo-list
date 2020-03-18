<template>
    <div class="card">
        <div class="card-header">
            Bewerken
        </div>
        <div class="card-body">
        <div class="d-flex mb-3 pb-3 border-secondary border-bottom">
            <button v-on:click="$router.push({ name: 'show', params: {id: id}});" ref="change-completed-button" class="btn btn-warning">Terug naar bekijken</button>
        </div>
            <div class="form-group">
                <label for="title">Titel</label>
                <input v-model="title" ref="title" class="form-control" type="text" id="title" name="title" placeholder="Titel">
                <small class="text-danger">{{ title_error }}</small>
            </div>

            <div class="form-group">
                <label for="description">Beschrijving</label>
                <textarea ref="description" class="form-control" id="description" name="description" placeholder="Beschrijving">{{ description }}</textarea>
            </div>

            <div class="form-group">
                <label>Afbeelding</label>
                <div class="custom-file">
                    <input ref="image" class="custom-file-input" type="file" id="image" name="image">
                    <label class="custom-file-label" for="image">{{ image_name }}</label>
                </div>
                <small class="text-danger">{{ image_error }}</small>
            </div>

            <div v-if="image_name !== 'Afbeelding'" class="custom-control custom-checkbox mb-3">
                <input v-model="del_image" class="custom-control-input" type="checkbox" id="del_image">
                <label class="custom-control-label" for="del_image">Verwijder foto</label>
            </div>

            <button class="btn btn-primary" v-on:click="update()">Bewerk</button>
        </div>
    </div>
</template>

<script>
    import { mapState, mapGetters, mapMutations } from 'vuex'

    export default {
        data() {
            return {
                title: '',
                title_error: '',
                description: '',
                image_name: '',
                image_error: '',
                del_image: false
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
            this.image_name = this.current_item['image'] ? this.current_item['image'] : 'Afbeelding';

            let custom_file_input = document.querySelector('.custom-file-input');
            if(custom_file_input) {
                custom_file_input.addEventListener('change',function(e){
                    let fileName = this.files[0].name;
                    let nextSibling = e.target.nextElementSibling;
                    nextSibling.innerText = fileName
                });
            }
        },
        methods: {
            ...mapMutations([
                'set_current_id',
                'update_item'
            ]),
            update: function () {
                let form_data = new FormData();
                form_data.set('id', this.id);
                form_data.set('title', this.title);
                form_data.set('description', this.$refs['description'].value);
                if(this.$refs['image'].files[0]) {
                    form_data.append('image', this.$refs['image'].files[0]);
                }
                if(this.del_image) {
                    form_data.append('del_image', this.del_image);
                }

                let axios_file_config = {
                    headers: {
                        'content-type': 'multipart/form-data; charset=utf-8; boundary=' + Math.random().toString().substr(2)
                    }
                };

                axios.post('/update', form_data, axios_file_config)
                    .then((response) => {
                        this.update_item(response.data);
                        this.$router.push({ name: 'show', params: {id: this.id}});
                    }).catch((error) => {
                    if(error.response.status === 422) {
                        let error_messages = error.response.data.errors;
                        for(let key in error_messages) {
                            if(key === 'title') {
                                this.$refs['title'].classList.add('is-invalid');
                                this.title_error = error_messages[key][0];
                            } else if(key === 'image') {
                                this.$refs['image'].classList.add('is-invalid');
                                this.image_error = error_messages[key][0];
                            }
                        }
                    }
                });
            }
        }
    }
</script>