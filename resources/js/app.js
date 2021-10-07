require('./bootstrap');

import {createApp} from 'vue'

import App    from './views/App'
import router from './router'
import './bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'toastr/toastr.scss'

createApp(App).use(router).mount('#app')
