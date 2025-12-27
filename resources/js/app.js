import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import Swal from 'sweetalert2';

// Make Swal globally available (optional, but useful)
window.Swal = Swal;