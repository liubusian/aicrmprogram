import { createApp } from 'vue';
import Alpine from 'alpinejs';
import './bootstrap';
import App from './App.vue';

window.Alpine = Alpine;
Alpine.start();

document.querySelectorAll('.vue-root').forEach((root) => {
	createApp(App, {
		page: root.dataset.page,
		data: JSON.parse(root.dataset.props || '{}'),
	}).mount(root);
});
