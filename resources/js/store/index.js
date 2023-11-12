import {createStore} from 'vuex'
import {getInfoUser} from '../services/authServices'
import router from '../router'

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
            },
            isLogged: false
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
        },
        getFullname(state) {
            return state.user_data.full_name
        },
        getIsLogged(state) {
            return state.isLogged
        }
    },
    mutations: {
        setUserData(state, payload) {
            state.user_data = payload
        },
        deleteUserData(state) {
            state.user_data = {}
        },
        setLogged(state, payload) {
            state.isLogged = payload
        }
    },
    actions: {
        pullUserData(context, status) {
            getInfoUser()
            .then((res)=>{
                context.commit('setUserData', res.data.user_data)
                context.commit('setLogged', true)
                if(status === "login") router.push("/app")
            })
            .catch((err) => {
                console.log(err);
                context.commit('setLogged', false)
            })
        }
    }
})

export default store