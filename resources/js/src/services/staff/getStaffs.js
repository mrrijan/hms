import axiosInstance from '../../config/axios/axios.js';
import {ref} from 'vue';

const getStaffs = ()=>{
    const staffs = ref([]);
    const meta = ref([]);
    const staffsLoading = ref(true);

    const loadStaffs =async (url = '/staffs')=>{
        staffsLoading.value = true;
        await axiosInstance.get(url)
            .then((res)=>{
                staffsLoading.value = false;
                staffs.value = res.data.data;
                meta.value = res.data.meta;
            }).catch((err) =>{
                staffsLoading.value = false;
                throw err;
            })
    };
    return {staffs,meta,loadStaffs,staffsLoading};
}
export default getStaffs;
