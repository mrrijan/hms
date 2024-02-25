import {defineStore} from 'pinia';
import { useDark, useToggle, useColorMode } from '@vueuse/core'
import {ref} from "vue";
let colorMode = useColorMode({});
export const useThemeSwitchStore = defineStore('themeSwitch', {
    state: () => ({
        currentTheme: localStorage.getItem("vueuse-color-scheme") ?? 'light',
    }),
    getters: {
        theme: state => state.currentTheme,
    },
    actions: {
        setTheme(theme)
        {
            this.currentTheme = theme
            localStorage.setItem("vueuse-color-scheme",theme)
            colorMode = ref(theme)
        },
    }
});