import {defineStore} from "pinia";

export const useAuth = defineStore('auth' ,{
    state : ()=>({
        name : '',
        email : '',
        id : '',
        auth : false
    }),
    getters : {
        getName: (state) => {
            if (state.name) return state.name;
            let browserLocalStorage = localStorage.getItem("UD") || '{}';
            state.name = JSON.parse(browserLocalStorage)?.name || '';
            return state.name;
        },
        getEmail: (state) => {
            if (state.email) return state.email;
            let browserLocalStorage = localStorage.getItem("UD") || '{}';
            state.email = JSON.parse(browserLocalStorage)?.email || '';
            return state.email;
        },
        getId: (state) => {
            if (state.id) return state.id;
            let browserLocalStorage = localStorage.getItem("UD") || '{}';
            state.id = JSON.parse(browserLocalStorage)?.id || '';
            return state.id;
        },
        getAuth: (state) => {
            if (!state.auth) {
                let browserLocalStorage = localStorage.getItem("UD");
                if (browserLocalStorage !== null)
                    return JSON.parse(browserLocalStorage).auth;
            } else return state.auth;
        },
    },
    actions : {
        storeCredentials(payload){
            this.name = payload.name;
            this.email = payload.email;
            this.id = payload.id;
            this.auth = payload.auth;
            localStorage.setItem("UD", JSON.stringify(payload));
        },
        deleteCredentials(){
            this.name = '';
            this.email = '';
            this.id = '';
            this.auth = false;
            if (localStorage.getItem("UD") !== null) localStorage.removeItem("UD");
            window.location.href = "/login";
        }
    }
});
