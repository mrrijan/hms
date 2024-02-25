import {defineStore} from 'pinia';

export const useSidebarCollapseStore = defineStore('sidebarCollapse', {
    state: () => ({
        collapseValue: false,
    }),
    getters: {
        isCollapsed: state => state.collapseValue,
    },
    actions: {
        toggleCollapse(){
            this.collapseValue = !this.collapseValue
        },
    }
});