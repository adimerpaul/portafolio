<template>
  <q-layout view="lHh Lpr lFf" class="bg-grey-2">
    <q-header class="bg-grey-2">
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          color="primary"
          icon="menu"
          aria-label="Menu"
          @click="toggleLeftDrawer"
        />
        <q-toolbar-title class="text-bold text-primary">
          <div v-if="!$q.screen.lt.md">{{store.user.name}}</div>
        </q-toolbar-title>
        <div class="row q-pt-xs">
          <div class="col-8">
            <q-input dense rounded outlined v-model="search" placeholder="Buscar">
              <template v-slot:prepend>
                <q-icon name="search" />
              </template>
            </q-input>
          </div>
          <div class="col-2 flex flex-center">
            <q-btn
              flat
              dense
              round
              color="primary"
              icon="o_notifications"
              aria-label="Notifications">
              <q-badge color="primary" floating transparent>
                4
              </q-badge>
            </q-btn>
          </div>
          <div class="col-2 flex flex-center">
            <q-btn round>
              <q-avatar size="38px">
                <img v-if="store.user.foto!=undefined" :src="url+'../imagenes/'+store.user.foto">
              </q-avatar>
              <q-menu>
                <q-list style="min-width: 100px">
                  <q-item clickable v-ripple to="/datos">
                    <q-item-section avatar>
                      <q-icon color="primary" name="perm_contact_calendar" />
                    </q-item-section>
                    <q-item-section>{{store.user.name}}</q-item-section>
                  </q-item>
                  <q-separator />
                  <q-item clickable v-ripple @click="logout">
                    <q-item-section avatar>
                      <q-icon color="primary" name="logout" />
                    </q-item-section>
                    <q-item-section>Salir</q-item-section>
                  </q-item>
                </q-list>
              </q-menu>
            </q-btn>
          </div>
        </div>
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      bordered
    >
      <q-list>
        <q-item-label class="q-pa-xs">
          <div class="row">
            <div class="col-3 flex flex-center">
              <q-icon color="primary" size="48px" name="o_inventory_2" />
            </div>
            <div class="col-9">
              <div class="text-h6 text-bold " >Portafolio</div>
              <div class="text-caption">
                <q-badge>Virtual</q-badge> 1.48.5
              </div>
            </div>
          </div>
        </q-item-label>
        <q-separator />
        <q-toolbar class="bg-primary text-white shadow-2">
          <q-toolbar-title>Opciones</q-toolbar-title>
        </q-toolbar>

<!--        <q-list bordered>-->
<!--          <q-list>-->
            <q-item clickable v-ripple to="/" exact active-class="bg-blue-grey-6  text-white">
              <q-item-section avatar><q-icon name="o_home" /></q-item-section>
              <q-item-section>
                <q-item-label lines="1">Principal</q-item-label>
                <q-item-label caption>Inicio</q-item-label>
              </q-item-section>
<!--              <q-item-section side>-->
<!--                <q-item-label caption>-->
<!--                  {{ conversation.time }}-->
<!--                </q-item-label>-->
<!--                <q-icon name="keyboard_arrow_down" />-->
<!--              </q-item-section>-->
            </q-item>
        <q-item clickable v-ripple to="/user" v-if="store.user.name=='admin'" exact active-class="bg-blue-grey-6  text-white">
          <q-item-section avatar><q-icon name="o_people" /></q-item-section>
          <q-item-section>
            <q-item-label lines="1">Usuarios</q-item-label>
            <q-item-label caption>Control de usuarios</q-item-label>
          </q-item-section>
          <!--              <q-item-section side>-->
          <!--                <q-item-label caption>-->
          <!--                  {{ conversation.time }}-->
          <!--                </q-item-label>-->
          <!--                <q-icon name="keyboard_arrow_down" />-->
          <!--              </q-item-section>-->
        </q-item>
        <q-item clickable v-ripple to="/portafolio" exact active-class="bg-blue-grey-6  text-white">
          <q-item-section avatar><q-icon name="o_description" /></q-item-section>
          <q-item-section>
            <q-item-label lines="1">Portafolio digital</q-item-label>
            <q-item-label caption>Docente</q-item-label>
          </q-item-section>
          <!--              <q-item-section side>-->
          <!--                <q-item-label caption>-->
          <!--                  {{ conversation.time }}-->
          <!--                </q-item-label>-->
          <!--                <q-icon name="keyboard_arrow_down" />-->
          <!--              </q-item-section>-->
        </q-item>
        <q-item clickable v-ripple to="/datos" exact active-class="bg-blue-grey-6  text-white">
          <q-item-section avatar><q-icon name="o_face" /></q-item-section>
          <q-item-section>
            <q-item-label lines="1">Mis datos</q-item-label>
<!--            <q-item-label caption>Docente</q-item-label>-->
          </q-item-section>
        </q-item>
        <q-item clickable v-ripple to="/student" exact active-class="bg-blue-grey-6  text-white">
          <q-item-section avatar><q-icon name="people" /></q-item-section>
          <q-item-section>
            <q-item-label lines="1">Lista de estudiantes</q-item-label>
          </q-item-section>
        </q-item>
        <q-item clickable v-ripple to="/schedule" exact active-class="bg-blue-grey-6  text-white">
          <q-item-section avatar><q-icon name="schedule" /></q-item-section>
          <q-item-section>
            <q-item-label lines="1">Horarios</q-item-label>
          </q-item-section>
        </q-item>
        <q-item clickable v-ripple to="/note" exact active-class="bg-blue-grey-6  text-white">
          <q-item-section avatar><q-icon name="verified" /></q-item-section>
          <q-item-section>
            <q-item-label lines="1">Notas</q-item-label>
          </q-item-section>
        </q-item>
        <q-item clickable v-ripple to="/asistencia" exact active-class="bg-blue-grey-6  text-white">
          <q-item-section avatar><q-icon name="checklist" /></q-item-section>
          <q-item-section>
            <q-item-label lines="1">Asistencia</q-item-label>
          </q-item-section>
        </q-item>
<!--          </q-list>-->
<!--          <q-separator />-->
          <!--          <q-item-label header>Desconectados</q-item-label>-->

          <!--          <q-item v-for="contact in offline" :key="contact.id" class="q-mb-sm" clickable v-ripple>-->
          <!--            <q-item-section avatar>-->
          <!--              <q-avatar>-->
          <!--                <img :src="`https://cdn.quasar.dev/img/${contact.avatar}`">-->
          <!--              </q-avatar>-->
          <!--            </q-item-section>-->

          <!--            <q-item-section>-->
          <!--              <q-item-label>{{ contact.name }}</q-item-label>-->
          <!--              <q-item-label caption lines="1">{{ contact.email }}</q-item-label>-->
          <!--            </q-item-section>-->

          <!--            <q-item-section side>-->
          <!--              <q-icon name="chat_bubble" color="grey" />-->
          <!--            </q-item-section>-->
          <!--          </q-item>-->
<!--        </q-list>-->
      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>

  </q-layout>
</template>

<script>
import {useCounterStore} from "stores/example-store";
import {date} from "quasar";
export default {
  name: 'MainLayout',
  data () {
    return {
      loading: false,
      url:process.env.API,
      leftDrawerOpen: false,
      search: '',
      store:useCounterStore(),
      menu:false,
      message:'',
    }
  },
  created() {
  },
  methods: {
    reload(){
      this.$q.dialog({
        title: 'Actualizar',
        message: '??Desea actualizar la informaci??n?',
        cancel: true,
        persistent: true
      }).onOk(() => {
        window.location.href = window.location.href
        window.location.replace(window.location.href)
      })
    },
    logout(){
      this.$q.dialog({
        message:'??Quieres cerrar sesi??n?',
        title:"Salir",
        ok:{
          push:true
        },
        cancel:{
          push:true,
          color:'negative'
        }
      }).onOk(()=>{
        this.$q.loading.show()
        this.$api.post('logout').then(res=>{
          this.$api.defaults.headers.common['Authorization']=''
          this.store.user={}
          this.store.negocio={}
          this.store.userChat={}
          localStorage.removeItem('tokenPort')
          this.store.isLoggedIn=false
          this.$router.push('/login')
          this.$q.loading.hide()
        })
      })
    },
    toggleLeftDrawer () {
      this.leftDrawerOpen = !this.leftDrawerOpen
    }
  }
}
</script>
