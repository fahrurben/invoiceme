<template>
    <button @click="count++" class="uk-button uk-button-default">
        You clicked me {{ count }} times.
    </button>
</template>

<script>
    export default {
        name: "ButtonCounter",
        data() {
            return {
                count: 0
            }
        },
    }
</script>

<style scoped>

</style>