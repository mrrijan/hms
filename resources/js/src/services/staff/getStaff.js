import axiosInstance from '../../config/axios/axios.js';
import {ref} from 'vue';

const getStaff = ()=>{
    const staff = ref({});
    const loadStaff = async (staff_id)=>{
            await axiosInstance.get(`/staff/${staff_id}`)
                .then((res)=>{
                    staff.value = res.data.data;
                }).catch((err) =>{
                    throw err;
                })
    }
    return {staff,loadStaff};
}
export default getStaff;
