<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';
import axios from 'axios';

const props = defineProps({
  task: Object,
  users: Array,
});

const task = ref(props.task);

function formatTime(time) {
  // Az idő formátumának átalakítása H:i formátumra a validáció miatt.
  return time ? time.substring(0, 5) : '';
}

function updateTask() {
  task.value.estimated_time = formatTime(task.value.estimated_time);
  task.value.used_time = formatTime(task.value.used_time);
  
  axios.post(`/tasks/${task.value.id}/update`, task.value)
    .then(() => {
      window.location.href = '/dashboard';
    })
    .catch(error => {
      console.error('Error updating task', error);
    });
}
</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Update Task
      </h2>
    </template>
      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <v-container>
              <v-form @submit.prevent="updateTask">
                <v-text-field
                  v-model="task.name" 
                  label="Name"
                  outlined>
                </v-text-field>
                <v-textarea 
                   v-model="task.description"
                   label="Description"
                   outlined>
                </v-textarea>
                <v-select
                   v-model="task.user_id"
                   :items="users"
                   label="Assignee"
                   item-title="name"
                   item-value="id"
                   outlined>
                </v-select>
                <v-select
                   v-model="task.status"
                   :items="['Inprogress', 'Completed']"
                   label="Status"
                   outlined>
                </v-select>
                <v-container>
                  <v-row>
                    <v-col cols="6">
                      <v-text-field
                           v-model="task.estimated_time"
                           label="Estimated Time"
                           placeholder="H:i"
                           type="time">
                        </v-text-field>
                    </v-col>
                    <v-col cols="6">
                      <v-text-field
                           v-model="task.used_time"
                           label="Used Time"
                           outlined
                           placeholder="H:i"
                           type="time">
                        </v-text-field>
                    </v-col>
                  </v-row>
                </v-container>
                <v-btn color="primary" type="submit">Update Task</v-btn>
              </v-form>
            </v-container>
          </div>
        </div>
      </div>
  </AppLayout>
</template>



