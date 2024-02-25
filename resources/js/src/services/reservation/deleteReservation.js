import axiosInstance from '../../config/axios/axios.js';
import {ref} from "vue";

const deleteReservation = () => {
    const deleteLoadingButton = ref(false);
    const destroyReservation = async (reservation_id) => {
        deleteLoadingButton.value = true;
        await axiosInstance.delete(`/reservation/delete/${reservation_id}`)
            .then(() => {
                deleteLoadingButton.value = false;
            }).catch((err) => {
                deleteLoadingButton.value = false;
                throw err;
            })
    }
    return {destroyReservation, deleteLoadingButton};
}
export default deleteReservation;
