const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      {
        path: '',
        component: () => import('pages/Index.vue'),
        meta: {
          title: 'Persons',
        },
      },
      {
        name: 'album',
        path: 'user/:person_id/albums',
        component: () => import('pages/Albums.vue'),
        meta: {
          title: 'Albums',
        },
      },
      {
        name: 'photo',
        path: 'album/:album_id/photos',
        component: () => import('pages/Photos.vue'),
        meta: {
          title: 'Photos',
        },
      },
      {
        name: 'photo_view',
        path: 'photo/:photo_id',
        component: () => import('pages/PhotoView.vue'),
        meta: {
          title: 'Photos',
        },
      },
    ],
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '*',
    component: () => import('pages/Error404.vue'),
  },
];

export default routes;
