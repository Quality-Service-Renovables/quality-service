<script setup>
import {Head} from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    equipments: Object,
});
</script>
<template>
    <Head title="Equipments" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Equipos</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <v-card>
                        <v-row>
                            <v-col cols="12" sm="12">
                                <v-card-title class="text-h6 text-md-h5 text-lg-h4">
                                    <v-text-field
                                        v-model="search"
                                        append-icon="mdi-magnify"
                                        label="Buscar"
                                        single-line
                                        hide-details
                                        variant="underlined"
                                    ></v-text-field>
                                </v-card-title>
                            </v-col>
                        </v-row>
                        <v-data-table
                            :headers="headers"
                            :items="equipments"
                            :sort-by="[{ key: 'equipment', order: 'asc' }]"
                            :search="search"
                            fixed-header
                        >
                            <!-- This template is used to have custom html elements in your specific column of the table -->
                            <template v-slot:item.equipment_image="{ item }">
                                <v-avatar :image="'../'+item.equipment_image" size="40" class="ma-1"></v-avatar>
                            </template>
                            <template v-slot:item.actions="{ item }">
                                <v-icon
                                    color="blue-grey-lighten-4"
                                    size="small"
                                    class="me-2"
                                    @click="editItem(item.raw)"
                                >
                                    mdi-pencil
                                </v-icon>
                                <v-icon
                                    color="red-lighten-3"
                                    size="small"
                                    @click="deleteItem(item.raw)"
                                >
                                    mdi-delete
                                </v-icon>
                            </template>
                            <template v-slot:no-data>
                                <v-btn
                                    color="primary"
                                >
                                    Reset
                                </v-btn>
                            </template>
                        </v-data-table>
                        <v-dialog v-model="dialogDelete" max-width="700px">
                            <v-card>
                                <v-card-title class="text-center">
                                    <v-icon
                                        size="xxx-large"
                                        class="me-2"
                                        color="orange-darken-2"
                                    >
                                        mdi-alert
                                    </v-icon>
                                    <br>
                                    <span class="text-h5">¿Estás seguro que deseas eliminar el equipo?</span><br>
                                    <small>Toda la información relacionada al equipo será eliminada</small>
                                </v-card-title>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue-darken-1" variant="text" @click="closeDelete">Cancelar</v-btn>
                                    <v-btn color="blue-darken-1" variant="text" @click="deleteItemConfirm">Confirmar</v-btn>
                                    <v-spacer></v-spacer>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </v-card>
                    <div id="snackbar" class="text-center">
                        <div class="text-center">
                            <v-snackbar
                                v-model="snackbar"
                                multi-line
                            >
                                {{ text }}
                                <template v-slot:actions>
                                    <v-btn
                                        color="red"
                                        variant="text"
                                        @click="snackbar = false"
                                    >
                                        Cerrar
                                    </v-btn>
                                </template>
                            </v-snackbar>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script>
export default {
    name: "Equipments",
    data: () => ({
        search: '',
        dialog: false,
        dialogDelete: false,
        headers: [
            { title: '', key: 'equipment_image', value: 'equipment_image' },
            {
                title: 'Equipo',
                align: 'start',
                key: 'equipment',
            },
            { title: 'Marca', key: 'trademark.trademark' },
            { title: 'Modelo', key: 'model' },
            { title: 'No. Serie', key: 'serial_number' },
            { title: 'Category', key: 'category.equipment_category' },
            { title: 'Estado', key: 'status.status' },
            { title: 'Actions', key: 'actions', sortable: false },
        ],
        updatePhoto: false,
        editedIndex: -1,
        editedItem: {
            equipment: '',
            equipment_image: '',
            model: '',
            serial_number: '',
            manual: '',
        },
        rules: [
            value => {
                return !value || !value.length || value[0].size < 2000000 || 'El tamaño de la imágen debe ser menor a 2 MB!'
            },
        ],
        hasErrors: false,
        errors: [],
        snackbar: false,
        text: '',
        timeout: 5000,
        draft: {},
    }),
    methods: {
        /**
         * @description Obtiene los datos de la base de datos
         */
        editItem (item) {
            this.draft          = item;
            this.editedIndex    = this.equipments.indexOf(item)
            this.editedItem     = Object.assign({}, item)
            this.dialog         = true
        },
        /**
         * @description Cierra el modal de editar
         *
         * @param item
         */
        deleteItem (item) {
            this.editedIndex = this.employees.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },
        /**
         * @description Elimina el registro de la base de datos
         */
        deleteItemConfirm () {
            axios.delete('api/employee/'+this.editedItem.token).then((response) => {
                if (response.status === 204) {
                    this.text = 'Registro eliminado';
                }
            }).catch((errors) => {
                this.text = errors.response.statusText;
            });
            this.snackbar = true;
            this.employees.splice(this.editedIndex, 1)
            this.closeDelete();
        },
        /**
         * @description Cierra el modal de eliminar
         */
        close () {
            this.dialog = false
            this.updatePhoto = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },
        /**
         * @description Cierra el modal de eliminar
         */
        closeDelete () {
            this.dialogDelete = false
            this.updatePhoto = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },
    }
}
</script>

<style scoped>
    .equipment-image {
        margin: 5px 0;
        border-radius: 100%;
    }
</style>
