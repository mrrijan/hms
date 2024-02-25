import axiosInstance from '../../config/axios/axios.js';
import {ref} from "vue";

const putReservation = ()=>{
    const updateLoadingButton = ref(false);
    const updateReservation = async (reservation)=>{
        updateLoadingButton.value = true;
        await axiosInstance.post('/reservation/update',reservation)
            .then(()=>{
                updateLoadingButton.value = false;
            }).catch((err)=>{
                updateLoadingButton.value = false;
                throw err;
            })
    }
    return {updateReservation,updateLoadingButton};
}
export default putReservation;
