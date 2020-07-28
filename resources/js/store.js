import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        loggedInUser: false
    },
    getters:{
        
    },
    mutations:{
        loggedInUserInfo(state,data){
            state.loggedInUser = data
        }
        
    },
    actions: {
    }
    
})