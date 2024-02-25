<script setup>
import {useRouter, useRoute} from "vue-router";

const props = defineProps(['meta', 'routeName'])
const router = useRouter()
const route = useRoute()


const handleCurrentChange = (val) => {
    router.push({name: props.routeName, query: {...route.query, page: val}})
}
</script>

<template>
    <el-scrollbar>
        <el-row justify="end">
            <el-col>
                <el-pagination
                    background
                    :page-size="meta.per_page"
                    :pager-count="6"
                    layout="total, prev, pager, next, jumper"
                    :total="meta.total"
                    :hide-on-single-page="Number(route.query?.page) || 1 === 1"
                    :current-page="Number(route.query?.page) || 1"
                    @current-change="handleCurrentChange"
                />
            </el-col>
        </el-row>
    </el-scrollbar>

</template>

<style scoped>
.el-row {
    margin-top: 20px;
}
</style>
