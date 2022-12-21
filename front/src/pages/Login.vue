<template>
  <q-layout view="lHh Lpr lFf" class="bg-grey-2">
        <q-page-container>
    <q-page>
      <div class="row">
        <div class="col-1 col-sm-4"></div>
        <div class="col-10 col-sm-4">
          <div class="text-subtitle1 text-center q-pt-xs text-grey">CUENTA</div>
          <div class="text-h2 text-center q-pa-xs text-black text-bold">Tu Cuenta</div>
          <q-card flat bordered>
            <q-card-section >
              <q-form class="q-pa-lg" @submit.prevent="login">
                <div class="row">
                  <div class="col-12">
                    <q-input outlined v-model="email" label="Email" type="email" required />
                  </div>
                  <div class="col-12 q-pt-lg">
                    <q-input outlined v-model="password" label="Contraseña" :type="typePassword?'password':'text'" required >
                      <template v-slot:append>
                        <q-icon @click="typePassword=!typePassword" :name="typePassword?'visibility':'visibility_off'" />
                      </template>
                    </q-input>
                  </div>
                  <div class="col-12 q-py-xs">
                    <q-checkbox v-model="remember" class="grey" label="Recuérdame" size="30px" />
                  </div>
                  <div class="col-12 q-pt-xs">
                    <q-btn size="22px" :loading="loading" class="full-width bold" color="primary" label="Iniciar Sesión" type="submit" no-caps />
                  </div>
                  <div class="col-12 q-pt-xs">
<!--                    <q-btn to="signup" size="22px" outline class="full-width bold" color="primary" label="Registrate" type="submit" no-caps />-->
                  </div>
                  <div class="col-12 text-center q-py-none">
                    <a  @click="dialogRestore=true" class="text-blue-8 ">¿Olvidaste tu contraseña?</a>
                  </div>
                  <div class="col-12 text-center q-py-none text-caption">
                    <div class="linea"><span>O INICIAR SESIÓN CON</span></div>
                  </div>
                  <!--                    <div class="col-6 q-pt-md q-pr-xs">-->
                  <!--                      <q-btn outline icon="fa-brands fa-facebook" color="primary" class="full-width "/>-->
                  <!--                    </div>-->
                  <div class="col-12 q-pt-md q-pl-xs">
                    <q-btn size="22px" outline  label="Ingresar Administrador" @click="dialogRegister=true" no-caps color="primary" class="full-width "/>
                  </div>
                </div>
              </q-form>
            </q-card-section>
          </q-card>
          <div class="text-subtitle1 text-center text-caption q-pt-lg text-grey">AL INICIAR SESIÓN, USTED ACEPTA LOS
            <a  class="text-blue-8 ">TÉRMINOS DEL SERVICIO</a> Y <a href="" class="text-blue-8 ">LA POLÍTICA DE PRIVACIDAD</a>
          </div>
        </div>
        <div class="col-1 col-sm-4"></div>
      </div>
    </q-page>
        </q-page-container>
    <q-dialog v-model="dialogRegister" >
      <q-card>
        <q-card-section class="q-mb-none">
          <div class="text-h6">Inicio de session Administrador</div>
        </q-card-section>
        <q-card-section class="q-mt-none">
          <q-form @submit.prevent="login">
<!--            <q-input outlined v-model="user.name" label="Nombre" type="text" required />-->
            <q-input outlined v-model="email" label="Email" type="email" required />
            <q-input outlined v-model="password" label="Contraseña" :type="typePassword?'password':'text'" required >
              <template v-slot:append>
                <q-icon @click="typePassword=!typePassword" :name="typePassword?'visibility':'visibility_off'" />
              </template>
            </q-input>
            <q-input outlined v-model="user.password_confirmation" label="Clave Administrador" :type="typePassword?'password':'text'" required >
              <template v-slot:append>
                <q-icon @click="typePassword=!typePassword" :name="typePassword?'visibility':'visibility_off'" />
              </template>
            </q-input>
            <q-btn size="22px" :loading="loading" class="full-width bold" color="primary" label="Inicio de session" type="submit" no-caps />
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>
    <q-dialog v-model="dialogRestore" >
      <q-card>
        <q-card-section class="q-mb-none">
          <div class="text-h6">Recuperara Congraseña</div>
        </q-card-section>
        <q-card-section class="q-mt-none">
          <q-form @submit.prevent="restorePass">
            <!--            <q-input outlined v-model="user.name" label="Nombre" type="text" required />-->
            <q-input outlined v-model="email" label="Email" type="email" required />
            <q-input outlined v-model="password" label="nueva Contraseña" :type="typePassword?'password':'text'" required >
              <template v-slot:append>
                <q-icon @click="typePassword=!typePassword" :name="typePassword?'visibility':'visibility_off'" />
              </template>
            </q-input>
            <q-input outlined v-model="user.password_confirmation" label="Confirmar nueva Contraseña" :type="typePassword?'password':'text'" required >
              <template v-slot:append>
                <q-icon @click="typePassword=!typePassword" :name="typePassword?'visibility':'visibility_off'" />
              </template>
            </q-input>
            <q-btn size="22px" :loading="loading" class="full-width bold" color="primary" label="Recuperar" type="submit" no-caps />
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>
  </q-layout>
</template>

<script>
import {useCounterStore} from "stores/example-store";
import { Providers} from 'universal-social-auth'
export default {
  name: `Login`,
  data () {
    return {
      dialogRestore:false,
      user: {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      },
      email: '',
      dialogRegister: false,
      password: '',
      remember:false,
      typePassword:true,
      loading:false,
      store:useCounterStore()
    }
  },
  mounted() {
    if (this.store.isLoggedIn){
      this.$router.push('/')
    }
  },
  methods:{
    restorePass(){
      this.loading=true
      this.$api.post('restorePass',{
        email:this.email,
        password:this.password,
        password_confirmation:this.user.password_confirmation
      }).then(res=>{
        this.loading=false
        this.dialogRestore=false
        this.$q.notify({
          message: 'Se ha enviado un correo para recuperar su contraseña',
          color: 'positive',
          position: 'top',
          timeout: 2500
        })
      }).catch(err=>{
        this.loading=false
        this.$q.notify({
          message: 'Error al recuperar contraseña',
          color: 'negative',
          position: 'top',
          timeout: 2500
        })
      })
    },
    registerUser(){
      this.loading=true
      this.$api.post('register',this.user).then((res)=>{
        this.loading=false
        this.$q.notify({
          message: 'Usuario registrado correctamente',
          color: 'positive',
          icon: 'check_circle',
          position: 'top'
        })
        this.dialogRegister=false
        this.$router.push('/')
        this.store.user=res.data.user
        this.store.isLoggedIn=true
        this.$api.defaults.headers.common['Authorization'] = 'Bearer '+res.data.token
        localStorage.setItem('tokenPort',res.data.token)
      }).catch((error)=>{
        this.loading=false
        this.$q.notify({
          message: error.response.data.message,
          color: 'negative',
          icon: 'error',
          position: 'top'
        })
      })
    },
    useAuthProvider (provider, proData) {
      const pro = proData
      const ProData = pro || Providers[provider]
      this.$q.loading.show()
      this.$Oauth.authenticate(provider, ProData).then((response) => {
        if (response.code) {
          this.$api.post('sociallogin/'+provider,response).then(res => {
            // console.log(response.data)
            this.$q.loading.hide()
            this.$q.notify({
              message: 'Bienvenido',
              color: 'positive',
              icon: 'check_circle',
              position: 'top'
            })
            this.$router.push('/')
            this.store.user=res.data.user
            this.store.isLoggedIn=true
            this.$api.defaults.headers.common['Authorization'] = 'Bearer '+res.data.token
            localStorage.setItem('tokenPort',res.data.token)
          }).catch(err => {
            console.log({err:err})
          }).finally(() => {
            this.$q.loading.hide()
          })
        }else{
          this.$q.loading.hide()
        }
      }).catch((err) => {
        console.log(err)
      }).finally(() => {
        // this.$q.loading.hide()
      })
    },
    login(){
      this.loading=true
      this.$api.post('login', {
        email: this.email,
        password: this.password,
      }).then(res => {
        this.$q.notify({
          message: 'Bienvenido',
          color: 'positive',
          icon: 'check_circle',
          position: 'top'
        })
        this.$router.push('/')
        this.store.user=res.data.user
        this.store.isLoggedIn=true
        this.$api.defaults.headers.common['Authorization'] = 'Bearer '+res.data.token
        localStorage.setItem('tokenPort',res.data.token)
      }).catch(error => {
        console.log(error)
        this.$q.notify({
          message: error.response.data.message,
          color: 'negative',
          position: 'top',
          timeout: 2000
        })
      }).finally(()=>{
        this.loading=false
      })
    }
  }
}
</script>

<style scoped>
div.linea {
  position: relative;
  z-index: 1;
}
div.linea:before {
  border-top: 1px solid grey;
  content: "";
  margin: 0 auto;
  position: absolute;
  top: 50%;
  left: 0;
  right: 0;
  bottom: 0;
  width: 95%;
  z-index: -1;
}
div.linea span {
  background: #fff;
  padding: 0 10px;
  color: grey;
}
</style>
