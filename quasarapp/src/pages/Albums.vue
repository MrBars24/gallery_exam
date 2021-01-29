<template>
  <div>
    <q-btn
      label="Back"
      class="q-mt-md q-ml-md q-mb-md"
      color="blue"
      @click="$router.go(-1)">
    </q-btn>
    <q-list bordered>
      <q-item v-for="album in albums" :key="album.id" class="q-my-sm"
        :to="{name: 'photo', params: {album_id: album.id}}" clickable v-ripple>
        <q-item-section avatar>
          <q-avatar color="primary" text-color="white">
            {{ album.photo_count }}
          </q-avatar>
        </q-item-section>

        <q-item-section>
          <q-item-label>{{ album.title }}</q-item-label>
        </q-item-section>
      </q-item>
    </q-list>
  </div>
</template>

<script>
/* eslint-disable */
import { api } from 'boot/axios';

const albums = [];

export default {
  name: 'PageAlbum',
  data() {
    return {
      albums,
    };
  },
  created() {
    this.loadData();
  },
  methods: {
    loadData() {
      
      const userId = this.$route.params.person_id;

      api.get(`/api/user/${userId}/albums`)
        .then((response) => {
          this.albums = response.data;
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
