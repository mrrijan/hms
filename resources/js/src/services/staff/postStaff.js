import axiosInstance from '../../config/axios/axios.js';
import {ref} from "vue";

const postStaff = ()=>{
    const addLoadingButton = ref(false);
    const addStaff =async (staff)=>{
        addLoadingButton.value = true;
            await axiosInstance.post('/staff/create',staff)
                .then(()=>{
                    addLoadingButton.value = false;
                }).catch((err)=>{
                    addLoadingButton.value = false;
                    throw err;
                });
    };
    return {addStaff,addLoadingButton};
}
export default postStaff;
