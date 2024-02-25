import axiosInstance from '../../config/axios/axios.js';
import {ref} from "vue";
const postReservation = ()=>{
    const addLoadingButton = ref(false);
    const addReservation =async (reservation)=>{
        addLoadingButton.value = true;
        await axiosInstance.post('/reservation/create',reservation)
            .then(()=>{
                addLoadingButton.value = false;
            }).catch((err)=>{
                addLoadingButton.value = false;
                throw err;
            })
    };
    return {addReservation,addLoadingButton};
}
export default postReservation;
