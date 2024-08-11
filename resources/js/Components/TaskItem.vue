<template>
    <div class="flex justify-between items-center">
        <div>
            <p>{{ taskitem.title }}</p>
            <p>{{ taskitem.body }}</p>
            <p>{{ taskitem.due_date }}</p>
        </div>
        <div>
            <button v-if="taskitem.status == 'created'" type="button" @click="changeStatus('end')"
                class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">End
                Task</button>
            <button v-else type="button" @click="changeStatus('created')"
                class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Return 
                Task</button>

            <button type="button" @click="editTask"
                class="text-white bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                Edit
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: ['taskitem'],
    name: 'TaskItem',
    data() {
        return {
            task: {
                type: Object
            }
        }
    },
    created() {
        this.task = { ...this.taskitem };
    },
    methods: {
        editTask() {
            this.$emit('edit-task', this.task);
        },
        changeStatus(status){
            this.task.status = status;
            this.$emit('change-task-status', this.task);
        }
    }
}
</script>

<style></style>
