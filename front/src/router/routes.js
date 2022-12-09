import MainLayout from "layouts/MainLayout";
import IndexPage from "pages/IndexPage";
import Login from "pages/Login";
import Portafolio from "pages/Portafolio";
import User from "pages/User";
import Datos from "pages/Datos";
import Student from "pages/Student";
import Note from "pages/Note";
import Asistencia from "pages/Asistencia";

const routes = [
  {
    path: '/',
    component: MainLayout,
    children: [
      { path: '', component: IndexPage,meta: {requiresAuth: true}},
      { path: 'portafolio', component: Portafolio,meta: {requiresAuth: true}},
      { path: 'user', component: User,meta: {requiresAuth: true}},
      { path: 'datos', component: Datos,meta: {requiresAuth: true}},
      { path: 'student', component: Student,meta: {requiresAuth: true}},
      { path: 'note', component: Note,meta: {requiresAuth: true}},
      { path: 'asistencia', component: Asistencia,meta: {requiresAuth: true}},
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
