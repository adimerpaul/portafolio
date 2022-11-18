<template>
<q-page>
  <q-tree
    :nodes="simple"
    node-key="label"
  />
</q-page>
</template>

<script>
export default {
  name: `Portafolio`,
  data () {
    return {
      simple: [
        {
          label: 'Satisfied customers (with avatar)',
          img: 'https://cdn.quasar.dev/img/logo_calendar_128px.png',
          children: [
            {
              label: 'Good food (with icon)',
              icon: 'restaurant_menu',
              children: [
                { label: 'Quality ingredients' },
                { label: 'Good recipe' }
              ]
            },
            {
              label: 'Good service (disabled node with icon)',
              icon: 'room_service',
              disabled: true,
              children: [
                { label: 'Prompt attention' },
                { label: 'Professional waiter' }
              ]
            },
            {
              label: 'Pleasant surroundings (with icon)',
              icon: 'photo',
              children: [
                {
                  label: 'Happy atmosphere (with image)',
                  img: 'https://cdn.quasar.dev/img/logo_calendar_128px.png'
                },
                { label: 'Good table presentation' },
                { label: 'Pleasing decor' }
              ]
            }
          ]
        }
      ]
    }
  },
  created() {
    // this.$api.get('materia').then((response) => {
    //   this.simple = response.data
    // })
  }
}
</script>

<style scoped>

</style>
