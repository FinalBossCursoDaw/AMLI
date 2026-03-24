<script setup lang="ts">
import { reactive } from 'vue'
import Pestana from '../../components/auth/Pestaña.vue'

type RegisterForm = {
	name: string
	email: string
	password: string
	passwordConfirmation: string
}

const form = reactive<RegisterForm>({
	name: '',
	email: '',
	password: '',
	passwordConfirmation: '',
})

const navItems = ['INICIO', 'QUIENES SOMOS', 'CONTACTO']

const submitForm = () => {
	console.log('Registro AMLI', form)
}
</script>

<template>
	<div class="page-wrap">
		<header class="top-nav">
			<div class="brand-slot">
				<Pestana />
			</div>

			<nav aria-label="Principal" class="menu">
				<a v-for="item in navItems" :key="item" href="#">{{ item }}</a>
			</nav>
		</header>

		<main class="stage">
			<section class="left-panel">
				<p class="eyebrow">Accede a</p>
				<h1>AMLI</h1>
				<p class="copy">Gestiona ofertas, operaciones y seguimiento en un solo lugar.</p>
				<div class="line" />
				<img class="left-logo" src="/imagenes/logo.svg" alt="AMLI Logistics" />
				<div class="red-blade" aria-hidden="true" />
			</section>

			<section class="right-panel">
				<form class="access-card" @submit.prevent="submitForm">
					<h2>Crea tu cuenta</h2>
					<p>Introduce tus datos para comenzar.</p>

					<label>
						Nombre
						<input v-model="form.name" type="text" name="name" placeholder="Tu nombre" />
					</label>

					<label>
						Email
						<input v-model="form.email" type="email" name="email" placeholder="Introduce el email" />
					</label>

					<label>
						Contrasena
						<input
							v-model="form.password"
							type="password"
							name="password"
							placeholder="Introduce la contrasena"
						/>
					</label>

					<label>
						Confirmar contrasena
						<input
							v-model="form.passwordConfirmation"
							type="password"
							name="password_confirmation"
							placeholder="Confirma la contrasena"
						/>
					</label>

					<button type="submit">Crear cuenta</button>
				</form>
			</section>
		</main>
	</div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@500;700&display=swap');

.page-wrap {
	min-height: 100vh;
	background: #e5e5e7;
	font-family: 'Plus Jakarta Sans', sans-serif;
	color: #0f172a;
	overflow: hidden;
}

.top-nav {
	height: 140px;
	background: linear-gradient(135deg, #ff1622 0%, #d60010 65%, #9a0009 100%);
	display: flex;
	align-items: flex-end;
	position: relative;
	padding-left: 0;
	padding-bottom: 1rem;
}

.brand-slot {
	position: absolute;
	left: 8px;
	top: 0;
	width: min(360px, 92vw);
	z-index: 2;
}

.menu {
	display: flex;
	gap: clamp(1rem, 3.5vw, 4.2rem);
	margin-left: auto;
	margin-right: 2rem;
}

.menu a {
	color: #ffffff;
	text-decoration: none;
	font-family: 'Montserrat', sans-serif;
	font-weight: 600;
	letter-spacing: 0.02em;
	font-size: clamp(0.9rem, 1.6vw, 1.05rem);
}

.stage {
	display: grid;
	grid-template-columns: 1.4fr 1fr;
	min-height: calc(100vh - 140px);
	position: relative;
}

.left-panel {
	padding: clamp(2rem, 7vw, 5rem) clamp(1.2rem, 6vw, 6rem) 2rem;
	position: relative;
	z-index: 1;
}

.eyebrow {
	margin: 0;
	font-size: clamp(2.1rem, 5vw, 3.2rem);
	font-family: 'Montserrat', sans-serif;
	font-weight: 500;
}

h1 {
	margin: 0.1rem 0;
	font-size: clamp(3rem, 8vw, 5.6rem);
	line-height: 1;
	font-family: 'Montserrat', sans-serif;
	font-weight: 800;
	color: #d60010;
}

.copy {
	margin: 1rem 0 0;
	max-width: 26ch;
	font-size: clamp(1.1rem, 2.4vw, 1.9rem);
	line-height: 1.24;
	font-weight: 500;
}

.line {
	margin-top: 1.15rem;
	width: 160px;
	height: 4px;
	background: #d60010;
	border-radius: 99px;
}

.left-logo {
	margin-top: 2.2rem;
	width: min(460px, 88%);
	filter: drop-shadow(0 18px 20px rgba(0, 0, 0, 0.25));
}

.red-blade {
	position: absolute;
	right: -5%;
	top: -2%;
	width: min(360px, 40vw);
	height: 110%;
	background: linear-gradient(180deg, #ff0012, #ad0011);
	clip-path: polygon(34% 0, 100% 0, 58% 100%, 0 100%);
	opacity: 0.95;
	z-index: -1;
	box-shadow: -10px 0 24px rgba(214, 0, 16, 0.3);
}

.right-panel {
	display: grid;
	place-items: center;
	padding: 2rem 1.2rem;
}

.access-card {
	width: min(420px, 100%);
	background: #f4f4f5;
	border-radius: 14px;
	padding: 2rem 2.1rem;
	box-shadow: 0 10px 20px rgba(15, 23, 42, 0.22);
	display: grid;
	gap: 0.95rem;
	border: 1px solid #d9d9de;
}

.access-card h2 {
	margin: 0;
	font-family: 'Montserrat', sans-serif;
	font-size: 2rem;
	line-height: 1.1;
	color: #2d2f35;
}

.access-card p {
	margin: 0;
	color: #8b8f98;
	font-size: 1.05rem;
}

label {
	display: grid;
	gap: 0.35rem;
	font-weight: 600;
	color: #3c414c;
	font-size: 0.94rem;
}

input {
	border: 1px solid #d6d9df;
	background: #ffffff;
	height: 44px;
	border-radius: 6px;
	padding: 0 0.8rem;
	font-size: 0.95rem;
	font-family: inherit;
}

input:focus {
	outline: none;
	border-color: #de0015;
	box-shadow: 0 0 0 3px rgba(222, 0, 21, 0.15);
}

button {
	margin-top: 0.5rem;
	height: 50px;
	border: 0;
	border-radius: 10px;
	background: linear-gradient(90deg, #e30014 0%, #7a0009 100%);
	color: #ffffff;
	font-family: 'Montserrat', sans-serif;
	font-size: 2rem;
	font-weight: 700;
	cursor: pointer;
	transition: transform 140ms ease, filter 140ms ease;
}

button:hover {
	filter: brightness(1.06);
	transform: translateY(-1px);
}

@media (max-width: 1024px) {
	.top-nav {
		padding-left: 300px;
	}

	.stage {
		grid-template-columns: 1fr;
	}

	.left-panel {
		padding-bottom: 0;
	}

	.red-blade {
		display: none;
	}

	.right-panel {
		padding-top: 0.5rem;
		padding-bottom: 2.4rem;
	}
}

@media (max-width: 780px) {
	.top-nav {
		height: 158px;
		align-items: flex-end;
		padding: 0 1rem 1rem;
	}

	.brand-slot {
		left: 8px;
		top: 0;
		width: min(320px, 90vw);
	}

	.menu {
		margin-left: auto;
		gap: 1rem;
	}

	.menu a {
		font-size: 0.88rem;
	}

	.left-logo {
		width: min(340px, 90%);
	}

	.access-card {
		padding: 1.3rem;
	}

	.access-card h2 {
		font-size: 1.6rem;
	}

	button {
		font-size: 1.5rem;
	}
}
</style>