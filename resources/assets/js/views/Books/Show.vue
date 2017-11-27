<template>
    <div class="recipe__show">
        <div class="recipe__image">
            <div class="recipe__box">
                <img :src="`/images/${book.image}`" v-if="book.image" >
            </div>
        </div>
        <div class="recipe__details">
            <div class="recipe__details_inner">
                <small>Submitted by: {{book.user.name}}</small>
                <h1 class="recipe__title">{{book.name}}</h1>
                <p class="recipe__description">{{book.description}}</p>
                <div v-if="auth.api_token && auth.user_id === book.user_id">
                    <router-link :to="`/books/${book.id}/edit`" class="btn btn_primary">
                        Edit
                    </router-link>
                    <button class="btn_danger" @click="remove" :disabled="isRemoving">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Flash from '../../helpers/flash'
    import Auth from '../../store/auth'
    import {get,del} from '../../helpers/api'
    export default {
        data(){
            return {
                auth: Auth.state,
                isRemoving: false,
                book: {
                    user: {}
                }
            }
        },
        created(){
            get(`/api/books/${this.$route.params.id}`)
                .then((res) => {
                    this.book = res.data.book
                })
        },
        methods: {
            remove() {
                this.isRemoving = false
                del(`/api/books/${this.$route.params.id}`)
                    .then((res) => {
                        if (res.data.deleted) {
                            Flash.setSuccess('You have successfully deleted recipe!')
                            this.$router.push('/')
                        }
                    })
            }
        }
    }
</script>