import axiosInstance from '../../config/axios/axios.js';
import {ref} from "vue";

const deleteStaff = ()=>{
    const deleteLoadingButton = ref(false);
    const destroyStaff = async (staff_id)=>{
        deleteLoadingButton.value = true;
            await axiosInstance.delete(`/staff/delete/${staff_id}`)
                .then(()=>{
                    deleteLoadingButton.value = false;
                }).catch((err)=>{
                    deleteLoadingButton.value = false;
                    throw err;
                })
    }
    return {destroyStaff,deleteLoadingButton};
}
export default deleteStaff;
