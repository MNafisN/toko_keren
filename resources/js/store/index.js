import {createStore} from 'vuex'

const store = createStore({
    state() {
        return {
            i: 0
        }
    },
    getters: {
        getI(state) {
            return state.i
        }
    },
    mutations: {
        setI(state, payload) {
            state.i = payload
        }
    }
})

export default store