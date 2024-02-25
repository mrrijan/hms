import axiosInstance from '../../config/axios/axios.js';
import {ref} from "vue";

const getPayments = ()=>{
    const payments = ref([]);
    const meta = ref([]);
    const paymentsLoading = ref(false);
    const loadPayments =async (url = '/payments')=>{
        paymentsLoading.value =true;
        await axiosInstance.get(url)
            .then((res)=>{
                paymentsLoading.value =false;
                payments.value = res.data.data;
                meta.value = res.data.meta;
            }).catch((err)=>{
                paymentsLoading.value =false;
                throw err;
            })
    }
    return {payments,meta,loadPayments,paymentsLoading};
}
export default getPayments;
