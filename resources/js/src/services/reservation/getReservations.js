import axiosInstance from '../../config/axios/axios.js';
import {ref} from "vue";

const getReservations = ()=>{
    const reservations = ref([]);
    const meta = ref([]);
    const reservationsLoading = ref(false);

    const loadReservations =async (url = '/reservations')=>{
        reservationsLoading.value = true;
            await axiosInstance.get(url)
                .then((res)=>{
                    reservationsLoading.value = false;
                    reservations.value = res.data.data;
                    meta.value  = res.data.meta;
                }).catch((err) =>{
                    reservationsLoading.value = false;
                    console.log(err);
                })
    };
    return {reservations,meta,loadReservations};
}
export default getReservations;
