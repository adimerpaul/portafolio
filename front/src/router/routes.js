import MainLayout from "layouts/MainLayout";
import IndexPage from "pages/IndexPage";
import Login from "pages/Login";
import Portafolio from "pages/Portafolio";
import User from "pages/User";
import Datos from "pages/Datos";

const routes = [
  {
    path: '/',
    component: MainLayout,
    children: [
      { path: '', component: IndexPage,meta: {requiresAuth: true}},
      { path: 'portafolio', component: Portafolio,meta: {requiresAuth: true}},
      { path: 'user', component: User,meta: {requiresAuth: true}},
      { path: 'datos', component: Datos,meta: {requiresAuth: true}},
    ]
  },
  {
    path: '/login',
    component: Login
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue')
  }
]

export default routes
