<script setup lang="ts">
import axios from 'axios';
import { ClipboardDocumentListIcon, FolderIcon } from '@heroicons/vue/24/outline';
import HeaderRegistrado from '../components/Header-registrado.vue';
import NavIzquierda from '../components/Navizquierda.vue';
import AccesosClienteEdicion from '../components/editar-cliente/AccesosClienteEdicion.vue';
import DatosClienteEdicion from '../components/editar-cliente/DatosClienteEdicion.vue';
import ResumenClienteEdicion from '../components/editar-cliente/ResumenClienteEdicion.vue';
import { onMounted, ref, type Component } from 'vue';

interface MenuItem {
    id: string;
    label: string;
    icon: string;
    path: string;
    iconType: 'image' | 'emoji' | 'component';
    iconComponent?: Component;
}

interface Pais {
    id: number;
    nom: string;
}

const propiedades = defineProps<{
    tipoMenu?: string;
}>();

const menuAdministrador: MenuItem[] = [
    {
        id: 'dashboard',
        label: 'Dashboard',
        icon: '/imagenes/casita.png',
        path: '/dashboard-admin',
        iconType: 'image',
    },
    {
        id: 'anadir-cliente',
        label: 'Anadir cliente',
        icon: '/imagenes/cliente.png',
        path: '/anadir-cliente',
        iconType: 'image',
    },
    {
        id: 'editar-cliente',
        label: 'Editar cliente',
        icon: '/imagenes/cliente.png',
        path: '/editar-cliente',
        iconType: 'image',
    },
];

const menuOperador: MenuItem[] = [
    {
        id: 'dashboard',
        label: 'Dashboard',
        icon: '/imagenes/casita.png',
        path: '/dashboard-operador-cliente',
        iconType: 'image',
    },
    {
        id: 'clientes',
        label: 'Clientes',
        icon: '/imagenes/cliente.png',
        path: '/dashboard-admin',
        iconType: 'image',
    },
    {
        id: 'ofertas',
        label: 'Ofertas',
        icon: '',
        path: '/ofertas',
        iconType: 'component',
        iconComponent: ClipboardDocumentListIcon,
    },
    {
        id: 'operaciones',
        label: 'Operaciones',
        icon: '',
        path: '/dashboard-operador-cliente#operaciones',
        iconType: 'component',
        iconComponent: FolderIcon,
    },
];

const menuLateral = propiedades.tipoMenu === 'admin' ? menuAdministrador : menuOperador;

const cargandoCliente = ref(true);
const errorCliente = ref('');
const parametroId = new URLSearchParams(window.location.search).get('id');
const clienteId = parametroId ? Number(parametroId) : null;


const resumenCliente = ref({
    idCliente: '',
    fechaAlta: '',
    estado: '',
});

const datosCliente = ref({
    nombreEmpresa: '',
    cifNif: '',
    pais: '',
    direccion: '',
    ciudad: '',
    codigoPostal: '',
    contacto: '',
    email: '',
    telefono: '',
});

const paisesDisponibles = ref<Pais[]>([]);
const ciudadesDisponibles = ref<string[]>([]);

const cambiarCiudad = (nombreCiudad: string) => {
    datosCliente.value.ciudad = nombreCiudad;
};

const cambiarNombreEmpresa = (nuevoNombre: string) => {
    datosCliente.value.nombreEmpresa = nuevoNombre;
};

const cambiarCif = (nuevoCif: string) => {
    datosCliente.value.cifNif = nuevoCif;
};

const cambiarDireccion = (nuevaDireccion: string) => {
    datosCliente.value.direccion = nuevaDireccion;
};

const cambiarCodigoPostal = (nuevoCodigoPostal: string) => {
    datosCliente.value.codigoPostal = nuevoCodigoPostal;
};

const cambiarContacto = (nuevoContacto: string) => {
    datosCliente.value.contacto = nuevoContacto;
};

const cambiarEmail = (nuevoEmail: string) => {
    datosCliente.value.email = nuevoEmail;
};

const cambiarTelefono = (nuevoTelefono: string) => {
    datosCliente.value.telefono = nuevoTelefono;
};

const guardarCambios = async () => {
    if (!clienteId) {
        alert('No se ha encontrado el id del cliente');
        return;
    }

    try {
        await axios.put('/api/clientes/' + clienteId, {
            nom_empresa: datosCliente.value.nombreEmpresa,
            cif_nif: datosCliente.value.cifNif,
            adreca: datosCliente.value.direccion,
            ciutat: datosCliente.value.ciudad,
            codi_postal: datosCliente.value.codigoPostal,
            contacte: datosCliente.value.contacto,
            email: datosCliente.value.email,
            telefon: datosCliente.value.telefono,
        });

        alert('Cliente actualizado correctamente');
    } catch (error) {
        console.error(error);
        alert('No se ha podido actualizar el cliente');
    }
};


const datosAcceso = {
    usuario: 'Juanperez',
    contrasena: 'SoyJuan',
    rol: 'Cliente',
    usuarioActivo: true,
};

const rolesDisponibles = ['Cliente', 'Administrador', 'Gestor'];

const cargarPaissos = async () => {
    try {
        const response = await axios.get('/api/paissos');
        paisesDisponibles.value = response.data;
    } catch (error) {
        console.error('Error al cargar paises:', error);
    }
};

const cargarCiutats = async (paisId: number) => {
    try {
        const response = await axios.get('/api/ciutats/' + paisId);

        ciudadesDisponibles.value = response.data.map((ciutat: { nom: string }) => {
            return ciutat.nom;
        });
    } catch (error) {
        console.error('Error al cargar ciudades:', error);
        ciudadesDisponibles.value = [];
    }
};

const cambiarPais = async (nombrePais: string) => {
    datosCliente.value.pais = nombrePais;
    datosCliente.value.ciudad = '';

    const paisSeleccionado = paisesDisponibles.value.find((pais) => {
        return pais.nom === nombrePais;
    });

    if (paisSeleccionado) {
        await cargarCiutats(paisSeleccionado.id);
    } else {
        ciudadesDisponibles.value = [];
    }
};


const cargarCliente = async () => {
    if (!clienteId) {
        errorCliente.value = 'No se ha encontrado el cliente';
        cargandoCliente.value = false;
        return;
    }

    try {
        cargandoCliente.value = true;
        errorCliente.value = '';

        const response = await axios.get(`/api/clientes/${clienteId}`);
        const cliente = response.data;

        resumenCliente.value = {
            idCliente: cliente.codi_client || '',
            fechaAlta: cliente.data_creacio || '',
            estado: cliente.actiu ? 'Activo' : 'Inactivo',
        };

        datosCliente.value = {
            nombreEmpresa: cliente.nom_empresa || '',
            cifNif: cliente.cif_nif || '',
            pais: cliente.pais_nom || '',
            direccion: cliente.adreca || '',
            ciudad: cliente.ciutat || '',
            codigoPostal: cliente.codi_postal || '',
            contacto: cliente.contacte || '',
            email: cliente.email || '',
            telefono: cliente.telefon || '',
        };

        const paisSeleccionado = paisesDisponibles.value.find((pais) => {
            return pais.nom === cliente.pais_nom;
        });

        if (paisSeleccionado) {
            await cargarCiutats(paisSeleccionado.id);
        }
    } catch (error) {
        console.error(error);
        errorCliente.value = 'No se ha podido cargar el cliente';
    } finally {
        cargandoCliente.value = false;
    }
};

onMounted(async () => {
    await cargarPaissos();
    await cargarCliente();
});
</script>

<template>
    <main class="min-h-screen bg-[#f3f1f3]">
        <div class="fixed inset-x-0 top-0 z-30">
            <HeaderRegistrado
                title="Editar Cliente"
                subtitle="Modifica la informacion del cliente y gestiona su acceso"
            />
        </div>

        <NavIzquierda :items="menuLateral" />

        <section class="pl-72 pr-8 pt-32 sm:pr-10">
            <div class="mx-auto max-w-5xl">
                <p v-if="cargandoCliente" class="text-sm text-gray-600">
                    Cargando cliente...
                </p>

                <p v-else-if="errorCliente" class="text-sm text-red-600">
                    {{ errorCliente }}
                </p>

                <template v-else>
                    <ResumenClienteEdicion
                        :id-cliente="resumenCliente.idCliente"
                        :fecha-alta="resumenCliente.fechaAlta"
                        :estado="resumenCliente.estado"
                    />

                    <div class="grid gap-6 lg:grid-cols-[1.15fr_0.95fr]">
                        <DatosClienteEdicion
                            :datos-iniciales="datosCliente"
                            :paises-disponibles="paisesDisponibles"
                            :ciudades-disponibles="ciudadesDisponibles"
                            @cambiar-pais="cambiarPais"
                            @cambiar-ciudad="cambiarCiudad"
                            @cambiar-nombre-empresa="cambiarNombreEmpresa"
                            @cambiar-cif="cambiarCif"
                            @cambiar-direccion="cambiarDireccion"
                            @cambiar-codigo-postal="cambiarCodigoPostal"
                            @cambiar-contacto="cambiarContacto"
                            @cambiar-email="cambiarEmail"
                            @cambiar-telefono="cambiarTelefono"
                        />

                        <AccesosClienteEdicion
                            :datos-iniciales="datosAcceso"
                            :roles-disponibles="rolesDisponibles"
                            @guardar-cambios="guardarCambios"
                        />
                    </div>
                </template>
            </div>
        </section>
    </main>
</template>

<style lang="scss" scoped>
</style>
