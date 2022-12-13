<template>
<q-page>
  <div class="row">
    <div class="col-12">
      <div class="bg-primary text-h5 text-bold text-white text-uppercase text-center">Horario Docente</div>
    </div>
  </div>
  <q-markup-table :separator="'cell'" flat bordered>
    <thead>
    <tr>
      <th class="text-bold text-subtitle2 bg-primary text-white q-pa-none q-ma-none" style="width: 5%">Horarios</th>
      <th class="text-bold text-subtitle2 bg-primary text-white q-pa-none q-ma-none">Lunes</th>
      <th class="text-bold text-subtitle2 bg-primary text-white q-pa-none q-ma-none">Martes</th>
      <th class="text-bold text-subtitle2 bg-primary text-white q-pa-none q-ma-none">Miercoles</th>
      <th class="text-bold text-subtitle2 bg-primary text-white q-pa-none q-ma-none">Jueves</th>
      <th class="text-bold text-subtitle2 bg-primary text-white q-pa-none q-ma-none">Viernes</th>
      <th class="text-bold text-subtitle2 bg-primary text-white q-pa-none q-ma-none">Sabado</th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="(s,i) in schedules" :key="i">
      <th class="text-bold text-subtitle2 bg-primary text-white">{{s}}</th>
      <td class="text-center text-bold" @click="scheduleClick(s,'LUNES')">{{horario(s,'LUNES')}}</td>
      <td class="text-center text-bold" @click="scheduleClick(s,'MARTES')">{{horario(s,'MARTES')}}</td>
      <td class="text-center text-bold" @click="scheduleClick(s,'MIERCOLES')">{{horario(s,'MIERCOLES')}}</td>
      <td class="text-center text-bold" @click="scheduleClick(s,'JUEVES')">{{horario(s,'JUEVES')}}</td>
      <td class="text-center text-bold" @click="scheduleClick(s,'VIERNES')">{{horario(s,'VIERNES')}}</td>
      <td class="text-center text-bold" @click="scheduleClick(s,'SABADO')">{{horario(s,'SABADO')}}</td>
    </tr>
    </tbody>
  </q-markup-table>
  <pre>{{scheduleData}}</pre>
</q-page>
</template>
<script>
import {useCounterStore} from "stores/example-store";

export default {
  name: `Schedule`,
  data () {
    return {
      schedules:['6:00-7:00 AM','7:00-8:00 AM','8:00-9:00 AM','9:00-10:00 AM','10:00-11:00 AM','11:00-12:00 PM','12:00-1:00 PM','1:00-2:00 PM','2:00-3:00 PM','3:00-4:00 PM','4:00-5:00 PM','5:00-6:00 PM','6:00-7:00 PM','7:00-8:00 PM','8:00-9:00 PM','9:00-10:00 PM','10:00-11:00 PM','11:00-12:00 AM'],
      scheduleShow:false,
      scheduleData:[],
      store: useCounterStore()
    }
  },
  created() {
    this.getSchedule()
  },
  methods: {
    getSchedule(){
      this.$api.get('schedule').then(res=>{
        this.scheduleData = res.data
      })
    },
    scheduleClick(hora,dia){
      this.$q.dialog({
        title: 'Horario',
        message: `Hora: ${hora} Dia: ${dia}`,
        ok: 'Aceptar',
        cancel: 'Cancelar',
        prompt: {
          model: this.horario(hora,dia),
          hint: 'Ingrese el nombre de la materia',
        }
      }).onOk(data => {
        this.$api.post('schedule',{
          hora,
          dia,
          materia:data,
          user_id: this.store.user.id
        }).then(res => {
          this.getSchedule()
        })
      })
    },
    horario(hora,dia){
      let data = this.scheduleData.filter(s => s.hora === hora && s.dia === dia)
      if(data.length > 0){
        return data[0].materia
      }
      return ''
    }
  }
}
</script>

<style scoped>

</style>
