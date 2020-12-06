<template>
    <div>
        <form class="uk-form-horizontal">
            <fieldset class="uk-fieldset">

                <legend class="uk-legend">Create</legend>

                <div v-if="form.error != ''"  class="uk-alert-danger" uk-alert>
                    <p>{{form.error}}</p>
                </div>

                <div v-if="isLoading != true">

                    <div class="uk-margin">
                        <label class="uk-form-label" for="name">Name <span class="uk-text-danger">*</span></label>
                        <div class="uk-form-controls">
                            <input :class="{ 'uk-input': true, 'uk-form-danger' : formValidation.name != ''}" id="name" type="text" v-model="form.name">
                            <div v-if="formValidation.name != ''" class="uk-text-danger">{{formValidation.name}}</div>
                        </div>
                    </div>

                </div>

                <div v-else class="uk-flex uk-flex-center">
                    <div uk-spinner></div>
                </div>

            </fieldset>
        </form>
        <div class="uk-text-right">
            <div v-if="isLoading != true">
                <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
                &nbsp;
                <button class="uk-button uk-button-primary" type="button" @click="save">Save</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Form.vue",
        props: [
            'formDefault',
            'formValidation'
        ],
        data() {
            return {
                isLoading: false,
                form: this.formDefault,
            }
        },
        methods: {
            save() {
                this.$emit('submit', this.form)
            }
        }
    }
</script>

<style scoped>

</style>