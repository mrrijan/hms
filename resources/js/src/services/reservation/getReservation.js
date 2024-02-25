import axiosInstance from '../../config/axios/axios.js';
import {ref} from "vue";

const getReservation = ()=>{
    const reservation = ref({});
    const loadReservation = async (reservation_id)=>{
        await axiosInstance.get(`/reservation/${reservation_id}`)
            .then((res)=>{
                reservation.value = res.data.data;
            }).catch((err) =>{
                throw err;
            });
    }
    return {reservation,loadReservation};
}
export default getReservation;
