<template>
    <div>
        <form class="uk-form-horizontal">
            <fieldset class="uk-fieldset">

                <legend class="uk-legend">{{title}}</legend>

                <div v-if="formDefault.error != ''"  class="uk-alert-danger" uk-alert>
                    <p>{{formDefault.error}}</p>
                </div>

                <div v-if="isLoading != true" class="uk-grid-small" uk-grid>

                    <div class="uk-width-1-2">
                        <div class="uk-margin">
                            <label class="uk-form-label" for="no">No <span class="uk-text-danger">*</span></label>
                            <div class="uk-form-controls">
                                <input :class="{ 'uk-input': true, 'uk-form-small': true, 'uk-form-danger' : formValidation.no != ''}" id="no" type="text" v-model="formDefault.no">
                                <div v-if="formValidation.no != ''" class="uk-text-danger">{{formValidation.no}}</div>
                            </div>
                        </div>
                    </div>

                    <div class="uk-width-1-2"></div>

                    <div class="uk-width-1-2">
                        <div class="uk-margin">
                            <label class="uk-form-label" for="issueDate">Issue Date <span class="uk-text-danger">*</span></label>
                            <div class="uk-form-controls">
                                <input :class="{ 'uk-input': true, 'uk-form-small': true, 'uk-form-danger' : formValidation.issueDate != ''}" id="issueDate" type="text" v-model="formDefault.issueDate">
                                <div v-if="formValidation.issueDate != ''" class="uk-text-danger">{{formValidation.issueDate}}</div>
                            </div>
                        </div>
                    </div>

                    <div class="uk-width-1-2">
                        <div class="uk-margin">
                            <label class="uk-form-label" for="dueDate">Due Date <span class="uk-text-danger">*</span></label>
                            <div class="uk-form-controls">
                                <input :class="{ 'uk-input': true, 'uk-form-small': true, 'uk-form-danger' : formValidation.dueDate != ''}" id="dueDate" type="text" v-model="formDefault.dueDate">
                                <div v-if="formValidation.dueDate != ''" class="uk-text-danger">{{formValidation.dueDate}}</div>
                            </div>
                        </div>
                    </div>

                    <div class="uk-width-1-2">
                        <div class="uk-margin">
                            <label class="uk-form-label" for="customerName">Customer Name <span class="uk-text-danger">*</span></label>
                            <div class="uk-form-controls">
                                <input :class="{ 'uk-input': true, 'uk-form-small': true, 'uk-form-danger' : formValidation.customerName != ''}" id="customerName" type="text" v-model="formDefault.customerName">
                                <div v-if="formValidation.customerName != ''" class="uk-text-danger">{{formValidation.customerName}}</div>
                            </div>
                        </div>
                    </div>

                    <div class="uk-width-1-2">
                        <div class="uk-margin">
                            <label class="uk-form-label" for="customerEmail">Customer Email <span class="uk-text-danger">*</span></label>
                            <div class="uk-form-controls">
                                <input :class="{ 'uk-input': true, 'uk-form-small': true, 'uk-form-danger' : formValidation.customerEmail != ''}" id="customerEmail" type="text" v-model="formDefault.customerEmail">
                                <div v-if="formValidation.customerEmail != ''" class="uk-text-danger">{{formValidation.customerEmail}}</div>
                            </div>
                        </div>
                    </div>

                </div>

                <div v-else class="uk-flex uk-flex-center">
                    <div uk-spinner></div>
                </div>

            </fieldset>
        </form>
    </div>
</template>

<script>
    import flatpickr from "flatpickr"

    export default {
        name: "Form.vue",
        props: [
            'title',
            'formDefault',
            'formValidation'
        ],
        data() {
            return {
                isLoading: false,
            }
        },
        mounted() {
            flatpickr("#issueDate", {})
            flatpickr("#dueDate", {})
        },
        methods: {
            save() {
                this.$emit('submit', this.formDefault)
            }
        }
    }
</script>

<style scoped>

</style>