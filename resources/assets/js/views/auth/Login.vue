<template>
    <form class="form" @submit.prevent="login">
        <h1 class="form__title">Добро пожаловать !</h1>
        <div class="form__group">
            <label>Email</label>
            <input type="text" class="form__control" v-model="form.email">
            <small class="error__control" v-if="error.email">{{error.email[0]}}</small>
        </div>
        <div class="form__group">
            <label>Пароль</label>
            <input type="password" class="form__control" v-model="form.password">
            <small class="error__control" v-if="error.password">{{error.password[0]}}</small>
        </div>
        <div class="form__group">
            <button :disabled="isProcessing" class="btn btn__primary">Войти</button>
        </div>
    </form>
</template>

<script>
    import Flash from '../../helpers/flash.js'
    import{post} from '../../helpers/api.js'
    import Auth from '../../store/auth'
    export default{
        data(){
            return{
                form:{

                    email : '',
                    password: '',

                },
                error:{},
                isProcessing:false
            }
        },

        methods:{
            login(){
                this.isProcessing = true
                this.error = {}
                post('/api/login',this.form)
                    .then((res)=>{
                        if(res.data.authenticated) {
                            Auth.set(res.data.api_token,res.data.user_id)
                            Flash.setSuccess('Вы вошли успешно !')
                            this.$router.push('/')
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