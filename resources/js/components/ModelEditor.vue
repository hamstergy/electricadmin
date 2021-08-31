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
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="name" class="label">Name</label>
                    <input v-model="fields.name" type="text" id="name" name="name" class="form-control" value="" placeholder="Name" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
                </div>
                <div class="form-group col-md-4">
                    <label for="class" class="label">Class</label>
                    <select id="class" class="form-control" v-model="fields.class">
                        <option v-for="className in classNames" :value="className">{{className}}</option>
                    </select>
                    <div v-if="errors && errors.class" class="text-danger">{{ errors.class[0] }}</div>
                </div>
                <div class="form-group col-md-4">
                    <label for="make" class="label">Make</label>
                    <!--<input v-model="fields.vehicle_make_id" type="text" id="make" name="make" class="form-control" value="" placeholder="Make" minlength="2" maxlength="100" required />-->
                    <select id="make" class="form-control" v-model="fields.vehicle_make_id">
                        <option v-for="make in makes" :value="make.id">{{make.name}}</option>
                    </select>
                    <div v-if="errors && errors.vehicle_make_id" class="text-danger">{{ errors.vehicle_make_id[0] }}</div>
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="label">Description</label>
                <textarea v-model="fields.description" type="text" id="description" name="description" class="form-control" value="" placeholder="Description" minlength="2" required></textarea>
                <div v-if="errors && errors.description" class="text-danger">{{ errors.description[0] }}</div>
            </div>
            <div class="form-group">
                <label for="detail" class="label">Detail</label>
                <textarea v-model="fields.detail" type="text" id="detail" name="detail" class="form-control" value="" placeholder="Detail" minlength="2" required></textarea>
                <div v-if="errors && errors.detail" class="text-danger">{{ errors.detail[0] }}</div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="price" class="label">Price</label>
                    <input v-model="fields.price" type="text" id="price" name="price" class="form-control" value="" placeholder="Price" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.price" class="text-danger">{{ errors.price[0] }}</div>
                </div>
                <div class="form-group col-md-4">
                    <label for="lease" class="label">Lease</label>
                    <input v-model="fields.lease" type="text" id="lease" name="lease" class="form-control" value="" placeholder="Lease" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.lease" class="text-danger">{{ errors.lease[0] }}</div>
                </div>
                <div class="form-group col-md-4">
                    <label for="finance" class="label">Finance</label>
                    <input v-model="fields.finance" type="text" id="finance" name="finance" class="form-control" value="" placeholder="Finance" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.finance" class="text-danger">{{ errors.finance[0] }}</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="image" class="label">Image</label>
                    <input v-model="fields.image" type="text" id="image" name="image" class="form-control" value="" placeholder="Image" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.image" class="text-danger">{{ errors.image[0] }}</div>
                </div>
                <div class="form-group col-md-6">
                    <label for="video" class="label">Video</label>
                    <input v-model="fields.video" type="text" id="video" name="video" class="form-control" value="" placeholder="Video" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.video" class="text-danger">{{ errors.video[0] }}</div>
                </div>
            </div>

            <div class="form-row" v-if="!showUploadButton && onLoadPage">
                <div class="form-group col-md-3">
                    <img :src="'https://hamstercar.s3-us-west-2.amazonaws.com/images/'+makeSlug(fields.vehicle_make_id)+'/'+makeSlug(fields.vehicle_make_id)+'-'+fields.slug+'-large.jpg'"
                         class="image img-fluid">
                    <a class="btn btn-primary" v-if="!imageUploaded.large"
                       @click="toggleShow(1190,500,makeSlug(fields.vehicle_make_id),fields.slug,'large')">Upload Large Image</a>
                </div>
                <div class="form-group col-md-3">
                    <img :src="'https://hamstercar.s3-us-west-2.amazonaws.com/images/'+makeSlug(fields.vehicle_make_id)+'/'+makeSlug(fields.vehicle_make_id)+'-'+fields.slug+'-medium.jpg'"
                         class="image img-fluid">
                    <a class="btn btn-primary" v-if="!imageUploaded.medium"
                       @click="toggleShow(920,375,makeSlug(fields.vehicle_make_id),fields.slug,'medium')">Upload Medium Image</a>
                </div>
                <div class="form-group col-md-3">
                    <img :src="'https://hamstercar.s3-us-west-2.amazonaws.com/images/'+makeSlug(fields.vehicle_make_id)+'/'+makeSlug(fields.vehicle_make_id)+'-'+fields.slug+'-small.jpg'"
                         class="image img-fluid">
                    <a class="btn btn-primary" v-if="!imageUploaded.small"
                       @click="toggleShow(300,210,makeSlug(fields.vehicle_make_id),fields.slug,'small')">Upload Small Image</a>
                </div>
                <div class="form-group col-md-3">
                    <img :src="'https://hamstercar.s3-us-west-2.amazonaws.com/images/'+makeSlug(fields.vehicle_make_id)+'/'+makeSlug(fields.vehicle_make_id)+'-'+fields.slug+'-mobile.jpg'"
                         class="image img-fluid">
                    <a class="btn btn-primary" v-if="!imageUploaded.mobile"
                       @click="toggleShow(580,400,makeSlug(fields.vehicle_make_id),fields.slug,'mobile')">Upload Mobile Image</a>
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
                           url="/image/store"
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
        name: 'modelEditor',
        data() {
            return {
                fields: this.data,
                errors: [],
                isLoading: false,
                show: false,
                makes: [],
                classNames: [
                    'sedan',
                    'suv',
                    'crossover',
                    'truck',
                    'coupe',
                    'convertible',
                    'hatchback',
                    'van',
                    'wagon'
                ],
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
                onLoadPage: false
            }
        },
        beforeCreate() {
            axios.get('/api/makes/allMakes').then(response => {
                this.makes = response.data.makes;
                this.onLoadPage = true;
            }).catch( error => {
               console.log(error);
            });

        },
        created() {
            if (Object.keys(this.fields).length !== 0) {
                this.showUploadButton = false;
            }
        },
        methods: {
            makeSlug(id) {
                if(this.onLoadPage) {
                    return this.makes.find(el => el.id == id).name.toLowerCase();
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
