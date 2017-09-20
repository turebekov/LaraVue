<template>
    <form class="form" @submit.prevent="register">
        <h1 class="form__title">Создать аккаунт</h1>
        <div class="form__group">
            <label>Имя</label>
            <input  type="text" class="form__control" v-model="form.name">
            <small class="error__control" v-if="error.name">{{error.name[0]}}</small>
        </div>
        <div class="form__group">
            <label>Email</label>
            <input type="text" class="form__control" v-model="form.email"/>
            <small class="error__control" v-if="error.email">{{error.email[0]}}</small>
        </div>
        <div class="form__group">
            <label>Пароль</label>
            <input type="password" class="form__control" v-model="form.password">
            <small class="error__control" v-if="error.password">{{error.password[0]}}</small>
        </div>
        <div class="form__group">
            <label >Повторит пароль</label>
            <input type="password" class="form__control" v-model="form.password_confirmation">

        </div>
        <div class="form_group">
            <button :disabled="isProcessing" class="btn btn__primary">
                Регистрация
            </button>
        </div>
    </form>
</template>


<script>
    import Flash from '../../helpers/flash.js'
    import{post} from '../../helpers/api.js'
    export default{
        data(){
            return{
                form:{
                    name: '',
                    email : '',
                    password: '',
                    password_confirmation: ''
                },
                error:{},
                isProcessing:false
            }
        },
        methods:{
            register(){
                this.isProcessing = true
                this.error = {}
                post('/api/register',this.form)
                    .then((res)=>{
                        if(res.data.registered) {
                            Flash.setSuccess('Аккаунт успешно сохранен !')
                            this.$router.push('/login')
                        }
                        this.isProcessing = false
                })
                    .catch((err)=>{
                    if(err.response.status === 422){
                        this.error = err.response.data
                    }
                        this.isProcessing = false
                    })
            }
        }
    }
</script>