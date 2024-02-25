import axios from "axios";
import {useAuth} from "../../stores/modules/auth.js";
import {nextTick} from "vue";
import {showSuccessMessage, showErrorMessage, showWarningMessage} from "../ElMessage.js";

const axiosInstance = axios.create({
    baseURL: `${import.meta.env.VITE_APP_URL}/api`,
});

axiosInstance.defaults.headers.common["Accept"] = "application/json";
axiosInstance.interceptors.request.use((config) => {

    if (config.url !== "/login") config.headers.withCredentials = true;
    return config;
});

axiosInstance.interceptors.response.use(
    (response) => {

        if (response.status === 201) showSuccessMessage(response.data.message)
        return response;
    },
    (error) => {
        const authStore = useAuth();
        if (error.response.status === 401) {
            showErrorMessage({message: "Session Expired"})
            authStore.deleteCredentials()
        }

        if (error.response.status === 500) showErrorMessage({message: "Something went wrong"})
        if (error.response.status === 422) showErrorMessage(error.response.data.errors)
        return Promise.reject(error);
    }
);

export default axiosInstance;
