import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        items: {},
        current_id: ''
    },
    getters: {
        current_item: state => {
            for (let key in state.items) {
                if(state.items.hasOwnProperty(key)) {
                    if(state.items[key]['id'] == state.current_id) {
                        return state.items[key];
                    }
                }
            }
            return {};
        }
    },
    mutations: {
        set_items: (state, new_items) => {
            state.items = new_items;
        },
        set_current_id: (state, id) => {
            state.current_id = id;
        },
        store_item: (state, new_item) => {
            state.items.unshift(new_item);
        },
        update_item_completed: (state, old_item) => {
            for(let key in state.items) {
                if(state.items.hasOwnProperty(key)) {
                    if(state.items[key]['id'] === old_item['id']) {
                        let new_item = old_item;
                        new_item['completed'] = !new_item['completed'];
                        state.items.splice(key, 1, new_item);
                    }
                }
            }
        },
        update_item: (state, new_item) => {
            for(let key in state.items) {
                if(state.items.hasOwnProperty(key)) {
                    if(state.items[key]['id'] === new_item['id']) {
                        state.items.splice(key, 1, new_item);
                    }
                }
            }
        },
        destroy_item: (state, item) => {
            for(let key in state.items) {
                if(state.items.hasOwnProperty(key)) {
                    if(state.items[key]['id'] === item['id']) {
                        state.items.splice(key, 1);
                    }
                }
            }
            state.current_id = '';
        }
    }
})