<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
</script>

<template>
    <Toaster position="top-right" richColors :visibleToasts="10" />

    <Head title="Fallas" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl  leading-tight">Fallas</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <v-card>
                        <v-row>
                            <v-col cols="12" sm="12">
                                <v-data-table :headers="headers" :items="failures" fixed-header :search="search" :mobile="isMobile()">
                                    <template v-slot:item.active="{ value }">
                                        <v-icon :color="getColor(value)">mdi-circle-slice-8</v-icon>
                                    </template>
                                    <template v-slot:top>
                                        <v-toolbar flat>
                                            <v-toolbar-title class="ml-1">
                                                <v-text-field v-model="search" label="Buscar" hide-details
                                                    variant="solo" append-inner-icon="mdi-magnify"
                                                    density="compact"></v-text-field>
                                            </v-toolbar-title>
                                            <v-divider class="mx-4" inset vertical></v-divider>
                                            <v-spacer></v-spacer>
                                            <v-dialog v-model="dialog" max-width="500px" v-if="hasPermissionTo('failures.create') || hasPermissionTo('failures.update')">
                                                <template v-slot:activator="{ props }" v-if="hasPermissionTo('failures.create')">
                                                    <v-btn class="mb-2" color="primary" dark v-bind="props"
                                                        icon="mdi-plus"></v-btn>
                                                </template>
                                                <v-card>
                                                    <v-card-title>
                                                        <span class="text-h5">{{ formTitle }}</span>
                                                    </v-card-title>

                                                    <v-card-text>
                                                        <v-container>
                                                            <v-row>
                                                                <v-col cols="12">
                                                                    <v-text-field v-model="editedItem.failure"
                                                                        label="Nombre" variant="solo"
                                                                        hide-details></v-text-field>
                                                                </v-col>

                                                                <v-col cols="12">
                                                                    <div class="text-right">
                                                                        <v-btn v-if="!showCreateCategoryField"
                                                                            density="compact" prepend-icon="mdi-plus"
                                                                            class="mb-1 pr-0 text-none text-primary"
                                                                            variant="plain"
                                                                            @click="showCreateCategoryField = true">Nueva
                                                                            categoría</v-btn>
                                                                        <v-btn
                                                                            v-if="showCreateCategoryField && !loading_creating_category"
                                                                            density="compact" prepend-icon="mdi-close"
                                                                            class="mb-1 pr-0 text-none text-red"
                                                                            variant="plain"
                                                                            @click="showCreateCategoryField = false">Cancelar</v-btn>
                                                                        <v-btn v-if="showCreateCategoryField"
                                                                            density="compact"
                                                                            prepend-icon="mdi-content-save-check-outline"
                                                                            class="mb-1 pr-0 text-none text-primary"
                                                                            variant="plain" @click="saveCategory()"
                                                                            :loading="loading_creating_category"
                                                                            :disabled="!new_ct_failure">Guardar</v-btn>
                                                                    </div>
                                                                    <v-select v-model="editedItem.ct_failure_code"
                                                                        :items="ct_failures"
                                                                        item-title="ct_failure"
                                                                        item-value="ct_failure_code"
                                                                        label="Categoría" variant="solo" hide-details
                                                                        v-if="!showCreateCategoryField"></v-select>
                                                                    <v-text-field v-model="new_ct_failure"
                                                                        label="Categoría" variant="solo" hide-details
                                                                        v-if="showCreateCategoryField">
                                                                    </v-text-field>

                                                                </v-col>
                                                                <v-col cols="12">
                                                                    <v-switch label="Activo" v-model="editedItem.active"
                                                                        color="primary"></v-switch>
                                                                </v-col>

                                                            </v-row>
                                                        </v-container>
                                                    </v-card-text>

                                                    <v-card-actions>
                                                        <v-spacer></v-spacer>
                                                        <v-btn color="blue-darken-1" variant="text" @click="close">
                                                            Cancelar
                                                        </v-btn>
                                                        <v-btn color="blue-darken-1" variant="text" @click="save"
                                                            :disabled="showCreateCategoryField">
                                                            Guardar
                                                        </v-btn>
                                                    </v-card-actions>
                                                </v-card>
                                            </v-dialog>
                                            <v-dialog v-model="dialogDelete" max-width="500px">
                                                <v-card>
                                                    <v-card-title class="text-h5 text-center">¿Estás seguro de
                                                        eliminar?</v-card-title>
                                                    <v-card-actions>
                                                        <v-spacer></v-spacer>
                                                        <v-btn color="blue-darken-1" variant="text"
                                                            @click="closeDelete">Cancel</v-btn>
                                                        <v-btn color="blue-darken-1" variant="text"
                                                            @click="deleteItemConfirm(editedItem.failure_uuid)">Si,
                                                            eliminar</v-btn>
                                                        <v-spacer></v-spacer>
                                                    </v-card-actions>
                                                </v-card>
                                            </v-dialog>
                                        </v-toolbar>
                                    </template>
                                    <template v-slot:item.actions="{ item }">
                                        <v-icon class="me-2" size="small" @click="editItem(item)" v-if="hasPermissionTo('failures.update')">
                                            mdi-pencil
                                        </v-icon>
                                        <v-icon size="small" @click="deleteItem(item)" v-if="hasPermissionTo('failures.delete')">
                                            mdi-delete
                                        </v-icon>
                                    </template>
                                </v-data-table>
                            </v-col>
                        </v-row>
                    </v-card>
                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>

<script>
import { router } from '@inertiajs/vue3'
import { Toaster, toast } from 'vue-sonner'
import Swal from 'sweetalert2';

export default {
    components: {
        Toaster,
    },
    props: {
        failures: {
            type: Array,
            required: true
        }
    },
    data: () => ({
        search: '',
        dialog: false,
        dialogDelete: false,
        headers: [
            { title: 'Falla', key: 'failure' },
            { title: 'Estado', key: 'active' },
            { title: 'Categoría', key: 'category.ct_failure' },
            { title: 'Acciones', key: 'actions', sortable: false }
        ],
        editedIndex: -1,
        editedItem: {
            failure_uuid: '',
            failure: '',
            active: false,
            ct_failure_code: '',
        },
        defaultItem: {
            failure_uuid: '',
            failure: '',
            active: false,
            ct_failure_code: '',
        },
        ct_failures: [],
        showCreateCategoryField: false,
        new_ct_failure: '',
        loading_creating_category: false,
    }),
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'Nueva falla' : 'Editar falla'
        },
    },
    watch: {
        dialog(val) {
            val || this.close()
        },
        dialogDelete(val) {
            val || this.closeDelete()
        },
    },
    methods: {
        editItem(item) {
            this.editedIndex = this.failures.indexOf(item)
            item.active = item.active == "1" ? true : false
            item.ct_failure_code = item.category.ct_failure_code
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },
        deleteItem(item) {
            this.editedIndex = this.failures.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },
        deleteItemConfirm(item) {
            const putRequest = () => {
                return axios.delete('api/failures/' + item);
            };
            toast.promise(putRequest, {
                loading: 'Procesando...',
                success: (data) => {
                    this.closeDelete()
                    this.$inertia.reload()
                    return 'Falla eliminada correctamente';
                },
                error: (data) => {
                    this.handleErrors(data);
                }
            });
        },
        close() {
            this.dialog = false
            this.$nextTick(() => {
                console.log("Cambiando estatus en close");
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },
        closeDelete() {
            this.dialogDelete = false
            this.$nextTick(() => {
                console.log("Cambiando estatus en closeDelete");
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },
        save() {
            if (this.editedIndex > -1) {
                const putRequest = () => {
                    return axios.put('api/failures/' + this.editedItem.failure_uuid, {
                        failure: this.editedItem.failure,
                        active: this.editedItem.active,
                        ct_failure_code: this.editedItem.ct_failure_code,
                    });
                };
                toast.promise(putRequest(), {
                    loading: 'Procesando...',
                    success: (data) => {
                        this.close()
                        this.$inertia.reload()
                        return 'Falla actualizada correctamente';
                    },
                    error: (data) => {
                        this.handleErrors(data);
                    }
                });
            } else {
                const postRequest = () => {
                    return axios.post('api/failures', {
                        failure: this.editedItem.failure,
                        active: this.editedItem.active,
                        ct_failure_code: this.editedItem.ct_failure_code,
                    });
                };

                toast.promise(postRequest(), {
                    loading: 'Procesando...',
                    success: (data) => {
                        this.close()
                        this.$inertia.reload()
                        return 'Falla creada correctamente';
                    },
                    error: (data) => {
                        this.handleErrors(data);
                    }
                });
            }

        },
        getColor(value) {
            return value ? 'green' : 'red';
        },
        getfailureCategories() {
            axios.get('api/failure/categories')
                .then(response => {
                    this.ct_failures = response.data.data;
                })
                .catch(error => {
                    toast.error('Error al cargar las categorías de fallas');
                });
        },
        saveCategory() {
            this.loading_creating_category = true;
            axios.post('api/failure/categories', {
                ct_failure: this.new_ct_failure,
                active: true
            })
                .then(async response => {
                    let data = response.data.data;
                    this.loading_creating_category = false;
                    this.showCreateCategoryField = false;
                    await this.getfailureCategories();
                    this.new_ct_failure = '';
                    console.log("ct_failure_code: " + data.ct_failure_code);
                    this.editedItem.ct_failure_code = data.ct_failure_code
                    toast.success('Categoría creada correctamente');
                })
                .catch(error => {
                    this.loading_creating_category = false;
                    this.handleErrors(error);
                });
        },
    },
    mounted() {
        this.getfailureCategories();
    }
}
</script>
