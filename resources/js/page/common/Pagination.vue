<template>
    <ul v-if="initialTotalPage > 1" class="uk-pagination uk-flex-center" uk-margin>
        <li v-if="page > 1"><a href="#" @click="this.$emit('gotoPage',(page-1))"><span uk-pagination-previous></span></a></li>
        <li v-for="(item, index) in arrPage" key="index" :class="{ 'uk-active' : index + 1 == page}">
            <a v-if="(index + 1) == page" href="#" @click="this.$emit('gotoPage',(index+1))">{{index+1}}</a>
            <a v-else href="#" @click="this.$emit('gotoPage',(index+1))">{{index+1}}</a>
        </li>
        <li v-if="page + 1 < initialTotalPage"><a href="#" @click="this.$emit('gotoPage',(page+1))"><span uk-pagination-next></span></a></li>
    </ul>
</template>

<script>
    export default {
        name: "Pagination",
        props: [
            'initialTotalPage',
            'page',
            'arrPage'
        ],
        data() {
            return {
            }
        },
    }
</script>

<style scoped>

</style>