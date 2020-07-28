import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        counter: 0
    },

    mutations:{
        increase(state,payload){
            this.state.counter += payload
        },
        decrease(state,payload){
            this.state.counter += -payload
        }
    }
})