<template>
    <div class="recipe__list">
        <div class="recipe__item" v-for="book in books">
            <router-link class="recipe__inner" :to="`/books/${book.id}`">
            <img class="image__upload" :src="`/images/${book.image}`" v-if="book.image"/>
                <p class="recipe__name">{{book.name}}</p>
            </router-link>

        </div>
    </div>
</template>
<script>
    import { get } from '../../helpers/api'
    export default{
        data(){
            return {
                books: []
            }
        },
        created(){
            get('/api/books')
                .then((res)=>{
                    this.books = res.data.books
                })
        }
    }
</script>