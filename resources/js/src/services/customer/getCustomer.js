import axiosInstance from '../../config/axios/axios.js'
import {ref} from 'vue';
const getCustomer = ()=>{
    const customer = ref({});
    const loadCustomer = async(customer_id)=>{
        await axiosInstance.get(`/customer/${customer_id}`)
            .then((res) => {
                customer.value = res.data.data;
            })
            .catch ((err) =>{
                throw err
            })
    }
    return {customer , loadCustomer};
}
export default getCustomer;
