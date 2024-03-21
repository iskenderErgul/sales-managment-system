    import Vuex from 'vuex'
    import axios from "axios";
    import router from "../router/index.js";


    const state = {
        user: null,
        authenticated: null
    }

    const getters = {
        user: state => state.user,
        authenticated: state => state.authenticated
    }

    const actions = {
        async authenticate({commit}) {
            if (!state.user)
                return axios.get('/api/user').then(res => {
                    commit('setAuthenticate', true)
                    commit('setUser', res.data)

                }).catch(err=>{

                })

        },
        async login({commit, dispatch, state}, authData) {

            await axios.get('/sanctum/csrf-cookie').then(() => {
                axios.post('/api/login', {...authData})
                    .then(async res => {
                        commit('setAuthenticate', true)
                        commit('setUser', res.data.data)
                        await router.push('/sys')
                        console.log(state);
                    }).catch((err) => {
                    console.log(err)
                })
            })

        },

        async logout({commit, dispatch, state}) {


            await axios.get('/api/logout').then(async () => {
                commit('setUser', null);
                commit('setAuthenticate', false);
                await router.push('login');
            });
        }
    }
    const mutations = {
        setAuthenticate(state, value) {
            state.authenticated = value
        },
        setUser(state, value) {
            state.user = value
        }

    }

    const store = new Vuex.Store({state, getters, actions, mutations})

    export default store
