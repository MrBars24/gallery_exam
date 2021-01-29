<template>
  <div>
    <q-btn
      label="Back"
      class="q-mt-md q-ml-md q-mb-md"
      color="blue"
      @click="$router.go(-1)">
    </q-btn>
    <div class="q-pa-md row items-start q-gutter-md">
      <q-img
        v-for="photo in photos" :key="photo.id"
        :src="photo.thumbnail_url"
        @click="viewPhoto(photo)"
        clickable v-ripple
        style="height: 300px; max-width: 300px"
        img-class="my-custom-image"
        class="rounded-borders"
      >
        <div class="absolute-bottom text-subtitle1 text-center">
          {{ photo.title }}
        </div>
      </q-img>
    </div>
  </div>
</template>

<script>
import { api } from 'boot/axios';

const photos = [];

export default {
  name: 'PagePhotos',
  data() {
    return {
      photos,
    };
  },
  created() {
    this.loadData();
  },
  methods: {
    viewPhoto(photo) {
      return this.$router.push({ name: 'photo_view', params: { photo_id: photo.id } });
    },
    loadData() {
      const albumId = this.$route.params.album_id;

      api.get(`/api/album/${albumId}/photos`)
        .then((response) => {
          this.photos = response.data;
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
