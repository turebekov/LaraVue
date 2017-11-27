<template>
    <div class="recipe__show">
        <div class="recipe__header">
            <h3>{{action}} Book</h3>
            <div>
                <button class="btn btn__primary" @click="save" :disabled="isProcessing">
                    Save
                </button>
                <button class="btn" @click="$router.back()" :disabled="isProcessing">
                    Cancel
                </button>
            </div>
        </div>
        <div class="recipe__row">
            <div class="recipe__image">
                <div class="recipe__box">
                    <image-upload v-model="form.image"></image-upload>
                    <small class="error__control" v-if="error.image">
                        {{error.image[0]}}
                    </small>
                </div>
            </div>
            <div class="recipe__details">
                <div class="recipe__details_inner">
                    <div class="form__group">
                        <label>Name</label>
                        <input type="text" class="form__control" v-model="form.name">
                        <small class="error__control" v-if="error.name">
                            {{error.name[0]}}
                        </small>
                    </div>
                    <div class="form__group">
                        <label>Description</label>
                        <textarea  class="form__control" v-model="form.description"></textarea>
                        <small class="error__control" v-if="error.description">
                            {{error.description[0]}}
                        </small>
                    </div>
                    <div class="form__group">
                        <label>Text</label>
                        <textarea  class="form__control" v-model="form.text"></textarea>
                        <small class="error__control" v-if="error.text">
                            {{error.text[0]}}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">/*
    import Vue from 'vue'
    import Flash from '../../helpers/flash'
    import {get,set} from '../../helpers/api'
    import {toMulipartedForm} from '../../helpers/form'
    import ImageUpload from '../../components/ImageUpload.vue'

    export default {
        components:{
            ImageUpload
        },
        data(){
            return {
                form: {},
                error:{},
                isProcessing: false,
                initializeURL: `/api/books/create`,
                storeURL: `/api/books`,
                action: 'Create'
            }
        },
        created(){
            if(this.$route.meta.mode === 'edit'){
                this.initializeURL = `/api/books/${this.$route.params.id}/edit`
                this.storeURL = `/api/books/${this.$route.params.id}?_method=PUT`
                this.action = 'Update'
            }
            get(this.initializeURL)
                .then((res) => {
                    Vue.set(this.$data, 'form', res.data.form)
            })
        },
        methods:{
            save() {
                const form = toMulipartedForm(this.form, this.$route.meta.mode)
                post(this.storeURL, form)
                    .then((res) => {
                    if(res.data.saved) {
                    Flash.setSuccess(res.data.message)
                    this.$router.push(`/books/${res.data.id}`)
                }
                this.isProcessing = false
            })
            .catch((err) => {
                    if(err.response.status === 422) {
                    this.error = err.response.data
                }
                this.isProcessing = false
            })
            },
            remove(type, index) {
                if(this.form[type].length > 1) {
                    this.form[type].splice(index, 1)
                }
            }
        }

    }*/
</script>
<script type="text/javascript">
    import Vue from 'vue'
    import Flash from '../../helpers/flash'
    import { get, post } from '../../helpers/api'
    import { toMulipartedForm } from '../../helpers/form'
    import ImageUpload from '../../components/ImageUpload.vue'
    export default {
        components: {
            ImageUpload
        },
        data() {
            return {
                form: {
                    ingredients: [],
                    directions: []
                },
                error: {},
                isProcessing: false,
                initializeURL: `/api/books/create`,
                storeURL: `/api/books`,
                action: 'Create'
            }
        },
        created() {
            if(this.$route.meta.mode === 'edit') {
                this.initializeURL = `/api/books/${this.$route.params.id}/edit`
                this.storeURL = `/api/books/${this.$route.params.id}?_method=PUT`
                this.action = 'Update'
            }
            get(this.initializeURL)
                .then((res) => {
                Vue.set(this.$data, 'form', res.data.form)
        })
        },
        methods: {
            save() {
                const form = toMulipartedForm(this.form, this.$route.meta.mode)
                post(this.storeURL, form)
                    .then((res) => {
                    if(res.data.saved) {
                    Flash.setSuccess(res.data.message)
                    this.$router.push(`/books/${res.data.id}`)
                }
                this.isProcessing = false
            })
            .catch((err) => {
                    if(err.response.status === 422) {
                    this.error = err.response.data
                }
                this.isProcessing = false
            })
            },
            addDirection() {
                this.form.directions.push({
                    description: ''
                })
            },
            addIngredient() {
                this.form.ingredients.push({
                    name: '',
                    qty: ''
                })
            },
            remove(type, index) {
                if(this.form[type].length > 1) {
                    this.form[type].splice(index, 1)
                }
            }
        }
    }
</script>