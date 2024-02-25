import axiosInstance from '../../config/axios/axios.js';
import {ref} from "vue";

const putCustomer = ()=>{
    const updateLoadingButton = ref(false);
    const updateCustomer =async (customer)=>{
        updateLoadingButton.value = true;
        await  axiosInstance.post('/customer/update',customer)
            .then(()=>{
                updateLoadingButton.value = false;
            })
            .catch((err) =>{
                updateLoadingButton.value = false;
                throw err;
            });
    }
    return {updateCustomer,updateLoadingButton};
};

export default putCustomer;
