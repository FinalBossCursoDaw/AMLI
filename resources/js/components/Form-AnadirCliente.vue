<script setup lang="ts">
import { ref, onMounted, watch } from 'vue';

interface FormData {
    nom_empresa: string;
    cif_nif: string;
    pais_id: string | number;
    ciutat: string;
    codi_postal: string;
    adreca: string;
    contacte: string;
    email: string;
    telefon: string;
    observacions: string;
}

interface Pais {
    id: number;
    nom: string;
}

interface Ciutat {
    id: number;
    nom: string;
}

const formData = ref<FormData>({
    nom_empresa: '',
    cif_nif: '',
    pais_id: '',
    ciutat: '',
    codi_postal: '',
    adreca: '',
    contacte: '',
    email: '',
    telefon: '',
    observacions: ''
});

const paises = ref<Pais[]>([]);
const ciutats = ref<Ciutat[]>([]);
const loading = ref(false);
const message = ref<{ type: 'success' | 'error'; text: string } | null>(null);
const errors = ref<Record<string, string[]>>({});

onMounted(async () => {
    await loadPaises();
});

// Observar cambios en el país seleccionado
watch(() => formData.value.pais_id, async (newPaisId) => {
    if (newPaisId) {
        formData.value.ciutat = ''; // Limpia la ciudad
        await loadCiutats(newPaisId);
    } else {
        ciutats.value = [];
    }
});

const loadPaises = async () => {
    try {
        const response = await fetch('/api/clientes/paises');
        const data = await response.json();
        
        if (Array.isArray(data)) {
            paises.value = data;
        }
    } catch (error) {
        console.error('Error al cargar países:', error);
        showMessage('error', 'Error al cargar los países');
    }
};

const loadCiutats = async (paisId: string | number) => {
    try {
        const response = await fetch(`/api/clientes/ciutats/${paisId}`);
        const data = await response.json();
        
        if (Array.isArray(data)) {
            ciutats.value = data;
        }
    } catch (error) {
        console.error('Error al cargar ciudades:', error);
        showMessage('error', 'Error al cargar las ciudades');
    }
};

const handleSubmit = async () => {
    errors.value = {};
    message.value = null;
    loading.value = true;

    try {
        const response = await fetch('/api/clientes', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify(formData.value)
        });

        const data = await response.json();

        if (response.ok) {
            showMessage('success', data.message || 'Cliente creado correctamente');
            setTimeout(() => {
                resetForm();
            }, 2000);
        } else {
            if (data.errors) {
                errors.value = data.errors;
                showMessage('error', 'Por favor, revisa los errores en el formulario');
            } else {
                showMessage('error', data.message || 'Error al crear el cliente');
            }
        }
    } catch (error) {
        console.error('Error:', error);
        showMessage('error', 'Error al conectar con el servidor');
    } finally {
        loading.value = false;
    }
};

const showMessage = (type: 'success' | 'error', text: string) => {
    message.value = { type, text };
    setTimeout(() => {
        if (message.value?.text === text) {
            message.value = null;
        }
    }, 5000);
};

const resetForm = () => {
    formData.value = {
        nom_empresa: '',
        cif_nif: '',
        pais_id: '',
        ciutat: '',
        codi_postal: '',
        adreca: '',
        contacte: '',
        email: '',
        telefon: '',
        observacions: ''
    };
    ciutats.value = [];
    errors.value = {};
};

const getCsrfToken = (): string => {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    return token || '';
};

const hasError = (field: keyof FormData): boolean => {
    return field in errors.value && errors.value[field].length > 0;
};
</script>

<template>
    <div class="max-w-4xl mx-auto p-8">
        <!-- Mensaje de éxito/error -->
        <div v-if="message" :class="[
            'mb-6 p-4 rounded-lg',
            message.type === 'success' 
                ? 'bg-green-100 text-green-700 border border-green-400' 
                : 'bg-red-100 text-red-700 border border-red-400'
        ]">
            {{ message.text }}
        </div>

        <form @submit.prevent="handleSubmit" class="bg-white rounded-lg shadow-lg p-8 space-y-8">
            
            <!-- Datos de la empresa -->
            <div class="space-y-4">
                <h2 class="text-2xl font-montserrat font-bold text-[#303030] border-b-4 border-[#cb0c14] pb-2">
                    Datos de la empresa
                </h2>
                
                <div>
                    <label class="block text-sm font-montserrat font-semibold text-[#303030] mb-2">
                        Nombre de la empresa <span class="text-red-500">*</span>
                    </label>
                    <input
                        v-model="formData.nom_empresa"
                        type="text"
                        placeholder="Nombre de la empresa"
                        :class="['w-full px-4 py-3 border rounded-lg focus:outline-none focus:border-[#cb0c14] transition-colors', 
                                 hasError('nom_empresa') ? 'border-red-500' : 'border-gray-300']"
                    />
                    <span v-if="hasError('nom_empresa')" class="text-red-500 text-sm mt-1 block">
                        {{ errors.nom_empresa[0] }}
                    </span>
                </div>

                <div>
                    <label class="block text-sm font-montserrat font-semibold text-[#303030] mb-2">
                        CIF/NIF <span class="text-red-500">*</span>
                    </label>
                    <input
                        v-model="formData.cif_nif"
                        type="text"
                        placeholder="CIF/NIF"
                        :class="['w-full px-4 py-3 border rounded-lg focus:outline-none focus:border-[#cb0c14] transition-colors', 
                                 hasError('cif_nif') ? 'border-red-500' : 'border-gray-300']"
                    />
                    <span v-if="hasError('cif_nif')" class="text-red-500 text-sm mt-1 block">
                        {{ errors.cif_nif[0] }}
                    </span>
                </div>
            </div>

            <!-- Dirección -->
            <div class="space-y-4">
                <h2 class="text-2xl font-montserrat font-bold text-[#303030] border-b-4 border-[#cb0c14] pb-2">
                    Dirección
                </h2>

                <div>
                    <label class="block text-sm font-montserrat font-semibold text-[#303030] mb-2">
                        País <span class="text-red-500">*</span>
                    </label>
                    <select
                        v-model="formData.pais_id"
                        :class="['w-full px-4 py-3 border rounded-lg focus:outline-none focus:border-[#cb0c14] transition-colors', 
                                 hasError('pais_id') ? 'border-red-500' : 'border-gray-300']"
                    >
                        <option value="">Selecciona un país</option>
                        <option v-for="pais in paises" :key="pais.id" :value="pais.id">
                            {{ pais.nom }}
                        </option>
                    </select>
                    <span v-if="hasError('pais_id')" class="text-red-500 text-sm mt-1 block">
                        {{ errors.pais_id[0] }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-montserrat font-semibold text-[#303030] mb-2">
                            Ciudad <span class="text-red-500">*</span>
                        </label>
                        <select
                            v-model="formData.ciutat"
                            :class="['w-full px-4 py-3 border rounded-lg focus:outline-none focus:border-[#cb0c14] transition-colors', 
                                     hasError('ciutat') ? 'border-red-500' : 'border-gray-300']"
                            :disabled="!formData.pais_id"
                        >
                            <option value="">Selecciona una ciudad</option>
                            <option v-for="ciutat in ciutats" :key="ciutat.id" :value="ciutat.nom">
                                {{ ciutat.nom }}
                            </option>
                        </select>
                        <span v-if="hasError('ciutat')" class="text-red-500 text-sm mt-1 block">
                            {{ errors.ciutat[0] }}
                        </span>
                    </div>

                    <div>
                        <label class="block text-sm font-montserrat font-semibold text-[#303030] mb-2">
                            Código Postal
                        </label>
                        <input
                            v-model="formData.codi_postal"
                            type="text"
                            placeholder="Código Postal"
                            :class="['w-full px-4 py-3 border rounded-lg focus:outline-none focus:border-[#cb0c14] transition-colors', 
                                     hasError('codi_postal') ? 'border-red-500' : 'border-gray-300']"
                        />
                        <span v-if="hasError('codi_postal')" class="text-red-500 text-sm mt-1 block">
                            {{ errors.codi_postal[0] }}
                        </span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-montserrat font-semibold text-[#303030] mb-2">
                        Dirección <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        v-model="formData.adreca"
                        placeholder="Dirección"
                        rows="3"
                        :class="['w-full px-4 py-3 border rounded-lg focus:outline-none focus:border-[#cb0c14] transition-colors resize-none', 
                                 hasError('adreca') ? 'border-red-500' : 'border-gray-300']"
                    ></textarea>
                    <span v-if="hasError('adreca')" class="text-red-500 text-sm mt-1 block">
                        {{ errors.adreca[0] }}
                    </span>
                </div>
            </div>

            <!-- Persona de contacto -->
            <div class="space-y-4">
                <h2 class="text-2xl font-montserrat font-bold text-[#303030] border-b-4 border-[#cb0c14] pb-2">
                    Persona de contacto
                </h2>

                <div>
                    <label class="block text-sm font-montserrat font-semibold text-[#303030] mb-2">
                        Nombre del contacto <span class="text-red-500">*</span>
                    </label>
                    <input
                        v-model="formData.contacte"
                        type="text"
                        placeholder="Nombre del contacto"
                        :class="['w-full px-4 py-3 border rounded-lg focus:outline-none focus:border-[#cb0c14] transition-colors', 
                                 hasError('contacte') ? 'border-red-500' : 'border-gray-300']"
                    />
                    <span v-if="hasError('contacte')" class="text-red-500 text-sm mt-1 block">
                        {{ errors.contacte[0] }}
                    </span>
                </div>

                <div>
                    <label class="block text-sm font-montserrat font-semibold text-[#303030] mb-2">
                        Correo Electrónico <span class="text-red-500">*</span>
                    </label>
                    <input
                        v-model="formData.email"
                        type="email"
                        placeholder="Correo Electrónico"
                        :class="['w-full px-4 py-3 border rounded-lg focus:outline-none focus:border-[#cb0c14] transition-colors', 
                                 hasError('email') ? 'border-red-500' : 'border-gray-300']"
                    />
                    <span v-if="hasError('email')" class="text-red-500 text-sm mt-1 block">
                        {{ errors.email[0] }}
                    </span>
                </div>

                <div>
                    <label class="block text-sm font-montserrat font-semibold text-[#303030] mb-2">
                        Teléfono <span class="text-red-500">*</span>
                    </label>
                    <input
                        v-model="formData.telefon"
                        type="tel"
                        placeholder="Teléfono"
                        :class="['w-full px-4 py-3 border rounded-lg focus:outline-none focus:border-[#cb0c14] transition-colors', 
                                 hasError('telefon') ? 'border-red-500' : 'border-gray-300']"
                    />
                    <span v-if="hasError('telefon')" class="text-red-500 text-sm mt-1 block">
                        {{ errors.telefon[0] }}
                    </span>
                </div>

                <div>
                    <label class="block text-sm font-montserrat font-semibold text-[#303030] mb-2">
                        Observaciones
                    </label>
                    <textarea
                        v-model="formData.observacions"
                        placeholder="Observaciones"
                        rows="3"
                        :class="['w-full px-4 py-3 border rounded-lg focus:outline-none focus:border-[#cb0c14] transition-colors resize-none', 
                                 hasError('observacions') ? 'border-red-500' : 'border-gray-300']"
                    ></textarea>
                    <span v-if="hasError('observacions')" class="text-red-500 text-sm mt-1 block">
                        {{ errors.observacions[0] }}
                    </span>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="flex justify-end gap-4 pt-6">
                <button
                    type="button"
                    @click="resetForm"
                    class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors disabled:opacity-50"
                    :disabled="loading"
                >
                    Limpiar
                </button>
                <button
                    type="submit"
                    class="px-6 py-3 bg-[#cb0c14] text-white font-semibold rounded-lg hover:bg-[#a90a10] transition-colors disabled:opacity-50 flex items-center gap-2"
                    :disabled="loading"
                >
                    <span v-if="loading" class="inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                    {{ loading ? 'Creando...' : 'Crear Cliente' }}
                </button>
            </div>
        </form>
    </div>
</template>

<style scoped>
input::placeholder,
textarea::placeholder,
select {
    @apply text-gray-400;
}

textarea {
    font-family: inherit;
}
</style>
