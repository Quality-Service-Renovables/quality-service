<template>
    <v-card class="mx-auto mb-2 border" variant="flat" v-for="(section, index) in template.sections" :key="section">
        <v-sheet class="border">
            <v-card-item>
                <template v-slot:prepend>
                    <v-card-title>
                        {{ index.replaceAll('_', ' ').toUpperCase() }}
                    </v-card-title>
                </template>

                <v-divider class="mx-2" vertical></v-divider>

                <v-btn class="text-none text-subtitle-1 me-1" color="primary" size="small">
                    Agregar
                </v-btn>
                <v-btn class="text-none text-subtitle-1 me-1" size="small" variant="tonal">
                    Editar
                </v-btn>
                <v-btn class="text-red text-subtitle-1 me-1" size="small" variant="tonal">
                    Eliminar
                </v-btn>
            </v-card-item>
        </v-sheet>

        <p class="text-h5 font-weight-black m-4" v-if="section.fields != ''">Campos ({{ section.fields.length ?
        section.fields.length : 1 }})</p>

        <v-card class="ma-4 border" rounded="lg" variant="flat" v-for="field in section.fields" :key="field">
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

        <p class="text-h5 font-weight-black m-4" v-if="section.sub_sections">Sub-secciones ({{
        section.sub_sections.length }})
        </p>
        <v-card class="ma-4 border" variant="flat" v-for="sub_section in section.sub_sections" :key="sub_section">
            <v-sheet class="border">
                <div class="d-flex align-center">
                    <v-card-title>
                        {{ sub_section.ct_inspection_section }}
                    </v-card-title>
                    <div>
                        <v-btn class="text-none text-subtitle-1 me-1" color="primary" size="small">
                            Agregar
                        </v-btn>
                        <v-btn class="text-none text-subtitle-1 me-1" size="small" variant="tonal">
                            Editar
                        </v-btn>
                        <v-btn class="text-red text-subtitle-1 me-1" size="small" variant="tonal">
                            Eliminar
                        </v-btn>
                    </div>
                </div>
            </v-sheet>

            <p class="text-h5 font-weight-black m-4" v-if="sub_section.fields">Campos</p>

            <v-card class="ma-4 border" rounded="lg" variant="flat" v-for="f in sub_section.fields" :key="field">
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
                        <div class="text-h6">{{ f.ct_inspection_form }}</div>
                        <div class="font-weight-light text-medium-emphasis">
                            {{ f.required == 1 ? 'Requerido' : 'Opcional' }}
                        </div>
                    </div>
                </v-card-item>
            </v-card>
        </v-card>
    </v-card>
</template>

<script>
export default {
    props: {
        template: {
            type: Array,
            required: true
        }
    },
    setup() {
        return {
            //
        }
    },
}
</script>