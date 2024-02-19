<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { defineProps, onMounted, computed  } from 'vue';
import axios from 'axios';


const props = defineProps({
  users: Array,
});

</script>

<template>

  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Create Task
      </h2>
    </template>
    <v-app>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <v-container>

            <v-form @submit.prevent="submitTask">
              <v-text-field
                v-model="task.name"
                label="Name"
                outlined
              ></v-text-field>

              <v-textarea
                v-model="task.description"
                label="Description"
                outlined
              ></v-textarea>

              <v-select
                v-model="task.user_id"
                :items="users"
                label="Assignee"
                name="user_id"
                outlined
                item-title="name"
                item-value="id"
              ></v-select>

              <v-select
                v-model="task.status"
                :items="['Inprogress', 'Completed']"
                label="Status"
                outlined
              ></v-select>

              <v-container>
                <v-row>
                  <v-col cols="6">
                    <v-text-field
                      v-model="task.estimated_time"
                      label="Estimated Time"
                      outlined
                      placeholder="HH:MM"
                      type="time"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="6">
                    <v-text-field
                      v-model="task.used_time"
                      label="Used Time"
                      outlined
                      placeholder="HH:MM"
                      type="time"
                    ></v-text-field>
                  </v-col>
                </v-row>

              </v-container>

              <v-btn color="primary" type="submit">Create Task</v-btn>
            </v-form>
          </v-container>
        </div>
      </div>
    </div>
  </v-app>

  </AppLayout>
</template>

<script>

export default {
  data() {
    return {
      task: {
        name: '',
        description: '',
        user_id: '',
        estimated_time: '',
        used_time: '',
        status: 'Inprogress',
      },
    };
  },
  methods: {
    submitTask() {
      axios.post('/tasks/store', this.task)
        .then(() => {
          window.location.href = '/dashboard';

        })
        .catch(error => {
          console.error('Error creating task', error);
        });
    },
  },
};
</script>
