import axiosInstance from '../../config/axios/axios.js';
import {ref} from "vue";

const getPayment = ()=>{
    const payment = ref({});
    const loadPayment = async (payment_id)=>{
        await axiosInstance.get(`/payment/${payment_id}`)
            .then((res)=>{
                payment.value = res.data.data;
            }).catch((err)=>{
                throw err;
            })
    }
    return {payment,loadPayment};
}

export default getPayment;
