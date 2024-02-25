import axiosInstance from '../../config/axios/axios.js';
import {ref} from "vue";

const deleteCustomer = ()=>{
    const deleteLoadingButton = ref(false);
    const destroyCustomer = async (customer_id)=>{
        deleteLoadingButton.value = true;
        await axiosInstance.delete(`/customer/delete/${customer_id}`)
            .then(()=>{
                deleteLoadingButton.value = false;
            })
            .catch((err) =>{
                deleteLoadingButton.value = false;
                throw err;
            });
    }
    return {destroyCustomer,deleteLoadingButton};
}

export default deleteCustomer;
