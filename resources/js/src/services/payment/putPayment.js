import axiosInstance from '../../config/axios/axios.js';
import {ref} from "vue";

const putPayment = () => {
    const updateLoadingButton = ref(false);
    const updatePayment = async (payment) => {
        updateLoadingButton.value = true;
        await axiosInstance.post('/payment/update', payment)
            .then(() => {
                updateLoadingButton.value = false;
            }).catch(() => {
                updateLoadingButton.value = false;
            });
    }
    return {updatePayment, updateLoadingButton};
}
export default putPayment;
