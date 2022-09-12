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
        <div class="row p-4">
            <h2>Sample</h2>
            <img :src="this.fields.image" alt="">
        </div>
        <form>

            <div class="form-row" v-if="!showUploadButton && onLoadPage">
                <div class="form-group col-md-4">
                    <img :src="'https://hamstercar.s3-us-west-2.amazonaws.com/images/'+makeSlug()+'/'+fields.slug+'-large.webp'"
                         class="image img-fluid">
                    <a class="btn btn-primary" v-if="!imageUploaded.large"
                       @click="toggleShow(1190,500,makeSlug(),fields.slug,'large')">Upload Large Image</a>
                </div>
                <div class="form-group col-md-4">
                    <img :src="'https://hamstercar.s3-us-west-2.amazonaws.com/images/'+makeSlug()+'/'+fields.slug+'-medium.webp'"
                         class="image img-fluid">
                    <a class="btn btn-primary" v-if="!imageUploaded.medium"
                       @click="toggleShow(920,375,makeSlug(),fields.slug,'medium')">Upload Medium Image</a>
                </div>
                <div class="form-group col-md-3">
                    <img :src="'https://hamstercar.s3-us-west-2.amazonaws.com/images/'+makeSlug()+'/'+fields.slug+'-mobile.webp'"
                         class="image img-fluid">
                    <a class="btn btn-primary" v-if="!imageUploaded.mobile"
                       @click="toggleShow(580,400,makeSlug(),fields.slug,'mobile')">Upload Mobile Image</a>
                </div>
                <my-upload field="img" v-if="show"
                           @crop-success="cropSuccess"
                           @crop-upload-success="cropUploadSuccess"
                           @crop-upload-fail="cropUploadFail"
                           v-model="show"
                           :width="sizes.width"
                           lang-type="en"
                           :height="sizes.height"
                           :no-square="preview"
                           :no-circle="preview"
                           url="/electric-image/store"
                           :params="params"
                           :headers="headers"
                           img-format="jpg"></my-upload>
                <!--<div class="image-upload" v-if="!showUploadButton">-->
                    <!--<img :src="fields.image" class="image">-->
                    <!--<div class="overlay">-->
                        <!--<div class="text">Delete</div>-->
                    <!--</div>-->
                <!--</div>-->
                <div v-if="errors && errors.picture" class="text-danger">{{ errors.picture[0] }}</div>
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
    import myUpload from 'vue-image-crop-upload'
    export default {
        components: {myUpload},
        props: ['data'],
        name: 'electricEditor',
        data() {
            return {
                fields: this.data,
                errors: [],
                isLoading: false,
                show: false,
                preview: true,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                sizes: {
                    width: 700,
                    height: 400
                },
                imageUploaded: {
                    large: false,
                    medium: false,
                    small: false,
                    mobile: false
                },
                params: {
                    'type' : 'large',
                    'make' : 'bmw',
                    'model': 'x6'
                },
                showUploadButton: true,
                imgDataUrl: '',
                onLoadPage: true
            }
        },

        created() {
            if (Object.keys(this.fields).length !== 0) {
                this.showUploadButton = false;
            }
        },
        methods: {
            makeSlug() {
                if(this.onLoadPage) {
                    // return this.makes.find(el => el.id == id).name.toLowerCase();
                    return this.fields.make.toLowerCase().replace(" ", "-")
                }
            },
            toggleShow(width,height,make,model,type) {
                this.params.type = type;
                this.params.make = make;
                this.params.model = model;
                this.sizes.height = height;
                this.sizes.width = width;
                this.imageUploaded[type] = true;
                this.show = !this.show;
            },
            submit() {
                this.errors = {};
                this.isLoading = true;
                axios.post('/models/create', this.fields).then(response => {
                    this.isLoading = false;
                    console.log(response);
                    window.location.href = "/models/"+response.data[0].id+"/edit";
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
            // deleteImage() {
            //     if (this.imageName == '') {
            //         this.imageName = this.fields.picture.match(/.*\/(.*)$/)[1];
            //     }
            //     axios.post('/image/delete', { data: this.imageName }, {
            //         headers: this.headers } ).then(response => {
            //         console.log(response);
            //         if (response.data == true) {
            //             this.fields.image = "";
            //             this.imageName = "";
            //             this.showUploadButton = true;
            //         }
            //     }).catch( error => {
            //         console.log(error);
            //     })
            // },
            cropSuccess(imgDataUrl, field){
                console.log('-------- crop success --------');

            },
            cropUploadSuccess(jsonData, field){
                console.log('-------- upload success --------');
                // this.showUploadButton = false;
                this.fields.image = 'https://hamstercar.s3-us-west-2.amazonaws.com/' + jsonData[0];
            },
            cropUploadFail(status, field){
                console.log('-------- upload fail --------');
                console.log(status);
            }

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
