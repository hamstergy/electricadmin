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
                <div class="form-group col-md-3">
                    <label for="make" class="label">Make</label>
                    <input v-model="fields.make" type="text" id="make" name="make" class="form-control" value="" placeholder="Make" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.make" class="text-danger">{{ errors.make[0] }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label for="model" class="label">Model</label>
                    <input v-model="fields.model" type="text" id="model" name="model" class="form-control" value="" placeholder="Model" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.model" class="text-danger">{{ errors.model[0] }}</div>
                </div>
                <div class="form-group col-md-1">
                    <label for="folding" class="label">Folding?</label>
                    <input v-model="fields.folding" class="form-control" name="folding" type="checkbox" value="" id="folding" >
                    <div v-if="errors && errors.folding" class="text-danger">{{ errors.folding[0] }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label for="url" class="label">URL</label>
                    <input v-model="fields.url" type="text" id="url" name="url" class="form-control" value="" placeholder="Amazon URL" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.url" class="text-danger">{{ errors.url[0] }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label for="price" class="label">Price</label>
                    <input v-model="fields.price" type="text" id="price" name="price" class="form-control" value="" placeholder="Price" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.price" class="text-danger">{{ errors.price[0] }}</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="speed" class="label">Top Speed</label>
                    <input v-model="fields.speed" type="text" id="speed" name="speed" class="form-control" value="" placeholder="Speed" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.speed" class="text-danger">{{ errors.speed[0] }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label for="range" class="label">Range</label>
                    <input v-model="fields.range" type="text" id="range" name="range" class="form-control" value="" placeholder="Range" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.range" class="text-danger">{{ errors.range[0] }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label for="battery" class="label">Battery</label>
                    <input v-model="fields.battery" type="text" id="battery" name="battery" class="form-control" value="" placeholder="Battery" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.battery" class="text-danger">{{ errors.battery[0] }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label for="motor" class="label">Motor</label>
                    <input v-model="fields.motor" type="text" id="motor" name="motor" class="form-control" value="" placeholder="Motor" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.motor" class="text-danger">{{ errors.motor[0] }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label for="gears" class="label">Gears</label>
                    <input v-model="fields.gears" type="text" id="gears" name="gears" class="form-control" value="" placeholder="Gears" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.gears" class="text-danger">{{ errors.gears[0] }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label for="tire" class="label">Tire</label>
                    <input v-model="fields.tire" type="text" id="tire" name="tire" class="form-control" value="" placeholder="Tire Size" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.tire" class="text-danger">{{ errors.tire[0] }}</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="type" class="label">Type</label>
                    <input v-model="fields.type" type="text" id="type" name="type" class="form-control" value="" placeholder="Type" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.type" class="text-danger">{{ errors.type[0] }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label for="weight" class="label">Weight</label>
                    <input v-model="fields.weight" type="text" id="weight" name="weight" class="form-control" value="" placeholder="Weight" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.weight" class="text-danger">{{ errors.weight[0] }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label for="break_system" class="label">Break System</label>
                    <input v-model="fields.break_system" type="text" id="break_system" name="break_system" class="form-control" value="" placeholder="Break System" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.break_system" class="text-danger">{{ errors.break_system[0] }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label for="frame_type" class="label">Frame Type</label>
                    <input v-model="fields.frame_type" type="text" id="frame_type" name="frame_type" class="form-control" value="" placeholder="Frame Type" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.frame_type" class="text-danger">{{ errors.frame_type[0] }}</div>
                </div>
                <div class="form-group col-md-4">
                    <label for="slug" class="label">Slug</label>
                    <input v-model="fields.slug" type="text" id="slug" name="slug" class="form-control" value="" placeholder="Slug" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.slug" class="text-danger">{{ errors.slug[0] }}</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="review_rate" class="label">Review Rate</label>
                    <input v-model="fields.review_rate" type="text" id="review_rate" name="review_rate" class="form-control" value="" placeholder="Review Rate" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.review_rate" class="text-danger">{{ errors.review_rate[0] }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label for="amazon_id" class="label">Amazon ID</label>
                    <input v-model="fields.amazon_id" type="text" id="amazon_id" name="amazon_id" class="form-control" value="" placeholder="Amazon ID" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.amazon_id" class="text-danger">{{ errors.amazon_id[0] }}</div>
                </div>
                <div class="form-group col-md-4">
                    <label for="youtube" class="label">Youtube Code</label>
                    <input v-model="fields.youtube" type="text" id="youtube" name="youtube" class="form-control" value="" placeholder="Youtube" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.youtube" class="text-danger">{{ errors.youtube[0] }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label for="imageSlug" class="label">Image Slug</label>
                    <input v-model="fields.imageSlug" @blur="fields.imageSlug = serializeSlug(fields.imageSlug)" type="text" id="imageSlug" name="imageSlug" class="form-control" value="" placeholder="Image Slug" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.imageSlug" class="text-danger">{{ errors.imageSlug[0] }}</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="title" class="label">Title</label>
                    <input v-model="fields.title" type="text" id="title" name="title" class="form-control" value="" placeholder="Title" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.title" class="text-danger">{{ errors.title[0] }}</div>
                </div>
                <div class="form-group col-md-12">
                    <label class="label">Description</label>
                    <div class="editor">
                        <quill-editor
                            :content="fields.description"
                            :options="editorOption"
                            @change="onEditorChange($event)"
                        />
                    </div>
                    <div v-if="errors && errors.description" class="text-danger">{{ errors.description[0] }}</div>
                </div>
            </div>
            <div class="form-row" v-if="!showUploadButton && onLoadPage">
                <div class="form-group col-md-3">
                    <img :src="'https://hamstercar.s3-us-west-2.amazonaws.com/bike-images/'+makeSlug()+'/'+fields.imageSlug+'-large.webp'"
                         class="image img-fluid">
                    <a class="btn btn-primary" v-if="!imageUploaded.large"
                       @click="toggleShow(1190,500,makeSlug(),fields.imageSlug,'large')">Upload Large Image</a>
                </div>
                <div class="form-group col-md-3">
                    <img :src="'https://hamstercar.s3-us-west-2.amazonaws.com/bike-images/'+makeSlug()+'/'+fields.imageSlug+'-medium.webp'"
                         class="image img-fluid">
                    <a class="btn btn-primary" v-if="!imageUploaded.medium"
                       @click="toggleShow(710,430,makeSlug(),fields.imageSlug,'medium')">Upload Medium Image</a>
                </div>
                <div class="form-group col-md-3">
                    <img :src="'https://hamstercar.s3-us-west-2.amazonaws.com/bike-images/'+makeSlug()+'/'+fields.imageSlug+'-small.webp'"
                         class="image img-fluid">
                    <a class="btn btn-primary" v-if="!imageUploaded.small"
                       @click="toggleShow(300,210,makeSlug(),fields.imageSlug,'small')">Upload Small Image</a>
                </div>
                <div class="form-group col-md-3">
                    <img :src="'https://hamstercar.s3-us-west-2.amazonaws.com/bike-images/'+makeSlug()+'/'+fields.imageSlug+'-mobile.webp'"
                         class="image img-fluid">
                    <a class="btn btn-primary" v-if="!imageUploaded.mobile"
                       @click="toggleShow(580,400,makeSlug(),fields.imageSlug,'mobile')">Upload Mobile Image</a>
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
                           url="/electric-image/store-bike"
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
                <span v-for="(error, id) in errors" :key="id">{{error}}</span>
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
    import 'quill/dist/quill.core.css'
    import 'quill/dist/quill.snow.css'
    import 'quill/dist/quill.bubble.css'
    import { quillEditor, Quill } from 'vue-quill-editor'
    import {container, ImageExtend, QuillWatch} from 'quill-image-extend-module'
    import myUpload from 'vue-image-crop-upload'

    Quill.register('modules/ImageExtend', ImageExtend)

    export default {
        components: {myUpload, quillEditor},
        props: ['data'],
        name: 'bikeCreate',
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
                onLoadPage: true,
                editorOption: {
                    theme: 'snow',
                    modules: {
                        ImageExtend: {
                            loading: true,
                            name: 'img',
                            action: "/image/store-bike-content",
                            response: (res) => {
                                return res.img;
                            },
                            headers: (xhr) => {
                                xhr.setRequestHeader('X-CSRF-TOKEN',document.querySelector('meta[name="csrf-token"]').getAttribute('content'))
                            },
                        },
                        toolbar: {
                            container: container,
                            handlers: {
                                'image': function () {
                                    QuillWatch.emit(this.quill.id)
                                }
                            }
                        }
                    }
                }
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
                    return this.fields.make.toLowerCase().replaceAll(" ", "-")
                }
            },
            serializeSlug(slug) {
                return slug.toLowerCase().replaceAll(" ", "-");
            },
            toggleShow(width,height,make,model,type) {
                if (this.fields.imageSlug) {
                    this.params.type = type;
                    this.params.make = make;
                    this.params.model = model;
                    this.sizes.height = height;
                    this.sizes.width = width;
                    this.imageUploaded[type] = true;
                    this.show = !this.show;
                } else {
                    const imageSlug = ["Fill in this field"]
                    this.errors = {...this.errors, imageSlug: imageSlug}
                    console.log(this.errors);
                }
            },
            submit() {
                this.errors = {};
                this.isLoading = true;
                axios.post('/bikes/create', this.fields).then(response => {
                    this.isLoading = false;
                    console.log(response);
                    window.location.href = "/bikes/"+response.data[0].id+"/edit";
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
            },
            onEditorChange({ quill, html, text }) {
                this.fields.description = html
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
    .editor {
        background-color: white;
    }

</style>
