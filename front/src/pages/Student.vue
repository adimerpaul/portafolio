<template>
  <q-page>
    <q-table :rows="students" :columns="studentColums" :filter="search">
      <template v-slot:top-right>
        <q-toolbar>
          <q-btn icon="add_circle_outline" color="primary" label="Crear Esudiante" no-caps @click="studentClickCreate" />
          <q-input v-model="search"  outlined  dense placeholder="Buscar..." />
        </q-toolbar>
      </template>
      <template v-slot:body-cell-option="props">
        <q-td :props="props" auto-width >
          <q-btn flat dense icon="o_edit" @click="studentEdit(props.row)" />
          <q-btn flat dense icon="o_delete" @click="studentDelete(props.row)" />
        </q-td>
      </template>
    </q-table>
    <q-dialog v-model="showAddUserDialog" >
      <q-card style="width: 700px;max-width: 85vw">
        <q-card-section class="row items-center">
          <div class="text-h6">{{studentCrear?'Crear':'Actualizar'}} Estudiante</div>
        </q-card-section>
        <q-card-section>
          <q-form @submit.prevent="studentCreate">
            <q-input v-model="student.name" hint="" dense required outlined label="Nombre" />
            <q-input v-model="student.last" hint="" dense required outlined label="Apellido" />
            <q-input v-model="student.code" hint="" dense required outlined label="Código" />
            <q-input v-model="student.phone" hint="" dense required outlined label="Teléfono" type="number" />
            <q-input v-model="student.birthday" hint="" dense required outlined label="Fecha de Nacimiento" type="date" />
            <q-input v-model="student.email" hint="" dense required outlined label="Correo" type="email" />
            <q-select v-if="studentCrear" v-model="student.materias" hint="" dense required outlined label="Materias" :options="materias" />
            <q-btn :loading="loading" type="submit" color="primary" icon="add_circle_outline" :label="studentCrear?'Crear':'Actualizar'" class="full-width" />
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>
    <q-dialog v-model="showUpdateUserDialog" >
      <q-card style="width: 700px;max-width: 85vw">
        <q-card-section class="row items-center">
          <div class="text-h6">Agregar Estudiante</div>
        </q-card-section>
        <q-card-section>
          <q-form @submit.prevent="studentUpdate">
            <q-input v-model="student.name" hint="" required outlined label="Nombre" />
            <q-input v-model="student.email" hint="" required outlined label="Email" />
            <q-select v-model="student.role" hint="" required outlined label="Rol" :options="roles" />
            <q-btn :loading="loading" type="submit" color="primary" icon="add_circle_outline" label="Guardar" class="full-width" />
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>
  </q-page>
</template>

<script>
import {date} from "quasar";
import {useCounterStore} from "stores/example-store";

export default {
  name: `User`,
  data () {
    return {
      store:useCounterStore(),
      roles: [
        'INSCRIPCION',
        'ACREDITACION',
        'REFRIGERIO',
        'ADMINISTRADOR',
      ],
      materias:[],
      materia:{},
      showAddUserDialog: false,
      showUpdateUserDialog: false,
      search: '',
      students: [],
      student:{},
      loading: false,
      studentCrear: true,
      studentColums:[
        {name: 'option', field: 'option', label: 'Opciones', align: 'left', sortable: true},
        {name: 'name', label: 'Nombre', field: row=>row.name+' '+ row.last, align: 'left', sortable: true},
        {name: 'email', label: 'Email', field: 'email', align: 'left', sortable: true},
        {name: 'code', label: 'Código', field: 'code', align: 'left', sortable: true},
        {name: 'phone', label: 'Teléfono', field: 'phone', align: 'left', sortable: true},
        {name: 'id', label: 'ID', field: 'id', align: 'left', sortable: true},
      ]
    }
  },
  methods:{
    studentUpdate(){
      this.loading = true
      this.$api.put(`student/${this.student.id}`,this.student)
        .then(res=>{
          this.loading = false
          this.showUpdateUserDialog = false
          this.$q.notify({
            color: 'green-4',
            textColor: 'white',
            icon: 'check_circle',
            message: 'Estudiante actualizado'
          })
          this.student = {}
          this.studentsGet()
        })
        .catch(err=>{
          this.loading = false
          this.$q.notify({
            color: 'red-4',
            textColor: 'white',
            icon: 'error',
            message: 'Error al actualizar usuario'
          })
        })
    },
    studentsGet(){
      this.$q.loading.show()
      this.$api.get('student').then(response => {
        this.students = response.data
        this.$q.loading.hide()
      })
    },
    studentCreate(){
      if (this.studentCrear){
        this.loading = true
        this.student.user_id = this.store.user.id
        this.student.materia_id = this.student.materias.value
        this.$api.post('student', this.student).then(response => {
          // this.studentsGet()
          // this.showAddUserDialog = false
          // this.student = {}
          // this.loading = false
          this.$api.post('record', {
            student_id: response.data.id,
            materia_id: this.student.materias.value,
          }).then(response => {
            this.studentsGet()
            this.showAddUserDialog = false
            this.student = {}
            this.loading = false
            this.$q.notify({
              color: 'green-4',
              textColor: 'white',
              icon: 'check_circle',
              message: 'Estudiante creado'
            })
          })
        }).catch(error => {
          this.loading = false
          this.$q.notify({
            color: 'negative',
            message: error.response.data.message,
            icon: 'report_problem',
            position: 'top'
          })
        })
      }else{
        this.loading = true
        this.$api.put('student/'+this.student.id, this.student).then(response => {
          this.studentsGet()
          this.showAddUserDialog = false
          this.student = {}
          this.loading = false
        }).catch(error => {
          this.loading = false
          this.$q.notify({
            color: 'negative',
            message: error.response.data.message,
            icon: 'report_problem',
            position: 'top'
          })
        })
      }
    },
    studentClickCreate(){
      this.studentCrear = true
      this.showAddUserDialog = true
      this.student = {
        name: '',
        last: '',
        code: '',
        birthday: date.formatDate(new Date(), 'YYYY-MM-DD'),
        email: '',
      }
    },
    studentEdit(student){
      this.student = student
      this.studentCrear = false
      this.showAddUserDialog = true
    },
    studentDelete(student){
      this.$q.dialog({
        title: 'Eliminar',
        message: '¿Está seguro de eliminar el usuario?',
        ok: 'Si',
        cancel: 'No'
      }).onOk(() => {
        this.$q.loading.show()
        this.$api.delete('student/'+student.id).then(response => {
          this.studentsGet()
        })
      })
    }
  },
  created() {
    this.$api.get('materia').then(res => {
      res.data.forEach(materia => {
        this.materias.push({
          label: materia.nombre,
          value: materia.id
        })
      })
      this.materia = this.materias[0]
    })
    this.studentsGet()
  }
}
</script>

<style scoped>
</style>
