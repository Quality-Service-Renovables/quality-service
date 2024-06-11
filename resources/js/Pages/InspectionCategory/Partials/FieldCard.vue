<template>
  <div class="d-flex">
    <v-icon class="mdi mdi-subdirectory-arrow-right mt-4"></v-icon>
    <v-card class="mb-5 ml-2 mr-2 mt-2 border w-100" rounded="lg" variant="flat" border="dashed thin info md">
      <v-card-text class="pb-0">{{ field.ct_inspection_form }}
        <v-chip size="x-small" variant="outlined" class="ml-2 text-red" v-if="field.required == 1">
          * Requerido
        </v-chip>
        <v-chip size="x-small" variant="outlined" class="ml-2 text-success" v-else>
          * Opcional
        </v-chip>
      </v-card-text>
      <v-card-actions class="p-0 m-0">
        <div class="border rounded-xl px-2">
          <v-btn density="compact" icon="mdi-pencil" variant="plain" class="me-1" @click="editField"></v-btn>
          <v-btn density="compact" icon="mdi-trash-can" variant="plain" class="me-1" color="red"
            @click="deleteField"></v-btn>
        </div>
      </v-card-actions>
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
  },
  methods: {
    deleteField() {
      this.$emit('delete-field', this.field.ct_inspection_form_uuid);
    },
    editField() {
      this.$emit('edit-field', this.field);
    }
  }
}
</script>