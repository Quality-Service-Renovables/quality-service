<template>
    <Toaster position="top-right" richColors :visibleToasts="10" />

    <v-row>
        <v-col cols="12" sm="12">
            <v-data-table :headers="headers" :items="permissions" fixed-header :search="search"
                :loading="loadingPermissions">
                <template v-slot:top>
                    <v-toolbar flat>
                        <v-toolbar-title class="ml-1">
                            <v-text-field v-model="search" label="Buscar" hide-details variant="solo"
                                append-inner-icon="mdi-magnify" density="compact"></v-text-field>
                        </v-toolbar-title>
                        <v-divider class="mx-4" inset vertical></v-divider>
                        <v-spacer></v-spacer>
                    </v-toolbar>
                </template>
            </v-data-table>
        </v-col>
    </v-row>
</template>


<script>
import { Toaster, toast } from 'vue-sonner'

export default {
    components: {
        Toaster,
    },
    data: () => ({
        search: '',
        headers: [
            { title: 'Nombre', key: 'description' },
            { title: 'Código', key: 'name' },
        ],
        loadingPermissions: false,
        permissions: [],
    }),
    methods: {
        fetchPermissions() {
            this.loadingPermissions = true;
            return axios.get('api/auth-guard/permissions').then(response => {
                this.permissions = response.data.data;
                this.loadingPermissions = false;
            }).catch(error => {
                this.loadingPermissions = false;
                toast.error('Error al cargar el catálogo de permisos');
            });
        }
    },
    mounted() {
        this.fetchPermissions();
    }
}
</script>
