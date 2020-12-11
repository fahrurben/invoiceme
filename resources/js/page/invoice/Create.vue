<template>
    <div id="form-title" class="uk-card uk-card-primary uk-card-body">
        <p>Invoice</p>
    </div>
    <div class="main-wrapper">
        <form-invoice
                :title="Create"
                :form-default="form"
                :form-validation="formValidation"
        >
        </form-invoice>
        <div class="uk-clearfix uk-margin-small-top">
            <button class="uk-button uk-button-primary uk-float-right" type="button" @click="showModalCreate">Add Line</button>
        </div>
        <div id="modal-create" uk-modal>
            <div class="uk-modal-dialog uk-modal-body">

                <form class="uk-form-horizontal">
                    <fieldset class="uk-fieldset">

                        <legend class="uk-legend">Line</legend>

                        <div>
                            <div class="uk-margin">
                                <label class="uk-form-label" for="item">Item <span class="uk-text-danger">*</span></label>
                                <div class="uk-form-controls">
                                    <select v-model="lineCreate.itemId" id="item"
                                            :class="{ 'uk-select': true, 'uk-form-small': true, 'uk-form-danger' : lineValidation.itemId != ''}">
                                        <option value="">- Item -</option>
                                        <option v-for="(option, index) in items" v-bind:value="option.id">
                                            {{ option.name }}
                                        </option>
                                    </select>
                                    <div v-if="lineValidation.itemId != ''" class="uk-text-danger">{{lineValidation.itemId}}</div>
                                </div>
                            </div>

                            <div class="uk-margin">
                                <label class="uk-form-label" for="qty">Qty <span class="uk-text-danger">*</span></label>
                                <div class="uk-form-controls">
                                    <numeric-input :class="{ 'uk-input': true, 'uk-text-right': true, 'uk-form-small': true, 'uk-form-danger' : lineValidation.qty != ''}" id="qty" v-model="lineCreate.qty" />
                                    <div v-if="lineValidation.qty != ''" class="uk-text-danger">{{lineValidation.qty}}</div>
                                </div>
                            </div>

                            <div class="uk-margin">
                                <label class="uk-form-label" for="price">Price <span class="uk-text-danger">*</span></label>
                                <div class="uk-form-controls">
                                    <numeric-input :class="{ 'uk-input': true, 'uk-text-right': true, 'uk-form-small': true, 'uk-form-danger' : lineValidation.price != ''}" id="price" v-model="lineCreate.price" />
                                    <div v-if="lineValidation.price != ''" class="uk-text-danger">{{lineValidation.price}}</div>
                                </div>
                            </div>

                            <div class="uk-margin">
                                <label class="uk-form-label" for="amount">Amount</label>
                                <div class="uk-form-controls">
                                    <input class="uk-input uk-form-small uk-text-right calculated-input" id="amount" v-model="lineCreateAmount" readonly="true">
                                    <div v-if="lineValidation.amount != ''" class="uk-text-danger">{{lineValidation.amount}}</div>
                                </div>
                            </div>
                            <div class="uk-text-right">
                                <div>
                                    <button class="uk-button uk-button-default uk-modal-close" type="button">Close</button>
                                    &nbsp;
                                    <button @click.prevent="saveLine" class="uk-button uk-button-primary">Save</button>
                                </div>
                            </div>
                        </div>


                    </fieldset>
                </form>
            </div>
        </div>

        <div id="modal-update" uk-modal>
            <div class="uk-modal-dialog uk-modal-body">

                <form class="uk-form-horizontal">
                    <fieldset class="uk-fieldset">

                        <legend class="uk-legend">Line</legend>

                        <div>
                            <div class="uk-margin">
                                <label class="uk-form-label" for="item">Item <span class="uk-text-danger">*</span></label>
                                <div class="uk-form-controls">
                                    <select v-model="lineUpdate.itemId" id="item"
                                            :class="{ 'uk-select': true, 'uk-form-small': true, 'uk-form-danger' : lineValidation.itemId != ''}">
                                        <option value="">- Item -</option>
                                        <option v-for="(option, index) in items" v-bind:value="option.id">
                                            {{ option.name }}
                                        </option>
                                    </select>
                                    <div v-if="lineValidationUpdate.itemId != ''" class="uk-text-danger">{{lineValidationUpdate.itemId}}</div>
                                </div>
                            </div>

                            <div class="uk-margin">
                                <label class="uk-form-label" for="qty">Qty <span class="uk-text-danger">*</span></label>
                                <div class="uk-form-controls">
                                    <numeric-input :class="{ 'uk-input': true, 'uk-text-right': true, 'uk-form-small': true, 'uk-form-danger' : lineValidationUpdate.qty != ''}" id="qty" v-model="lineUpdate.qty" />
                                    <div v-if="lineValidationUpdate.qty != ''" class="uk-text-danger">{{lineValidationUpdate.qty}}</div>
                                </div>
                            </div>

                            <div class="uk-margin">
                                <label class="uk-form-label" for="price">Price <span class="uk-text-danger">*</span></label>
                                <div class="uk-form-controls">
                                    <numeric-input :class="{ 'uk-input': true, 'uk-text-right': true, 'uk-form-small': true, 'uk-form-danger' : lineValidationUpdate.price != ''}" id="price" v-model="lineUpdate.price" />
                                    <div v-if="lineValidationUpdate.price != ''" class="uk-text-danger">{{lineValidationUpdate.price}}</div>
                                </div>
                            </div>

                            <div class="uk-margin">
                                <label class="uk-form-label" for="amount">Amount</label>
                                <div class="uk-form-controls">
                                    <input class="uk-input uk-form-small uk-text-right calculated-input" id="amount" v-model="lineUpdateAmount" readonly="true">
                                    <div v-if="lineValidationUpdate.amount != ''" class="uk-text-danger">{{lineValidationUpdate.amount}}</div>
                                </div>
                            </div>
                            <div class="uk-text-right">
                                <div>
                                    <button class="uk-button uk-button-default uk-modal-close" type="button">Close</button>
                                    &nbsp;
                                    <button @click.prevent="updateLine" class="uk-button uk-button-primary">Save</button>
                                </div>
                            </div>
                        </div>

                    </fieldset>
                </form>
            </div>
        </div>

        <div id="modal-delete" uk-modal>
            <div class="uk-modal-dialog uk-modal-body">
                <div class="uk-margin">
                    <p>Are you sure to delete ?</p>
                </div>
                <div class="uk-text-right">
                    <div>
                        <button class="uk-button uk-button-default uk-modal-close" type="button">No</button>
                        &nbsp;
                        <button class="uk-button uk-button-primary" type="button" @click="deleteLine">Yes</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="lines-section">
            <table class="uk-table uk-table-striped uk-table-small uk-table-divider">
                <thead>
                <tr>
                    <th>Item</th>
                    <th class="uk-text-center">Qty</th>
                    <th class="uk-text-center">Price</th>
                    <th class="uk-text-center">Amount</th>
                    <th class="uk-text-center">Operation</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(line, index) in lines" v-bind:value="index">
                    <td>{{line.itemName}}</td>
                    <td align="right">{{$filters.formatDecimal(line.qty)}}</td>
                    <td align="right">{{$filters.formatDecimal(line.price)}}</td>
                    <td align="right">{{$filters.formatDecimal(line.amount)}}</td>
                    <td align="center">
                        <a href="#" @click="showModalUpdate(index)" class="uk-icon-link uk-margin-small-right" uk-icon="pencil"></a>
                        <a href="#" @click="showModalDelete(index)" class="uk-icon-link uk-margin-small-right" uk-icon="trash"></a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="uk-form-horizontal uk-grid-small" uk-grid>
            <div class="uk-width-1-2">
            </div>
            <div class="uk-width-1-2">
                <div class="uk-margin">
                    <label class="uk-form-label" for="tax">Tax <span class="uk-text-danger">*</span></label>
                    <div class="uk-form-controls">
                        <numeric-input :styles="{ 'uk-input': true, 'uk-form-small': true, 'uk-text-right': true}" v-model="tax" id="tax" />
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="subTotal">SubTotal</label>
                    <div class="uk-form-controls">
                        <input class="uk-input uk-form-small uk-text-right calculated-input" v-model="subTotalFormatted" id="subTotal" readonly>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="taxTotal">Tax Total</label>
                    <div class="uk-form-controls">
                        <input class="uk-input uk-form-small uk-text-right calculated-input" v-model="taxTotalFormatted" id="taxTotal" readonly>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="invoiceTotal">Total</label>
                    <div class="uk-form-controls">
                        <input class="uk-input uk-form-small uk-text-right calculated-input" v-model="invoiceTotalFormatted" id="invoiceTotal" readonly>
                    </div>
                </div>
            </div>
        </div>

        <div class="uk-text-right uk-margin-top">
            <div>
                <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
                &nbsp;
                <button class="uk-button uk-button-primary" type="button" @click.prevent="save">Save</button>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import * as _ from 'lodash'
    import queryString from 'querystring'
    import Pagination from "../common/Pagination";

    let createDefault = {
        error: "",
        no: "",
        issueDate: "",
        dueDate: "",
        customerName: "",
        customerEmail: "",
        tax: 0
    }
    let lineDefault = {
        id: null,
        itemId: "",
        itemName: "",
        qty: 0,
        price: 0,
        amount: 0
    }
    let validationDefault = {
        no: "",
        issueDate: "",
        dueDate: "",
        customerName: "",
        customerEmail: "",
        tax: ""
    }
    let validationLineDefault = {
        itemId: "",
        qty: "",
        price: "",
        amount: ""
    }

    export default {
        name: "create",
        props: [
            'baseUrl'
        ],
        data() {
            return {
                items: window.arrItem,
                form: { ...createDefault },
                formValidation: { ...validationDefault },
                tax: 0,
                lines: [],
                lineCreate: { ...lineDefault },
                lineValidation: { ...validationLineDefault },
                updatingIndex: null,
                lineUpdate: { ...lineDefault },
                lineValidationUpdate: { ...validationLineDefault },
                deletingIndex: null,
            }
        },
        computed: {
            lineCreateAmount: function () {
                return this.$filters.formatDecimal(this.lineCreate.qty * this.lineCreate.price)
            },
            lineUpdateAmount: function () {
                return this.$filters.formatDecimal(this.lineUpdate.qty * this.lineUpdate.price)
            },
            subTotal: function () {
                return this.lines.reduce((subTotal, line) => { return (line.qty * line.price) + subTotal }, 0)
            },
            subTotalFormatted: function () {
                return this.$filters.formatDecimal(this.subTotal)
            },
            taxTotal: function () {
                return this.tax * this.subTotal / 100
            },
            taxTotalFormatted: function () {
                return this.$filters.formatDecimal(this.taxTotal)
            },
            invoiceTotal: function () {
                return this.subTotal - this.taxTotal
            },
            invoiceTotalFormatted: function () {
                return this.$filters.formatDecimal(this.invoiceTotal)
            },
        },
        methods: {
            getItemName(itemId) {
                let name = ""
                let item = _.find(this.items, (item) => item.id == itemId)
                name = item != null ? item.name : ""
                return name
            },
            showModalCreate() {
                this.lineCreate = { ...lineDefault }
                this.lineValidation = { ...validationLineDefault }
                UIkit.modal("#modal-create").show()
            },
            showModalUpdate(index) {
                let lineData = this.lines[index];
                this.updatingIndex = index;
                this.lineUpdate = { ...lineData }
                this.lineValidationUpdate = { ...validationLineDefault }
                UIkit.modal("#modal-update").show()
            },
            showModalDelete(index) {
                this.deletingIndex = index;
                UIkit.modal("#modal-delete").show()
            },
            validateLine(lineData) {
                let isValid = true;
                this.lineValidation = { ...validationLineDefault }
                if (lineData.itemId == "") {
                    this.lineValidation.itemId = "Item must be selected"
                    isValid &= false
                }
                if (!_.isNumber(_.toNumber(lineData.qty))) {
                    this.lineValidation.qty = "Qty must be number"
                    isValid &= false
                }
                if (!_.isNumber(_.toNumber(lineData.price))) {
                    this.lineValidation.price = "Price must be number"
                    isValid &= false
                }
                if (lineData.qty <= 0) {
                    this.lineValidation.qty = "Qty must be greater than zero"
                    isValid &= false
                }
                if (lineData.price <= 0) {
                    this.lineValidation.price = "Price must be greater than zero"
                    isValid &= false
                }

                return isValid
            },
            saveLine() {
                if (this.validateLine(this.lineCreate)) {
                    let itemName = this.getItemName(this.lineCreate.itemId)
                    this.lines.push({...this.lineCreate, itemName, amount: this.lineCreateAmount})
                    UIkit.modal("#modal-create").hide()
                }
            },
            updateLine() {
                if (this.validateLine(this.lineUpdate)) {
                    let itemName = this.getItemName(this.lineUpdate.itemId)
                    this.lines[this.updatingIndex] = {...this.lineUpdate, itemName, amount: this.lineUpdateAmount};
                    UIkit.modal("#modal-update").hide()
                }
            },
            deleteLine() {
                this.lines.splice(this.deletingIndex, 1);
                UIkit.modal("#modal-delete").hide()
            },
            async save() {
                let response = null
                let that = this
                try {
                    response = await axios.post("store",{
                        ...this.form,
                        tax: this.tax,
                        lines: [ ...this.lines ]
                    })
                    UIkit.notification({message: response.data.message, status: 'success'})
                    _.delay(function() {
                        window.location.href = that.baseUrl + '/invoice';
                    }, 1000);
                } catch (error) {
                    if (_.has(error, "response.data.validation")) {
                        let validations = error.response.data.validation
                        _.forEach(validations, function(obj, key) {
                            that.formValidation = { ...that.formValidation, [key]:_.values(obj)[0]}
                        })
                    } else {
                        this.create.error = error.response.data.message
                    }
                } finally {
                    this.isLoading = false
                }
            }
        }

    }
</script>

<style scoped>

</style>