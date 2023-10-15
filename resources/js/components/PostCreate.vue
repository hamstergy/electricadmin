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
                <div class="form-group col-md-12">
                    <label for="title" class="label">Title</label>
                    <input v-model="fields.title" type="text" id="title" name="title" class="form-control" value="" placeholder="Title" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.title" class="text-danger">{{ errors.title[0] }}</div>
                </div>
                <div class="form-group col-md-12">
                    <label class="label">Body</label>
                    <div class="editor">
                        <quill-editor
                            :content="fields.body"
                            :options="editorOption"
                            @change="onEditorChange($event)"
                        />
                    </div>
                    <div v-if="errors && errors.body" class="text-danger">{{ errors.body[0] }}</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="date" class="label">Date</label>
                    <input v-model="fields.date" type="text" id="date" name="date" class="form-control" value="" placeholder="Date" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.date" class="text-danger">{{ errors.date[0] }}</div>
                </div>
                <div class="form-group col-md-4">
                    <label for="tags" class="label">Tags</label>
                    <input v-model="fields.tags" type="text" id="tags" name="tags" class="form-control" value="" placeholder="Tags" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.tags" class="text-danger">{{ errors.tags[0] }}</div>
                </div>
                <div class="form-group col-md-4">
                    <label for="slug" class="label">Slug</label>
                    <input v-model="fields.slug" @blur="fields.slug = serializeSlug(fields.slug)" type="text" id="slug" name="slug" class="form-control" value="" placeholder="Slug" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.slug" class="text-danger">{{ errors.slug[0] }}</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="short_description" class="label">SEO Description</label>
                    <textarea v-model="fields.short_description" id="short_description" name="short_description" class="form-control" value="" placeholder="SEO Desciption" rows="3" maxlength="170" required></textarea>
                    <div v-if="errors && errors.title" class="text-danger">{{ errors.short_description[0] }}</div>
                </div>
            </div>
            <div class="form-row" v-if="!showUploadButton && onLoadPage">
                <div class="form-group col-md-3">
                    <img :src="'https://hamstercar.s3-us-west-2.amazonaws.com/post-images/'+fields.slug+'-medium.webp'"
                         class="image img-fluid">
                    <a class="btn btn-primary" v-if="!imageUploaded.medium"
                       @click="toggleShow(710,430,fields.slug,'medium')">Upload Medium Image</a>
                </div>
                <div class="form-group col-md-3">
                    <img :src="'https://hamstercar.s3-us-west-2.amazonaws.com/post-images/'+fields.slug+'-mobile.webp'"
                         class="image img-fluid">
                    <a class="btn btn-primary" v-if="!imageUploaded.mobile"
                       @click="toggleShow(580,400,fields.slug,'mobile')">Upload Mobile Image</a>
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
                           url="/electric-image/store-post"
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
        name: 'postCreate',
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
                            action: "/image/store-post-content",
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
            serializeSlug(slug) {
                return slug.toLowerCase().replaceAll(" ", "-");
            },
            toggleShow(width,height,slug,type) {
                if (this.fields.slug) {
                    this.params.type = type;
                    this.params.slug = slug;
                    this.sizes.height = height;
                    this.sizes.width = width;
                    this.imageUploaded[type] = true;
                    this.show = !this.show;
                } else {
                    const slug = ["Fill in this field"]
                    this.errors = {...this.errors, slug: slug}
                    console.log(this.errors);
                }
            },
            submit() {
                this.errors = {};
                this.isLoading = true;
                axios.post('/posts/create', this.fields).then(response => {
                    this.isLoading = false;
                    console.log(response);
                    window.location.href = "/posts/"+response.data[0].id+"/edit";
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
                this.fields.body = html
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
