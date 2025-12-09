import './bootstrap';
import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';

// Only initialize Alpine if it's not already initialized
if (!window.Alpine) {
    Alpine.plugin(intersect);
    window.Alpine = Alpine;
    Alpine.start();
}
