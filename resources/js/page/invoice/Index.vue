<template>
    <div id="form-title" class="uk-card uk-card-primary uk-card-body">
        <p>Invoice <a href="#" @click="showModalCreate" class="uk-icon-button" uk-icon="plus"></a></p>
    </div>
    <div class="main-wrapper">
        <form class="uk-grid-small" uk-grid>
            <div class="uk-width-1-3">
                <input class="uk-input uk-form-small" type="text" placeholder="Customer Name" v-model="filter.customerName">
            </div>

            <div class="uk-width-1-3">
                <input class="uk-input uk-form-small" id="issueFrom" placeholder="Issue From" type="text" v-model="filter.issueFrom">
            </div>

            <div class="uk-width-1-3">
                <input class="uk-input uk-form-small" id="issueTo" placeholder="Issue To" type="text" v-model="filter.issueTo">
            </div>

            <div class="uk-width-1-3">
                <input class="uk-input uk-form-small" id="dueFrom" placeholder="Due From" type="text" v-model="filter.dueFrom">
            </div>

            <div class="uk-width-1-3">
                <input class="uk-input uk-form-small" id="dueTo" placeholder="Due To" type="text" v-model="filter.dueTo">
            </div>

            <div class="uk-width-1-3">
                <button class="uk-button uk-button-primary uk-button-small" @click.prevent="search">Search</button>
            </div>
        </form>

        <table class="uk-table uk-table-striped uk-table-small uk-table-divider">
            <thead>
            <tr>
                <th>No</th>
                <th>Customer Name</th>
                <th>Amount</th>
                <th>Issue Date</th>
                <th>Due Date</th>
                <th>Operation</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items" :key="item.id">
                <td>{{item.no}}</td>
                <td>{{item.customerName}}</td>
                <td align="right">{{item.total}}</td>
                <td>{{$filters.formatDate(item.issueDate?.date)}}</td>
                <td>{{$filters.formatDate(item.dueDate?.date)}}</td>
                <td>
                    <a href="#" @click="showModalUpdate(item.id)" class="uk-icon-link uk-margin-small-right" uk-icon="pencil"></a>
                    <a href="#" @click="showModalDelete(item.id, item.no)" class="uk-icon-link uk-margin-small-right" uk-icon="trash"></a>
                </td>
            </tr>
            </tbody>
        </table>
        <pagination :page="page" :initial-total-page="initialTotalPage" :arr-page="arrPage" @gotoPage="gotoPage"/>
    </div>
    <div id="modal-delete" uk-modal>
        <div class="uk-modal-dialog uk-modal-body">
            <div class="uk-margin">
                <p>Are you sure to delete <strong>{{deleteItem.no}}</strong> ?</p>
            </div>
            <div class="uk-text-right">
                <div v-if="isLoading != true">
                    <button class="uk-button uk-button-default uk-modal-close" type="button">No</button>
                    &nbsp;
                    <button class="uk-button uk-button-primary" type="button" @click="deleteSubmit">Yes</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import * as _ from 'lodash'
    import moment from 'moment'
    import flatpickr from "flatpickr"
    import queryString from 'querystring'
    import Pagination from "../common/Pagination";

    let createDefault = { error: "", name: "", categoryId: "", type: "" }
    let validationDefault = { name: "", categoryId: "", type: "" }

    export default {
        name: "CategoryIndex",
        components: {Pagination},
        props: [
            'initialPage',
            'initialTotalPage',
            'pageUrl',
            'baseUrl'
        ],
        mounted() {
            flatpickr("#issueFrom", {})
            flatpickr("#issueTo", {})
            flatpickr("#dueFrom", {})
            flatpickr("#dueTo", {})
        },
        data() {
            let arrPage = _.times(this.initialTotalPage, _.constant(0))
            return {
                isLoading: false,
                items: window.arrData,
                categories: window.arrCategory,
                types: window.arrType,
                page: this.initialPage,
                arrPage: arrPage,
                filter: window.arrFilter,
                create: { ...createDefault },
                update: { ...createDefault },
                deleteItem: { id: null, name: "" },
                formValidation: { ...validationDefault },
                formUpdateValidation: { ...validationDefault }
            }
        },
        methods: {
            gotoPage(page) {
                let url = this.baseUrl + "?page=" + page
                let params = {
                    page: page,
                    customerName: this.filter.customerName,
                    issueFrom: this.filter.issueFrom,
                    issueTo: this.filter.issueTo,
                    dueFrom: this.filter.dueFrom,
                    dueTo: this.filter.dueTo
                };
                window.location.href = this.pageUrl + "?" +queryString.stringify(params);
            },
            search() {
                this.gotoPage(1);
            },
            showModalCreate() {
                window.location.href = this.baseUrl + "/invoice/create";
            },
            showModalUpdate(id) {
                window.location.href = this.baseUrl + "/invoice/edit/" + id;
            },
            showModalDelete(id, no) {
                this.deleteItem = { id: id, no: no }
                UIkit.modal("#modal-delete").show()
            },
            async deleteSubmit() {
                let response = null
                this.isLoading = true
                let that = this
                try {
                    response = await axios.get("invoice/delete/"+this.deleteItem.id)
                    UIkit.notification({message: response.data.message, status: 'success'})
                    UIkit.modal("#modal-delete").hide()
                    _.delay(function() {
                        that.gotoPage(1)
                    }, 1000);
                } catch (error) {
                    UIkit.modal("#modal-delete").hide()
                    UIkit.notification({message: error.response.data.message, status: 'danger'})
                } finally {
                    this.isLoading = false
                }
            }
        }
    }
</script>

<style scoped>

</style>