import * as Vue from 'vue'

import Pagination from './page/common/Pagination';
import NumericInput from './components/numeric-input';

import ButtonCounter from './page/ButtonCounter'
import Login from './page/Login'
import CategoryIndex from './page/category/Index'
import FormCategory from './page/category/Form'

import ItemIndex from './page/item/Index'
import FormItem from './page/item/Form'

import InvoiceCreate from './page/invoice/Create'
import FormInvoice from './page/invoice/Form'

window.UIkit = require("uikit")
window.Icons = require("uikit/dist/js/uikit-icons")

UIkit.use(window.Icons)

// Create a Vue application
const app = Vue.createApp({})

app.config.globalProperties.$filters = {
    itemTypeName(value) {
        return value == 1 ? 'Product' : 'Service'
    },
    formatDecimal(value) {
        value = value.toString()
        value = value.replaceAll(',', '')
        value = value === "" ? "0" : value
        value = parseFloat(value)
        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }
}

app.component('Pagination', Pagination)
app.component('numeric-input', NumericInput)

app.component('button-counter', ButtonCounter)
app.component('login', Login)
app.component('category-index', CategoryIndex)
app.component('form-category', FormCategory)

app.component('item-index', ItemIndex)
app.component('form-item', FormItem)

app.component('invoice-create', InvoiceCreate)
app.component('form-invoice', FormInvoice)

document.addEventListener('DOMContentLoaded', function(){
    app.mount('#mainWrapper')
}, false)


