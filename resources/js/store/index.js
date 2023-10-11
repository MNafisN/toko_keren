import {createStore} from 'vuex'

const store = createStore({
    state() {
        return {
            user_data: {
                about: "",
                email: "",
                full_name: "",
                phone_number: "",
                profile_picture: "",
                username: ""
            }
        }
    },
    getters: {
        getUserData(state) {
            return state.user_data
        },
        getUsername(state) {
            return state.user_data.username
        },
        getProfilePicture(state) {
            return state.user_data.profile_picture
        }
    },
    mutations: {
        setUserData(state, payload) {
            state.user_data = payload
        },
        deleteUserData(state) {
            state.user_data = {}
        }
    }
})

export default store