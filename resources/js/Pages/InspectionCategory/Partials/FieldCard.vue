<template>
    <v-card class="ma-4 border" rounded="lg" variant="flat">
      <v-card-item>
        <v-card-title class="text-body-2 d-flex align-center">
          <v-btn class="text-none text-subtitle-1 me-1" size="small" variant="tonal">
            Editar
          </v-btn>
          <v-btn class="text-red text-subtitle-1 me-1" size="small" variant="tonal">
            Eliminar
          </v-btn>
        </v-card-title>
  
        <div class="py-2">
          <div class="text-h6">{{ field.ct_inspection_form }}</div>
          <div class="font-weight-light text-medium-emphasis">
            {{ field.required == 1 ? 'Requerido' : 'Opcional' }}
          </div>
        </div>
      </v-card-item>
    </v-card>
  </template>
  
  <script>
  export default {
    name: 'FieldCard',
    props: {
      field: {
        type: Object,
        required: true
      }
    }
  }
  </script>
  