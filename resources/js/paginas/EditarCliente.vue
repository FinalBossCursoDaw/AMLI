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

interface DatosAcceso {
    usuario: string;
    contrasena: string;
    rol: string;
    usuarioActivo: boolean;
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
const parametros = new URLSearchParams(window.location.search);
const tipoEdicion = parametros.get('tipo') === 'usuario' ? 'usuario' : 'cliente';
const esEdicionUsuario = tipoEdicion === 'usuario';
const parametroId = parametros.get('id');
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

const datosAcceso = ref<DatosAcceso>({
    usuario: '',
    contrasena: '',
    rol: '',
    usuarioActivo: true,
});

const paisesDisponibles = ref<Pais[]>([]);
const ciudadesDisponibles = ref<string[]>([]);
const rolesDisponibles = ['Administrador', 'Operador', 'Cliente'];

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

const guardarCambiosCliente = async () => {
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

const obtenerRolId = (rol: string) => {
    if (rol === 'Administrador') {
        return 1;
    }

    if (rol === 'Operador' || rol === 'Gestor') {
        return 2;
    }

    if (rol === 'Cliente') {
        return 3;
    }

    return null;
};

const guardarCambiosUsuario = async (datosFormulario: DatosAcceso) => {
    const usuarioId = Number(parametros.get('id'));

    if (!usuarioId) {
        alert('No se ha encontrado el id del usuario');
        return;
    }

    const rolId = obtenerRolId(datosFormulario.rol);

    if (!rolId) {
        alert('El rol seleccionado no es valido');
        return;
    }

    try {
        await axios.put(`/api/usuarios/${usuarioId}`, {
            username: datosFormulario.usuario,
            contrasenya: datosFormulario.contrasena,
            rol_id: rolId,
            actiu: datosFormulario.usuarioActivo ? 1 : 0,
        });

        alert('Usuario actualizado correctamente');
    } catch (error) {
        console.error(error);
        alert('No se ha podido actualizar el usuario');
    }
};

const cancelarEdicion = () => {
    window.history.back();
};

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

const cargarUsuario = async () => {
    const usuarioId = Number(parametros.get('id'));

    if (!usuarioId) {
        errorCliente.value = 'No se ha encontrado el usuario';
        cargandoCliente.value = false;
        return;
    }

    try {
        cargandoCliente.value = true;
        errorCliente.value = '';

        const response = await axios.get(`/api/usuarios/${usuarioId}`);
        const usuario = response.data;

        datosAcceso.value = {
            usuario: usuario.username || '',
            contrasena: usuario.contrasenya || '',
            rol: usuario.rol || '',
            usuarioActivo: Boolean(usuario.actiu),
        };
    } catch (error) {
        console.error(error);
        errorCliente.value = 'No se ha podido cargar el usuario';
    } finally {
        cargandoCliente.value = false;
    }
};

onMounted(async () => {
    if (esEdicionUsuario) {
        await cargarUsuario();
        return;
    }

    await cargarPaissos();
    await cargarCliente();
});
</script>

<template>
    <main class="min-h-screen bg-[#f3f1f3]">
        <div class="fixed inset-x-0 top-0 z-30">
            <HeaderRegistrado
                :title="esEdicionUsuario ? 'Editar Usuario' : 'Editar Cliente'"
                :subtitle="esEdicionUsuario ? 'Gestiona los accesos y permisos del usuario' : 'Modifica la informacion del cliente'"
            />
        </div>

        <NavIzquierda :items="menuLateral" />

        <section class="pl-72 pr-8 pt-40 sm:pr-10 lg:pt-44">
            <div :class="esEdicionUsuario ? 'mx-auto max-w-2xl' : 'mx-auto max-w-5xl'">
                <p v-if="cargandoCliente" class="text-sm text-gray-600">
                    {{ esEdicionUsuario ? 'Cargando usuario...' : 'Cargando cliente...' }}
                </p>

                <p v-else-if="errorCliente" class="text-sm text-red-600">
                    {{ errorCliente }}
                </p>

                <template v-else>
                    <ResumenClienteEdicion
                        v-if="!esEdicionUsuario"
                        :id-cliente="resumenCliente.idCliente"
                        :fecha-alta="resumenCliente.fechaAlta"
                        :estado="resumenCliente.estado"
                    />

                    <div class="grid gap-6">
                        <DatosClienteEdicion
                            v-if="!esEdicionUsuario"
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
                            @cancelar="cancelarEdicion"
                            @guardar-cambios="guardarCambiosCliente"
                        />

                        <AccesosClienteEdicion
                            v-if="esEdicionUsuario"
                            :datos-iniciales="datosAcceso"
                            :roles-disponibles="rolesDisponibles"
                            @cancelar="cancelarEdicion"
                            @guardar-cambios="guardarCambiosUsuario"
                        />
                    </div>
                </template>
            </div>
        </section>
    </main>
</template>

<style lang="scss" scoped>
</style>
