
<template>
  <v-container>
    <div v-if="isUserLoggedIn">
      <Link :href="route('tasks.create')">
        <v-btn color="primary">New Task</v-btn>
      </Link>
    </div>


    <v-data-table
      :headers="headers"
      :items="tasks"
      item-key="id"
      v-model="selected"
      show-select
      item-value="name"
      return-object

    >
      <template v-slot:item.functions="{ item }">
        <div v-if="isUserLoggedIn">
          <Link :href="route('tasks.edit', {id: item.id})">
            <v-btn color="primary">
              Edit
            </v-btn>
          </Link>
        </div>
      </template>
    </v-data-table>
    <div v-if="selected.length > 0">
      Összesített tervezett idő: {{ totalEstimatedTime }} óra<br>
      Összesített felhasznált idő: {{ totalUsedTime }} óra
    </div>
    <div v-if="isUserLoggedIn">
      <v-btn color="red" @click="deleteSelected" :disabled="selected.length === 0">Delete</v-btn>
      <v-btn color="green" @click="markAsCompleted" :disabled="selected.length === 0">Mark as Completed</v-btn>
    </div>
  </v-container>

</template>

<script setup>
import { defineProps, ref, computed, reactive, onMounted} from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';

const isUserLoggedIn = ref(false);

onMounted(() => {
  checkUserLoggedIn();
});

function checkUserLoggedIn() {
  axios.get('/userCheck')
    .then(response => {
      isUserLoggedIn.value = true;
    })
    .catch(error => {
      isUserLoggedIn.value = false;
    });
}

const props = defineProps({
  tasks: Array,
});

const selected = ref([]);

const headers = reactive([
    { title: 'Task Name', value: 'name', key: 'name', sortable: true },
    { title: 'User Name', value: 'user.name', key: 'user.name', sortable: true },
    { title: 'Estimated Time', value: 'estimated_time', key: 'estimated_time', sortable: true },
    { title: 'Used Time', value: 'used_time', key: 'used_time', sortable: true },
    { title: 'Created At', value: 'created_at',  key: 'created_at', sortable: true },
    { title: 'Status', value: 'status', key: 'status', sortable: true },
    { title: 'Functions', value: 'functions', sortable: false, align: 'end' },
]);

const totalEstimatedTime = computed(() => {
  const totalMinutes = selected.value.reduce((total, task) => {
    return total + convertTimeToMinutes(task.estimated_time || '00:00');
  }, 0);
  const hours = Math.floor(totalMinutes / 60);
  const minutes = totalMinutes % 60;
  return `${hours}:${minutes.toString().padStart(2, '0')}`;
});

const totalUsedTime = computed(() => {
  const totalMinutes = selected.value.reduce((total, task) => {
    return total + convertTimeToMinutes(task.used_time || '00:00');
  }, 0);
  const hours = Math.floor(totalMinutes / 60);
  const minutes = totalMinutes % 60;
  return `${hours}:${minutes.toString().padStart(2, '0')}`;
});

function deleteSelected() {
  selected.value.forEach(task => {
    axios.delete(`/tasks/${task.id}`)
      .then(() => {
        console.log(`Task ${task.id} deleted`);
        window.location.href = '/dashboard';
      })
      .catch(error => {
        console.error('Error deleting task', error);
      });
  });
}

function markAsCompleted() {
  selected.value.forEach(task => {
    axios.post(`/tasks/${task.id}/complete`)
      .then(() => {
        console.log(`Task ${task.id} marked as completed`);
        window.location.href = '/dashboard';
      })
      .catch(error => {
        console.error('Error marking task as completed', error);
      });
  });
}


function convertTimeToMinutes(time) {
  const [hours, minutes] = time.split(':').map(Number);
  return hours * 60 + minutes;
}
</script>

