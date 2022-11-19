<template>
<q-page>
  <div class="row">
    <div class="col-6 col-sm-3 text-center">
      <q-btn type="a" outline icon="add_to_drive" :loading="loading" color="primary" label="Ir a mi Drive" href="https://drive.google.com/drive/u/0/my-drive" target="_blank"  />
    </div>
    <div class="col-6 col-sm-3 text-center">
      <q-btn @click="materiaCreate" :loading="loading" icon="o_menu_book" color="primary" label="Crear materia" />
    </div>
    <div class="col-6 col-sm-3 text-center">
      <q-btn outline @click="materiaGet" :loading="loading" icon="refresh" color="primary" label="Actualizar" />
    </div>
    <div class="col-12 q-pa-xs">
      <q-tree
        :nodes="materias"
        node-key="nombre"
        default-expand-all
      >
        <template v-slot:default-header="prop">
          <div class="row items-center">
            <q-icon :name="prop.node.icon || 'share'" color="primary" size="28px" class="q-mr-sm" />
            <div v-if="prop.node.url">
              <a  :href="prop.node.url" @click="openPage(prop.node.url)" target="_blank">{{ prop.node.label }}</a>
              <q-btn flat dense @click="registroEdit(prop.node)" icon="edit" color="primary" >
                <q-tooltip>Crear</q-tooltip>
              </q-btn>
              <q-btn flat dense @click="materiaDelete(prop.node)" icon="delete" color="primary" >
                <q-tooltip>Eliminar</q-tooltip>
              </q-btn>
            </div>
            <div v-else class="text-weight-bold text-primary">
              {{ prop.node.label }}
              <q-btn flat dense @click="materiaEdit(prop.node)" icon="edit" color="primary" >
                <q-tooltip>Modificar</q-tooltip>
              </q-btn>
              <q-btn flat dense @click="materiaDelete(prop.node)" icon="delete" color="primary" >
                <q-tooltip>Eliminar</q-tooltip>
              </q-btn>
              <q-btn v-if="prop.node.type=='materia'" flat dense @click="semestreCreate(prop.node)" icon="add_circle_outline" color="primary" >
                <q-tooltip>Crear</q-tooltip>
              </q-btn>
              <!--          <q-btn v-if="prop.node.type=='materia'" flat dense @click="semestreCreate(prop.node)" icon="o_send" color="primary" >-->
              <!--            <q-tooltip>Compartir</q-tooltip>-->
              <!--          </q-btn>-->
              <q-btn v-if="prop.node.type=='semestre'" flat dense @click="documentoCreate(prop.node)" icon="add_circle_outline" color="primary" >
                <q-tooltip>Crear</q-tooltip>
              </q-btn>
              <q-btn v-if="prop.node.type=='documento'" flat dense @click="registroCreate(prop.node)" icon="add_circle_outline" color="primary" >
                <q-tooltip>Crear</q-tooltip>
              </q-btn>
            </div>
          </div>
        </template>
      </q-tree>
    </div>
  </div>

  <q-dialog v-model="registroDialog">
    <q-card style="width: 700px;max-width: 80vh" >
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6">Registro</div>
      </q-card-section>
      <q-card-section class="q-pt-none">
        <q-form @submit="registroSave" @reset="registroDialog = false" class="q-gutter-md">
          <q-input outlined v-model="registro.nombre" label="Nombre" />
          <q-input outlined v-model="registro.url" label="Url" />
          <q-btn type="submit" color="primary" label="Guardar" />
          <q-btn type="reset" color="primary" flat label="Cancelar" />
        </q-form>
      </q-card-section>
    </q-card>
  </q-dialog>
<!--  <pre>{{materias}}</pre>-->
</q-page>
</template>

<script>
import {useCounterStore} from "stores/example-store";

export default {
  name: `Portafolio`,
  data () {
    return {
      registro:{},
      loading: false,
      expanded: true,
      materias:[],
      store:useCounterStore(),
      registroDialog: false,
      registroInsert: true,
    }
  },
  created() {
    this.materiaGet()
  },
  methods: {
    registroSave(){
      if(this.registroInsert){
        this.$api.post('registro',this.registro).then((response)=>{
          this.registroDialog = false
          this.materiaGet()
        })
      }else{
        this.$api.put('registro/'+this.registro.id,this.registro).then((response)=>{
          this.registroDialog = false
          this.materiaGet()
        })
      }

    },
    registroCreate(node){
      node.nombre = ''
      node.documento_id=node.id
      this.registroInsert = true
      this.registro = node
      this.registroDialog = true
    },
    registroEdit(node){
      this.registro = node
      this.registroInsert = false
      this.registroDialog = true
    },
    documentoCreate(semestre){
      console.log(semestre)
      this.$q.dialog({
        title: 'Crear documento',
        prompt: {
          model: '',
          type: 'text',
          label: 'Nombre del documento',
          hint: 'Ejemplo: Tarea 1'
        },
        cancel: true,
        persistent: true
      }).onOk( data => {
        this.$api.post('/documento', {
          nombre: data,
          semestre_id: semestre.id
        }).then(response => {
          console.log(response.data)
          this.$q.notify({
            message: 'Documento creado',
            color: 'positive',
            icon: 'check_circle'
          })
          this.materiaGet()
        }).catch(error => {
          this.$q.notify({
            message: 'Error al crear documento',
            color: 'negative',
            icon: 'error'
          })
        })
      }).onCancel(() => {
        console.log('Cancel')
      }).onDismiss(() => {
        console.log('Dismissed')
      })
    },
    semestreCreate(node){
      this.$q.dialog({
        title: 'Crear semetre',
        message: 'Ingrese el nombre del semestre',
        prompt: {
          model: '',
          type: 'text'
        },
        cancel: true,
        persistent: true
      }).onOk(data => {
        this.$api.post('semestre', {nombre: data, materia_id: node.id}).then((response) => {
          this.materiaGet()
        })
      })
    },
    materiaDelete(materia){
      this.$q.dialog({
        title: 'Eliminar',
        message: '¿Está seguro de eliminar?',
        ok: 'Si',
        cancel: 'No'
      }).onOk(() => {
        this.loading = true
        this.$api.delete(`${materia.type}/${materia.id}`)
          .then(response => {
            this.loading = false
            this.$q.notify({
              message: 'Eliminado',
              color: 'positive',
              position: 'top',
              icon: 'check_circle'
            })
            this.materiaGet()
          })
          .catch(error => {
            this.loading = false
            this.$q.notify({
              message: error.response.data.message,
              color: 'negative',
              position: 'top',
              icon: 'error'
            })
          })
      })
    },
    materiaEdit(materia){
      this.$q.dialog({
        title: 'Editar ',
        prompt: {
          model: '',
          type: 'text'
        },
        cancel: true,
        persistent: true
      }).onOk(data => {
        this.$api.put(materia.type+'/'+materia.id, {nombre:data}).then(response => {
          this.materiaGet()
        })
      }).onCancel(() => {
        console.log('Cancel')
      }).onDismiss(() => {
        console.log('Dismiss')
      })
    },
    materiaCreate() {
      this.$q.dialog({
        title: 'Crear materia',
        message: 'Ingrese el nombre de la materia',
        prompt: {
          model: '',
          type: 'text'
        },
        cancel: true,
        persistent: true
      }).onOk(data => {
        this.loading = true
        this.$api.post('materia', {
          nombre: data,
          user_id: this.store.user.id
        }).then(response => {
          this.loading = false
          this.$q.notify({
            message: 'Materia creada',
            color: 'positive',
            icon: 'check_circle',
            position: 'top'
          })
          this.materiaGet()
        }).catch(error => {
          this.loading = false
          this.$q.notify({
            message: 'Error al crear materia',
            color: 'negative',
            icon: 'error',
            position: 'top'
          })
        })
      })
    },
    openPage(url) {
      window.open(url, '_blank')
    },
    materiaGet(){
      this.loading = true
      this.$api.get('materia').then((response) => {
        this.loading = false
        this.materias = []
        response.data.forEach((materia) => {
          materia.label = materia.nombre
          materia.icon = 'o_menu_book'
          materia.type = 'materia'
          if (materia.semestres!=undefined) {
            materia.semestres.forEach((semestre) => {
              semestre.label = semestre.nombre
              semestre.icon = 'o_local_library'
              semestre.type = 'semestre'
              if (semestre.documentos!=undefined) {
                semestre.documentos.forEach((documento) => {
                  documento.label = documento.nombre
                  documento.icon = 'o_school'
                  documento.type = 'documento'
                  if (documento.registros!=undefined) {
                    documento.registros.forEach((registro) => {
                      registro.label = registro.nombre
                      registro.icon = 'o_book'
                      registro.type = 'registro'
                      registro.url = registro.url
                    })
                    documento.children = documento.registros
                  }
                })
                semestre.children = semestre.documentos
              }
            })
            materia.children = materia.semestres
          }

          this.materias.push(materia)
        })
      })
    }
  }
}
</script>

<style scoped>

</style>
