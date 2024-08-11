<template>
  <form @submit.prevent="submitForm" class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md">
    <div class="mb-4">
      <label for="title" class="block text-gray-700 font-bold mb-2">Title</label>
      <input :required="true" type="text" id="title" v-model="form.title" required
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
    <div class="mb-4">
      <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
      <textarea  :required="true" id="description" v-model="form.body" required
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
    </div>

    <div class="mb-4">
      <input min="{{ date('Y-m-d') }}" :required="true" type="date" id="due_date" name="due_date" v-model="form.due_date"
      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
    </div>

    <button type="submit"
      class="bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">
      {{ isEditMode ? 'Update Task' : 'Create Task' }}
    </button>
  </form>
</template>

<script>
export default {
  name: "TaskForm",
  props: {
    task: {
      type: Object,
      default: () => null
    }
  },
  data() {
    return {
      form: {
        title: '',
        body: '',
        due_date: ''
      },
      isEditMode: false
    }
  },
  created() {
    if (this.task) {
      this.isEditMode = true;
      this.form = { ...this.task };
    }
  },
  methods: {
    submitForm() {
      if (this.isEditMode) {
        this.$emit('task-updated', { ...this.form });
      } else {
        this.$emit('task-created', { ...this.form, status: 'created' });
      }
      this.resetForm();
    },
    resetForm() {
      this.form = {
        title: '',
        description: '',
        due_date: ''
      };
      this.isEditMode = false;
    }
  }
}
</script>

<style scoped></style>
