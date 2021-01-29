<template>
  <div>
    <form @submit.prevent="submitUpdate" class="q-pa-md">
      <div class="q-pa-md row items-start q-gutter-md">
        <q-img
          :src="photo.url"
          clickable v-ripple
          style="height: 300px; max-width: 300px"
          img-class="my-custom-image"
          class="rounded-borders"
        >
        </q-img>
      </div>
      <div class="q-pa-md q-gutter-md">
        <q-input v-model="frm.title" label="Title" />
        <q-input v-model="frm.url" label="URL" />
        <q-input v-model="frm.thumbnail_url" label="Thumbnail URL" />
      </div>

      <div class="col-4">
        <q-btn
          :loading="submitting"
          label="Back"
          class="q-mt-md q-ml-md"
          color="blue"
          @click="$router.go(-1)">
        </q-btn>
        <q-btn
          type="submit"
          :loading="submitting"
          label="Save"
          class="q-mt-md q-ml-md"
          color="teal"
        ><template v-slot:loading>
            <q-spinner-facebook />
          </template>
        </q-btn>
        <q-btn
          @click="deletePhoto"
          :loading="submitting"
          label="Delete"
          class="q-mt-md q-ml-md"
          color="red"
        ><template v-slot:loading>
            <q-spinner-facebook />
          </template>
        </q-btn>
      </div>
    </form>
  </div>
</template>

<script>
/* eslint-disable */
import { api } from 'boot/axios';
import { Notify } from 'quasar';

const photo = {};

export default {
  name: 'PagePhotoView',
  data() {
    return {
      submitting: false,
      frm: {},
      photo,
    };
  },
  created() {
    this.loadData();
  },
  methods: {
    deletePhoto() {
      this.submitting = true;
      const photoId = this.$route.params.photo_id;

      let formData = new FormData();
      formData.append('_method', 'delete');

      api.post(`/api/photo/${photoId}`, formData)
      .then((response) => {
        if (response.data.success) {
          Notify.create({
            type: 'positive',
            color: 'positive',
            timeout: 1000,
            position: 'top',
            message: 'Data deleted successfully',
          });

          setTimeout(() => {
            this.$router.back()
          }, 1000);

          this.submitting = false;
        }
      })
      .catch(function (error) {
        console.log(error);
      });
    },
    submitUpdate() {
      this.submitting = true;
      const photoId = this.$route.params.photo_id;

      let formData = new FormData();
      formData.append('title', this.frm.title);
      formData.append('url', this.frm.url);
      formData.append('thumbnail_url', this.frm.thumbnail_url);
      formData.append('_method', 'put');
      console.log(formData);

      api.post(`/api/photo/${photoId}`, formData)
      .then((response) => {
        if (response.data.success) {
          Notify.create({
            type: 'positive',
            color: 'positive',
            timeout: 1000,
            position: 'top',
            message: 'Data saved successfully',
          });

          this.photo = Object.assign({}, this.frm);
          this.submitting = false;
        }
      })
      .catch(function (error) {
        console.log(error);
      });
    },
    loadData() {
      const photoId = this.$route.params.photo_id;

      api.get(`/api/photo/${photoId}`)
        .then((response) => {
          this.frm = Object.assign({}, response.data);
          this.photo = Object.assign({}, response.data);
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
