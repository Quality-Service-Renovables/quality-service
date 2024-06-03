<template>
  <div class="d-flex">
    <v-icon class="mdi mdi-subdirectory-arrow-right mt-4"></v-icon>
    <v-card class="mb-5 ml-2 mr-2 mt-2 border w-100" rounded="lg" variant="flat">
      <v-card-item>
        <v-card-title class="text-body-2 d-flex align-center">
          <v-btn density="compact" icon="mdi-pencil" variant="tonal" class="text-subtitle-1 me-1"></v-btn>
          <v-btn density="compact" icon="mdi-trash-can" variant="tonal" class="text-subtitle-1 me-1" color="red"></v-btn>
        </v-card-title>

        <div class="py-2">
          <v-text-field :label="field.ct_inspection_form" variant="outlined" readonly hide-details></v-text-field>
          <div class="font-weight-light text-medium-emphasis">
            {{ field.required == 1 ? '* Campo requerido' : 'Campo opcional' }}
          </div>
        </div>
      </v-card-item>
    </v-card>
  </div>
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