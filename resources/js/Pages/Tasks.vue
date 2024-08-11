<template>
    <nav class="p-4">
        <AlertMessage class="fixed top-0 left-0 right-0" v-if="errorMessage" :message="errorMessage" :timer="2000" />
        <button @click="showModalToCreateTask" type="button"
            class="display block py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
            Enter new Task
        </button>

        <Modal :isOpen="modal.createTask" @close="hideModalToCreateTask">
            <TaskForm @task-created="createTask" :task="clearFormTemplate" />
        </Modal>
    </nav>
    <div class="p-4">
        <div>
            <TaskItem @change-task-status="toggleTaskStatus" class="container" v-for="task in localTasks" :key="task.id"
                :taskitem="task" @edit-task="showEditForm" />
            <Modal :isOpen="modal.editTask" @close="hideModalToCreateTask">
                <TaskForm :task="taskToEdit" @task-updated="updateTask" />
            </Modal>
        </div>
    </div>
</template>

<script>
import TaskForm from "@/Components/TaskForm.vue";
import Modal from "@/Components/Modal.vue";
import TaskItem from "@/Components/TaskItem.vue";
import AlertMessage from "@/Components/AlertMessage.vue";
import axios from "axios";



export default {
    props: {
        tasks: {
            type: Object,
            default: {}
        },
    },
    data() {
        return {
            showModal: false,
            modal: {
                createTask: false,
                editTask: false
            },
            taskToEdit: null,
            localTasks: null,
            errorMessage: null
        }
    },
    created() {
        this.localTasks = this.tasks
    },
    components: { TaskItem, Modal, TaskForm, AlertMessage },
    methods: {
        toggleTaskStatus(task) {
            axios.put('/tasks/' + task.id, task).then(res => {
                this.localTasks = this.localTasks.map(t => {
                    return t.id === res.data.id ? res.data : t
                });
            }).catch(err => {
                this.errorMessage = err.response.data.message;
                setTimeout(() => {
                    this.errorMessage = null;
                }, 2000);
            });
        },
        showEditForm(task) {
            this.modal.editTask = true;
            this.taskToEdit = task;
        },
        updateTask(task) {
            this.hideModalToCreateTask();
            axios.put('/tasks/' + task.id, task).then(res => {
                this.localTasks = this.localTasks.map(t => {
                    return t.id === res.data.id ? res.data : t
                });
            })
            this.taskToEdit = null;
        },
        showModalToCreateTask() {
            this.resetForm();
            this.modal.createTask = true;
        },
        hideModalToCreateTask() {
            this.modal.createTask = false;
            this.modal.editTask = false;
        },
        resetForm() {
            this.formTemplate = {
                title: '',
                description: '',
                task_day: ''
            };
        },
        createTask(task) {
            axios.post('/tasks', task).then(res => {
                this.localTasks.push(res.data);
                this.hideModalToCreateTask();
            });
        }
    }
}
</script>

<style scoped>
.container {
    padding: 5px 10px;
    border: 1px inherit #ccffab;
    border-radius: 15px;
    background: #46d698;
    margin: 15px 10px;
}
</style>
