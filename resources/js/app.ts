import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';

const pages = import.meta.glob('./pages/**/*.vue', { eager: true });

createInertiaApp({
	resolve: (name) => {
		const key = `./pages/${name}.vue`;
		if (!pages[key]) {
			throw new Error(`Page not found: ${name}`);
		}
		return pages[key];
	},
	setup({ el, App, props, plugin }) {
		const app = createApp({ render: () => h(App, props) });
		app.use(plugin);
		app.mount(el);
	},
});
