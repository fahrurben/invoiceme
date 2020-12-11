<template>
    <input
            :id="id"
            :type="type"
            :class="styles"
            :value="inputValue"
            @input="onChange"
    >
</template>

<script>
    export default {
        name: 'numeric-input',
        props: [
            'id',
            'type',
            'styles',
            'modelValue'
        ],
        data() {
            return {
                inputValue: this.modelValue,
            }
        },
        watch: {
            modelValue: function(newVal, oldVal) {
                newVal = newVal === "" ? "0" : newVal
                let strNumber = this.numberFormat(parseFloat(newVal))
                this.inputValue = strNumber
            }
        },
        emits: ['update:modelValue'],
        methods: {
            onChange($event) {
                let value = $event.target.value
                value = value.replaceAll(',', '')
                value = value === "" ? "0" : value
                let strNumber = this.numberFormat(parseFloat(value))
                this.inputValue = strNumber
                this.$emit('update:modelValue', parseFloat(value))
            },
            numberFormat(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            }
        }
    }
</script>

<style scoped>

</style>