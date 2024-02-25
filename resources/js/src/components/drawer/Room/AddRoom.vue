<script setup>
import {reactive, ref} from "vue";
import postRoom from '../../../services/room/postRoom.js';

const {addRoom, addLoadingButton} = postRoom();
const formRef = ref(null);
const emit = defineEmits(['content-updated']);
const addRoomDrawer = defineModel();
const roomForm = reactive({
    room_number: '',
    maximum_occupancy: 1,
    occupancy_status: false,
    number_of_beds: 1,
});
const handleSubmit = (formEl) => {
    const room = {
        room_number: roomForm.room_number,
        maximum_occupancy: roomForm.maximum_occupancy,
        occupancy_status: roomForm.occupancy_status,
        number_of_beds: roomForm.number_of_beds,
    };
    formEl
        .validate((valid) => {
            if (valid)
                addRoom(room).then(() => {
                    addRoomDrawer.value = false;
                    emit('content-updated');
                }).catch((err) => {
                    console.log(err);
                });
        }).catch();

}
const resetFields = () => {
    roomForm.room_number = '';
    roomForm.maximum_occupancy = 1;
    roomForm.occupancy_status = false;
    roomForm.number_of_beds = 1;
}
const validateMaximumOccupancy = (rule, value, callback) => {
    if (!value) callback(new Error('Maximum Occupancy cannot be empty'));
    if (value == null) callback(new Error('Maximum occupancy cannot be empty'));
    return true;
}
const validateNumberOfBeds = (rule, value, callback) => {
    if (!value) callback(new Error('Number of beds cannot be empty'));
    if (value == null) callback(new Error('Number of beds cannot be empty'));
    return true;
}
const rules = reactive({
    maximum_occupancy: [{validator: validateMaximumOccupancy, trigger: 'blur'}],
    number_of_beds: [{validator: validateNumberOfBeds, trigger: 'blur'}]
})
</script>

<template>
    <el-drawer
        v-model="addRoomDrawer"
        title="Add Room"
        direction="rtl"
        @open="resetFields"
    >
        <el-form :rules="rules" ref="formRef" :model="roomForm" label-position="top" size="small">
            <el-form-item prop="room_number" label="Room Number"
                          :rules="[{required : true , message : 'Please enter room number'}]" required>
                <el-input v-model="roomForm.room_number"/>
            </el-form-item>
            <el-form-item prop="maximum_occupancy" label="Maximum Occupancy">
                <el-input-number min="1" v-model="roomForm.maximum_occupancy"/>
            </el-form-item>
            <el-form-item prop="occupancy_status" label="Occupancy Status">
                <el-checkbox v-model="roomForm.occupancy_status" label="Occupied"/>
            </el-form-item>
            <el-form-item prop="number_of_beds" label="Number of beds">
                <el-input-number min="1" v-model="roomForm.number_of_beds"/>
            </el-form-item>
            <el-form-item>
                <el-button :loading="addLoadingButton" type="primary" @click="handleSubmit(formRef)">Create</el-button>
            </el-form-item>
        </el-form>
    </el-drawer>
</template>

<style scoped>

</style>
