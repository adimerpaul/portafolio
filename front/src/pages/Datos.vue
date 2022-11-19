<template>
  <q-page>
    <q-card>
      <q-card-section>
        <q-form  @submit.prevent="userSave">
          <div class="row q-pa-lg">
            <div class="col-12 col-sm-6">
              <q-input dense outlined v-model="store.user.name" label="Nombre completo" hint="" required />
            </div>
            <div class="col-12 col-sm-6">
              <q-input dense outlined v-model="store.user.email" label="Correo" hint="" required/>
            </div>
            <div class="col-12 col-sm-6">
              <q-input dense outlined v-model="store.user.filosofia" label="Filosofía" hint="" required/>
            </div>
            <div class="col-12 col-sm-6">
              <q-input dense outlined v-model="store.user.ensenanza" label="Enseñanza" hint="" required/>
            </div>
            <div class="col-12 col-sm-6">
              <q-input dense outlined v-model="store.user.estrategia" label="Estrategia" hint="" required/>
            </div>
            <div class="col-12 col-sm-6">
              <q-input dense outlined v-model="store.user.objeto" label="Objetivo" hint="" required/>
            </div>
            <div class="col-12 col-sm-6">
              <q-input dense outlined v-model="store.user.metodologia" label="Metodología" hint="" required/>
            </div>
            <div class="col-12 col-sm-6">
              <q-input dense outlined v-model="store.user.curriculum" label="Curriculum" hint="" required/>
            </div>
            <div class="col-12 flex flex-center">
              <q-uploader
                accept=".jpg, .png"
                @added="uploadFile"
                auto-upload
                max-files="1"
                label="Subir foto"
                flat
                max-file-size="5000000"
                @rejected="onRejected"
                bordered
              />
            </div>
            <div class="col-12 q-pt-md">
              <q-btn :loading="loading" class="full-width" type="submit" color="primary" no-caps icon="add_circle_outline" label="Guardar" />
            </div>
          </div>
        </q-form>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script>
import {useCounterStore} from "stores/example-store";
export default {
  name: `Datos`,
  data () {
    return {
      store:useCounterStore(),
      foto:'',
      loading: false,
    }
  },
  methods: {
    uploadFile (file) {
      this.loading=true
      let dialog = this.$q.dialog({
        message: 'Subiendo... 0%',
      })
      let percentage = 0
      const fd = new FormData()
      fd.append('file', file[0])
      return new Promise((resolve, reject) => {
        this.$api.post('upload',
          fd,
          {
            headers: { 'Content-Type': 'multipart/form-data' },
            onUploadProgress: (progressEvent) => {
              percentage = Math.round((progressEvent.loaded / progressEvent.total) * 100)
              dialog.update({
                message: `Subiendo... ${percentage}%`
              })
              if (percentage>=100){
                dialog.hide()
              }
            }
          })
          .then(res => {
            this.foto=res.data
            this.loading=false
            resolve(file)
          })
          .catch(err => reject(err))
      })
    },
    onRejected (rejectedEntries) {
      this.$q.notify({
        type: 'negative',
        message: `${rejectedEntries.length} el archivo paso las restricciones de validación`
      })
    },
    userSave(){
      if (this.foto==''){
        this.$q.notify({
          type: 'negative',
          message: `Debe subir una foto`,
          position: 'top'
        })
        return false
      }
      this.store.user.foto=this.foto
      this.$api.put('user/'+this.store.user.id,this.store.user)
        .then(res=>{
          console.log(res.data)
          // return false
          this.$q.notify({
            type: 'positive',
            message: 'Usuario guardado',
            position: 'top'
          })
        })
        .catch(err=>{
          this.$q.notify({
            type: 'negative',
            message: 'Error al guardar usuario',
            position: 'top'
          })
        })
    }
  }
}
</script>

<style scoped>
</style>
