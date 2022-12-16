<template>
  <q-page class="">
    <div class="row">
      <div class="col-12 col-sm-3 q-pa-md">
        <q-item to="/portafolio">
        <q-card class="bg-green full-width">
          <q-card-section>
            <div class="text-h6 text-white">Usuarios <q-btn flat dense @click="actualizar" icon="refresh" /> </div>
          </q-card-section>
          <q-card-section>
            <div class="text-h2 text-white">{{datos.users}}</div>
          </q-card-section>
        </q-card>
          </q-item>
      </div>
      <div class="col-12 col-sm-3 q-pa-md" >
        <q-item to="/portafolio">
          <q-card class="bg-red full-width" >
            <q-card-section >
              <div class="text-h6 text-white">Materias <q-btn flat dense @click="actualizar" icon="refresh" /> </div>
            </q-card-section>
            <q-card-section>
              <div class="text-h2 text-white">{{datos.materias}}</div>
            </q-card-section>
          </q-card>
        </q-item>

      </div>
      <div class="col-12 col-sm-3 q-pa-md">
        <q-item to="/portafolio">
        <q-card class="bg-blue full-width">
          <q-card-section>
            <div class="text-h6 text-white">Semestres <q-btn flat dense @click="actualizar" icon="refresh" /> </div>
          </q-card-section>
          <q-card-section>
            <div class="text-h2 text-white">{{datos.semestres}}</div>
          </q-card-section>
        </q-card>
        </q-item>
      </div>
      <div class="col-12 col-sm-3 q-pa-md">
        <q-item to="/portafolio">
        <q-card class="bg-info full-width">
          <q-card-section>
            <div class="text-h6 text-white">Documentos <q-btn flat dense @click="actualizar" icon="refresh" /> </div>
          </q-card-section>
          <q-card-section>
            <div class="text-h2 text-white">{{datos.documentos}}</div>
          </q-card-section>
        </q-card>
        </q-item>
      </div>
      <div class="col-12 col-sm-3 q-pa-md">
        <q-item to="/portafolio">
        <q-card class="bg-secondary full-width">
          <q-card-section>
            <div class="text-h6 text-white">Registros <q-btn flat dense @click="actualizar" icon="refresh" /> </div>
          </q-card-section>
          <q-card-section>
            <div class="text-h2 text-white">{{datos.registros}}</div>
          </q-card-section>
        </q-card>
        </q-item>
      </div>
    </div>
  </q-page>
</template>

<script>
export default {
  data () {
    return {
      datos: [],
    }
  },
  created() {
    this.actualizar();
  },
  methods: {
    actualizar() {
      this.$q.loading.show()
      this.$api.get('totales').then((response) => {
        this.datos = response.data
        this.$q.loading.hide()
      })
    }
  }
}
</script>
