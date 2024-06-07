<template>
  <div class="d-flex">
    <v-icon class="mdi mdi-subdirectory-arrow-right mt-4"></v-icon>
    <v-card class="mb-5 ml-2 mr-2 mt-2 border w-100" rounded="lg" variant="flat" border="dashed thin info md">
      <v-card-item>
        <div class="py-2">
          <v-card rounded="lg" class="border">
            <v-card-text class="pb-0">{{ field.ct_inspection_form }}<v-chip size="x-small" variant="outlined" class="ml-2">
                {{ field.required == 1 ? '* Campo requerido' : 'Campo opcional' }}
              </v-chip></v-card-text>
            <v-card-actions class="py-0">
              <v-btn density="compact" icon="mdi-pencil" variant="tonal" class="text-subtitle-1 me-1"></v-btn>
              <v-btn density="compact" icon="mdi-trash-can" variant="tonal" class="text-subtitle-1 me-1"
                color="red"></v-btn>
            </v-card-actions>
          </v-card>
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