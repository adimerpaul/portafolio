<template>
  <q-page>
    <q-table :rows="records" :columns="studentColums" :filter="search">
      <template v-slot:top-left>
        <q-toolbar>
          <q-select dense @update:model-value="recordGet" outlined :options="materias" v-model="materia"  :loading="loading" label="Materia" />
<!--          <q-btn icon="search" color="primary" label="Consultar" no-caps @click="recordGet" :loading="loading" />-->
        </q-toolbar>
      </template>
      <template v-slot:top-right>
        <q-toolbar>
          <q-btn icon="add_circle_outline" color="primary" label="Registrar Notas" :loading="loading" no-caps @click="noteClickCreate" />
          <q-btn icon="add_circle_outline" color="primary" label="Registrar Estudiante" :loading="loading" no-caps @click="studentClickCreate" />
          <q-input v-model="search"  outlined  dense placeholder="Buscar..." />
        </q-toolbar>
      </template>
      <template v-slot:body-cell-option="props">
        <q-td :props="props" auto-width >
<!--          <q-btn flat dense icon="o_edit" @click="studentEdit(props.row)" />-->
          <q-btn flat dense icon="o_delete" @click="studentDelete(props.row)" /> <span class="text-bold">{{props.pageIndex+1}}</span>
        </q-td>
      </template>
    </q-table>
<!--    <pre>{{records}}</pre>-->
    <q-dialog v-model="showAddUserDialog" >
      <q-card style="width: 700px;max-width: 85vw">
        <q-card-section class="row items-center q-pb-none">
          <div class="text-h6">Registrar Estudiante</div>
        </q-card-section>
        <q-card-section class="q-pt-none">
          <q-form @submit.prevent="studentCreate">
            <q-select dense outlined :options="students" v-model="student"  label="Estudiante" />
            <q-btn :loading="loading" type="submit" color="primary" icon="add_circle_outline" label="Agregar estudiante" class="full-width" />
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>
    <q-dialog v-model="noteDialogShow" >
      <q-card style="width: 700px;max-width: 85vw">
        <q-card-section class="row items-center q-pb-none">
          <div class="text-h6">Nota Estudiante</div>
        </q-card-section>
        <q-card-section class="q-pt-none">
          <q-form @submit.prevent="noteCreate">
            <q-input dense outlined v-model="descripcion" label="Descripción" required />
            <q-markup-table dense>
              <thead>
              <tr>
                <th class="text-left">N</th>
                <th class="text-left">Nombre</th>
                <th class="text-right">Nota</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="(r, index) in records" :key="index">
                <td class="text-left">{{index+1}}</td>
                <td class="text-left">{{r.student.name}} {{r.student.last}}</td>
                <td class="text-right">
                  <q-input dense outlined v-model="r.note" type="number" min="0" max="20" required />
                </td>
              </tr>
              </tbody>
            </q-markup-table>
            <q-btn :loading="loading" type="submit" color="primary" icon="add_circle_outline" label="Crear notas" class="full-width" />
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
  name: `Note`,
  data () {
    return {
      store:useCounterStore(),
      materias:[],
      descripcion:'',
      materia:{},
      noteDialogShow:false,
      showAddUserDialog: false,
      showUpdateUserDialog: false,
      search: '',
      students: [],
      student:{},
      records: [],
      record:{},
      loading: false,
      studentCrear: true,
      studentColums:[
        // {name: 'email', label: 'Email', field: 'email', align: 'left', sortable: true},
        // {name: 'code', label: 'Código', field: 'code', align: 'left', sortable: true},
        // {name: 'phone', label: 'Teléfono', field: 'phone', align: 'left', sortable: true},
        // {name: 'id', label: 'ID', field: 'id', align: 'left', sortable: true},
      ]
    }
  },
  methods:{
    noteCreate(){
      this.loading = true
      this.records.forEach(r=>{
        r.record_id=r.id
        r.students_id=r.student.id
        r.materia_id=this.materia.id
      })
      this.$api.post('note', {
        description: this.descripcion,
        records: this.records
      }).then(response => {
        this.recordGet(this.materia)
        this.loading = false
        this.$q.notify({
          color: 'positive',
          message: 'Notas registradas',
          icon: 'check_circle',
          position: 'top'
        })
        this.noteDialogShow = false
      }).catch(error => {
        this.loading = false
        this.$q.notify({
          color: 'negative',
          message: 'Error al registrar notas',
          icon: 'warning',
          position: 'top'
        })
      })
    },
    recordGet(materia){
      this.loading = true
      this.$api.get(`record/${materia.id}`).then(res=>{
        this.records = res.data
        this.loading = false
        this.studentColums=[
          {name: 'option', field: 'option', label: 'Opciones', align: 'left'},
          {name: 'name', label: 'Nombre', field: row=>row.student.name+' '+ row.student.last, align: 'left', sortable: true},
        ]
        if (this.records.length > 0){
          this.records[0].notes.forEach(n=>{
            this.studentColums.push({name: n.description, label: n.description, field: row=>row.notes.find(r=>r.description===n.description).note, align: 'left', sortable: true})
          })
        }
        this.showUpdateUserDialog = false
        this.$q.notify({
          color: 'green-4',
          textColor: 'white',
          icon: 'check_circle',
          message: 'Estudiantes actualizado'
        })
        })
        .catch(err=>{
          this.loading = false
          this.$q.notify({
            color: 'red-4',
            textColor: 'white',
            icon: 'error',
            message: 'Error al actualizar estudiantes'
          })
        })
    },
    studentCreate(){
      let student = this.records.find(item=>item.student.id === this.student.id)
      if(student){
        this.$q.notify({
          color: 'red-4',
          textColor: 'white',
          icon: 'error',
          message: 'El estudiante ya se encuentra registrado'
        })
        return
      }
        this.loading = true
        this.$api.post('record', {
          student_id: this.student.id,
          materia_id: this.materia.id
        }).then(response => {
          this.recordGet(this.materia)
          this.showAddUserDialog = false
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

    },
    noteClickCreate(){
      this.records.forEach(item=>{
        item.note = 0
      })
      this.noteDialogShow = true
    },
    studentClickCreate(){
      this.studentCrear = true
      this.showAddUserDialog = true
    },
    studentEdit(student){
      this.student = student
      this.studentCrear = false
      this.showAddUserDialog = true
    },
    studentDelete(student){
      this.$q.dialog({
        title: 'Eliminar',
        message: '¿Está seguro de eliminar el estudiante?',
        ok: 'Si',
        cancel: 'No'
      }).onOk(() => {
        // this.$q.loading.show()
        this.$api.delete('record/'+student.id).then(response => {
          this.recordGet(this.materia)
        })
      })
    }
  },
  created() {
    this.$api.get('materia').then(response => {
      response.data.forEach(materia => {
        materia.label = materia.nombre
        this.materias.push(materia)
      })
      this.materia = this.materias[0]
    })
    this.$api.get('student').then(response => {
      response.data.forEach(student => {
        student.label = student.name+' '+student.last
        this.students.push(student)
      })
      this.student = this.students[0]
      this.recordGet(this.materia)
    })
    // this.recordGet()
  }
}
</script>

<style scoped>
</style>
