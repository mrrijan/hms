import axiosInstance from '../../config/axios/axios.js';
import {ref} from "vue";

const postCustomer = ()=>{
    const addCustomerLoading = ref(false);
    const addCustomer =async  (customer)=>{
        addCustomerLoading.value = true;
        await axiosInstance.post('/customer/create',customer)
            .then(()=>{
                addCustomerLoading.value = false;
            }).catch((err) => {
                addCustomerLoading.value = false;
                throw err
            });
    }
    return {addCustomer ,addCustomerLoading};
}

export default postCustomer;
