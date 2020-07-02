// External Modules and adapters
import VueGoodTable from 'vue-good-table';
window.Vue.use(VueGoodTable);
import 'vue-good-table/dist/vue-good-table.css'

import '@mdi/font/css/materialdesignicons.min.css';
Vue.component('mdi', require('./components/modules/Mdi.vue').default);

import 'air-datepicker/dist/css/datepicker.css';
require('air-datepicker');
require('air-datepicker/dist/js/i18n/datepicker.es');
Vue.component('datepicker', require('./components/modules/Datepicker.vue').default);

import 'vue-multiselect/dist/vue-multiselect.min.css';
import MultiSelect from "vue-multiselect";
Vue.component('vue-multiselect', MultiSelect);
