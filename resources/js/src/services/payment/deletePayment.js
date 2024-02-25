import axiosInstance from '../../config/axios/axios.js';
import {ref} from "vue";

const deletePayment = () => {
    const deleteLoadingButton = ref(false);
    const destroyPayment = async (payment_id) => {
        deleteLoadingButton.value = true;
        await axiosInstance.delete(`/payment/delete/${payment_id}`)
            .then(() => {
                deleteLoadingButton.value = false;
            }).catch((err) => {
                deleteLoadingButton.value = false;
                throw err;
            })
    }
    return {destroyPayment, deleteLoadingButton};
}
export default deletePayment;
