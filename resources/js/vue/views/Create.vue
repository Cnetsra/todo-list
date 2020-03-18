<template>
    <div class="card">
        <div class="card-header">
            Toevoegen
        </div>
        <div class="card-body">
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
                    <label class="custom-file-label" for="image">Afbeelding</label>
                </div>
                <small class="text-danger">{{ image_error }}</small>
            </div>

            <button class="btn btn-primary" @click="store()">Voeg toe</button>
        </div>
    </div>
</template>

<script>
    import { mapMutations } from 'vuex'

    export default {
        data() {
            return {
                title: '',
                title_error: '',
                description: '',
                image_error: ''
            }
        },
        mounted() {
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
                'store_item'
            ]),
            store: function () {

                let form_data = new FormData();
                form_data.set('title', this.title);
                form_data.set('description', this.$refs['description'].value);
                if(this.$refs['image'].files[0]) {
                    form_data.append('image', this.$refs['image'].files[0]);
                }

                let axios_file_config = {
                    headers: {
                        'content-type': 'multipart/form-data; charset=utf-8; boundary=' + Math.random().toString().substr(2)
                    }
                };

                axios.post('/store', form_data, axios_file_config)
                    .then((response) => {
                        this.store_item(response.data);
                        this.$router.push({ name: 'index' });
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