import {defineStore} from 'pinia'

export const useDashboardStore = defineStore('dashboard', {

    state: () => ({
        themeValue: 'darkAlgorithm',
        collapsed: true,
        backGroundColor: '#2d2e2e'
    }),
    getters: {
        getThemeValue: state => state.themeValue,
        isCollapsed: state => state.collapsed
    },
    actions: {
        handleThemeSwitch(value) {
            if (value) {
                this.themeValue = 'defaultAlgorithm'
                this.backGroundColor = '#fff'
            }
            else {
                this.themeValue = 'darkAlgorithm'
                this.backGroundColor = '#2d2e2e'
            }
        },
        handleCollapsed() {
            this.collapsed = !this.collapsed
        }
    },
})
