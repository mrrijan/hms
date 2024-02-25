import {ref} from 'vue';
import axiosInstance from '../../config/axios/axios.js';

const getCustomers = ()=>{
    const customers = ref([]);
    const meta = ref([]);
    const customersLoading = ref(false);
    const loadCustomers = async ( url = '/customers')=>{
        customersLoading.value = true;
        await axiosInstance.get(url)
            .then((res) =>{
                customersLoading.value = false;
                customers.value = res.data.data;
                meta.value = res.data.meta;
            })
            .catch(err =>{
                customersLoading.value = false;
                throw err;
            });
    }
    return {customers , loadCustomers , meta , customersLoading};
}

export default getCustomers;
