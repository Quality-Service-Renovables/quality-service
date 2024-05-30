<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import App from '@/Components/App.vue';
import { mdiCheckBold } from '@mdi/js';

</script>

<template>

    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
                <v-row>
                    <!--<v-col cols="12" class="text-center pt-0 mb-5 pb-5">
                        <Dashboard></Dashboard>
                    </v-col>-->
                    <v-col cols="12" class="text-left pt-0 mb-5 pb-5">
                        <div class="search-wrapper">
                            <input type="text" class="search-input" placeholder="Buscar App" v-model="searchTerm"
                                @input="handleInput" />
                            <button class="search-button">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </v-col>
                    <v-col cols="12" :lg="searchTerm ? '12' :'6'" class="text-left" v-if="checkRole(['admin', 'tecnico', 'cliente'])">
                        <h4 class="text-grey-darken-1" v-if="!hideTittleSection">Administración</h4>
                        <div class="d-flex align-start flex-wrap">
                            <App path="dashboard" title="Dashboard" icon="mdi-monitor-dashboard" v-if="checkVisivility('Dashboard')"/>
                            <App path="#" title="Proyectos" icon="mdi-folder-text-outline" v-if="checkVisivility('Proyectos') && hasPermissionTo('projects')"/>
                            <App path="#" title="Usuarios" icon="mdi-account-group" v-if="checkVisivility('Usuarios') && hasPermissionTo('users')"/>
                            <App path="roles-permissions" title="Roles y permisos" icon="mdi-account-lock" v-if="checkVisivility('Roles y permisos') && hasPermissionTo('roles')"/>
                            <App path="profile" title="Perfil" icon="mdi-face-man-profile" v-if="checkVisivility('Perfil')"/>
                            <App path="https://www.qualityservicerenovables.com.mx" title="Landing page"
                                icon="mdi-monitor" v-if="checkVisivility('Landing page')"/>
                        </div>
                    </v-col>
                    <v-col cols="12" :lg="searchTerm ? '12' :'6'" class="text-left" v-if="checkRole(['admin', 'tecnico'])">
                        <h4 class="text-grey-darken-1" v-if="!hideTittleSection">Configuración</h4>
                        <div class="d-flex align-start flex-wrap">
                            <App path="equipments" title="Equipos" icon="mdi-clipboard-list-outline" v-if="checkVisivility('Equipos') && hasPermissionTo('equipments')"/>
                            <App path="equipments-categories" title="Categorias" icon="mdi-list-box-outline" v-if="checkVisivility('Categorias') && hasPermissionTo('equipments_categories')"/>
                            <App path="customers" title="Clientes" icon="mdi-format-list-checkbox" v-if="checkVisivility('Clientes') && hasPermissionTo('clients')"/>
                            <App path="#" title="Inspecciones" icon="mdi-table-cog" v-if="checkVisivility('Inspecciones') && hasPermissionTo('inspections')"/>
                            <App path="failures" title="Fallas" icon="mdi-playlist-remove" v-if="checkVisivility('Fallas') && hasPermissionTo('failures')"/>
                            <App path="trademarks" title="Marcas" icon="mdi-playlist-star" v-if="checkVisivility('Marcas') && hasPermissionTo('trademarks')"/>
                            <App path="models" title="Modelos" icon="mdi-format-list-text" v-if="checkVisivility('Modelos') && hasPermissionTo('models')"/>
                            <App path="oils" title="Aceites" icon="mdi-barrel" v-if="checkVisivility('Aceites') && hasPermissionTo('oils')"/>
                        </div>
                    </v-col>
                </v-row>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


<script>
export default {
    data() {
        return {
            permissions: [], // Variable para almacenar los permisos
            searchTerm: "",
            hideTittleSection: false,
        };
    },
    mounted() {
        // Al cargar el componente, obtén los permisos de la respuesta Inertia
        this.getPermissions();
    },
    methods: {
        getPermissions() {
            // Puedes hacer cualquier otra lógica necesaria con los permisos aquí
        },
        handleInput() {
        // Aquí puedes manejar la lógica de búsqueda según lo necesites
            console.log("Búsqueda:", this.searchTerm);
        },
        checkVisivility(path) {
            this.hideTittleSection = this.searchTerm != "" ? true : false;
            return this.searchTerm != "" ? path.toLowerCase().includes(this.searchTerm.toLowerCase()) : true;
        },
        checkRole(roles) {
            return roles.includes(this.$page.props.auth.role.name);
        },
    }
};
</script>

<style scoped>
/* Estilos personalizados */
.search-wrapper {
  position: relative;
  display: flex;
  align-items: center;
}

.search-input {
  width: 100%; /* Ajusta el ancho según tus necesidades */
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 20px;
  outline: none;
  height: 2.1em;
}

.search-button {
  position: absolute;
  right: 10px;
  background: none;
  border: none;
  outline: none;
  cursor: pointer;
}

</style>