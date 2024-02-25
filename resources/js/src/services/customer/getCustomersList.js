import axiosInstance from '../../config/axios/axios.js';
import {ref} from "vue";

const getCustomersList = ()=>{
    const customersList = ref([]);
    const loadCustomersList =async (url = '/customersList')=>{
        await axiosInstance.get(url).then((res)=>{
            customersList.value = res.data.data;
        }).catch((err)=>{
            throw err;
        })
    }
    return {customersList,loadCustomersList};
}
export default getCustomersList;
