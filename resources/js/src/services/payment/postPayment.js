import axiosInstance from '../../config/axios/axios.js';
import {ref} from "vue";

const postPayment = () => {
    const addLoadingButton = ref(false);
    const addPayment = async (payment) => {
        addLoadingButton.value = true;
        await axiosInstance.post('/payment/create', payment)
            .then(() => {
                addLoadingButton.value = false;
            }).catch(() => {
                addLoadingButton.value = false;
            });
    }
    return {addPayment, addLoadingButton};
}
export default postPayment;
