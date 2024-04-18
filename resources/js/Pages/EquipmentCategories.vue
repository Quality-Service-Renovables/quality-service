<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, reactive, defineProps } from 'vue';
import { router } from '@inertiajs/vue3'

defineProps({
    equipment_categories: Object,
});

let search = ref('');
let dialog = ref(false);
let form = reactive({
    equipment_category_uuid: '',
    equipment_category: '',
    description: '',
    active: true
});

let headers = [
    { title: 'Categoria', key: 'equipment_category', value: 'equipment_category' },
    { title: 'Descripción', key: 'description' },
    { title: 'Estado', key: 'active' },
    { title: 'Actions', key: 'actions', sortable: false }
];

let editItem = (item) => {
    dialog.value = true;
    form.equipment_category_uuid = item.equipment_category_uuid;
    form.equipment_category = item.equipment_category;
    form.description = item.description;
};

let update = () => {
    axios.put('api/equipment/categories/' + form.equipment_category_uuid, form).
        then(response => {
            console.log(response.data);
            dialog.value = false;
            router.reload();
        }).catch(error => {
            console.log(error);
        });
};

let deleteItem = (item) => {
    axios.delete('api/equipment/categories/' + item.equipment_category_uuid).
        then(response => {
            console.log(response.data);
            router.reload();
        }).catch(error => {
            console.log(error);
        });
};

</script>

<template>

    <Head title="Equipments" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Categorias de Equipos</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <v-card>
                        <v-row>
                            <v-col cols="12" sm="12">
                                <div class="text-end">
                                    <v-btn prepend-icon="$plus" variant="tonal" class="m-2">
                                        Agregar
                                    </v-btn>
                                </div>
                                <v-card-title class="text-h6 text-md-h5 text-lg-h4">
                                    <v-text-field v-model="search" append-icon="mdi-magnify" label="Buscar" single-line
                                        hide-details variant="solo"></v-text-field>
                                </v-card-title>
                            </v-col>
                            <v-col cols="12" sm="12">
                                <v-data-table :headers="headers" :items="equipment_categories"
                                    :sort-by="[{ key: 'equipment_category', order: 'asc' }]" :search="search"
                                    fixed-header>
                                    <template v-slot:item.actions="{ item }">
                                        <v-icon color="blue-grey-lighten-4" size="small" class="me-2"
                                            @click="editItem(item)">
                                            mdi-pencil
                                        </v-icon>
                                        <v-icon color="red-lighten-3" size="small" @click="deleteItem(item)">
                                            mdi-delete
                                        </v-icon>
                                    </template>
                                </v-data-table>
                            </v-col>
                        </v-row>
                    </v-card>
                    <template>
                        <div class="pa-4 text-center">
                            <v-dialog v-model="dialog" max-width="600">
                                <template v-slot:activator="{ props: activatorProps }">
                                    <v-btn class="text-none font-weight-regular" prepend-icon="mdi-account"
                                        text="Edit Profile" variant="tonal" v-bind="activatorProps"></v-btn>
                                </template>

                                <v-card prepend-icon="mdi-pencil" title="Editar categoria">
                                    <v-card-text class="mt-3">
                                        <v-row dense>
                                            <v-col cols="12">
                                                <v-text-field variant="solo-filled" label="Categoria*" required
                                                    v-model="form.equipment_category"></v-text-field>
                                            </v-col>

                                            <v-col cols="12">
                                                <v-textarea variant="solo-filled" label="Descripción"
                                                    v-model="form.description"></v-textarea>
                                            </v-col>
                                        </v-row>

                                        <small class="text-caption text-medium-emphasis">* campos requeridos</small>
                                    </v-card-text>

                                    <v-divider></v-divider>

                                    <v-card-actions>
                                        <v-spacer></v-spacer>

                                        <v-btn text="Cerrar" variant="plain" @click="dialog = false"></v-btn>

                                        <v-btn color="primary" text="Guardar" variant="tonal" @click="update"></v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
                        </div>
                    </template>
                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>