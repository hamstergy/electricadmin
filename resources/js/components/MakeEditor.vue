<template>
    <div>
        <div class="d-flex justify-content-center"
             v-if="isLoading"
             style="position: fixed;
                    top: 50%;
                    left: 0;
                    z-index: 1040;
                    width: 100vw;
                    height: 100vh;">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <form>
            <div class="form-group">
                <label for="name" class="label">Name</label>
                <input v-model="fields.name" type="text" id="name" name="name" class="form-control" value="" placeholder="Name" minlength="2" maxlength="100" required />
                <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
            </div>

            <div class="alert alert-danger" role="alert" v-if="errors && errors.backend">
                <span v-for="error in errors">{{error}}</span>
            </div>
            <button class="btn btn-primary" type="button" @click="submit()" :disabled="isLoading">
                <span v-if="isLoading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                <span v-if="isLoading">Loading...</span>
                <span v-if="!isLoading">Save</span>
            </button>
        </form>
        <div class="modal-backdrop fade show" v-if="isLoading"></div>
    </div>
</template>

<script>

    export default {
        props: ['data'],
        name: 'makeEditor',
        data() {
            return {
                fields: this.data,
                errors: [],
                isLoading: false,
                show: false
            }
        },
        methods: {
            toggleShow() {
                this.show = !this.show;
            },
            submit() {
                this.errors = {};
                this.isLoading = true;
                axios.post('/makes/create', this.fields).then(response => {
                    this.isLoading = false;
                }).catch( error => {
                    if (error.response.status === 422) {
                        this.isLoading = false;
                        this.errors = error.response.data.errors || [];
                    } else {
                        this.isLoading = false;
                        this.errors['backend'] = error.response.data.message || [];
                    }
                });
            },

        }
    }


</script>

<style scoped>
    .overlay {
        position: absolute;
        cursor:pointer;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        height: 100%;
        width: 100%;
        opacity: 0;
        transition: .5s ease;
        background-color: #1b1e21;
    }
    .text {
        color: white;
        cursor:pointer;
        font-size: 20px;
        position: absolute;
        top: 50%;
        left: 50%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        text-align: center;
    }

</style>
