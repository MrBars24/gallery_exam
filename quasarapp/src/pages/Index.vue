<template>
  <q-list bordered>
    <q-item v-for="contact in contacts" :key="contact.id"
      :to="{name: 'album', params: {person_id: contact.id}}" class="q-my-sm" clickable v-ripple>
      <q-item-section avatar>
        <q-avatar color="primary" text-color="white">
          {{ contact.name_initials }}
        </q-avatar>
      </q-item-section>

      <q-item-section>
        <q-item-label>{{ contact.name }}</q-item-label>
        <q-item-label caption lines="1">{{ contact.email }}</q-item-label>
      </q-item-section>
    </q-item>
  </q-list>
</template>

<script>
import { api } from 'boot/axios';

const contacts = [];

export default {
  name: 'PageIndex',
  data() {
    return {
      contacts,
    };
  },
  created() {
    this.loadData();
  },
  methods: {
    loadData() {
      api.get('/api/persons')
        .then((response) => {
          this.contacts = response.data;
        })
        .catch(() => {
          this.$q.notify({
            color: 'negative',
            position: 'top',
            message: 'Loading failed',
            icon: 'report_problem',
          });
        });
    },
  },
};
</script>
