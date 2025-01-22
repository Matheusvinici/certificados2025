import 'bootstrap';  // Importa o Bootstrap e o Popper.js automaticamente

import jQuery from 'jquery';
import axios from 'axios';

// Expondo para o global window (caso precise)
window.$ = window.jQuery = jQuery;
window.Popper = window.Popper || {};  // Garante que o Popper esteja disponível globalmente
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
