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
                    <input v-model="fields.make" @blur="fields.make = fields.make.trim()" type="text" id="make" name="make" class="form-control" value="" placeholder="Make" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.make" class="text-danger">{{ errors.make[0] }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label for="model" class="label">Model</label>
                    <input v-model="fields.model" @blur="fields.model = fields.model.trim()" type="text" id="model" name="model" class="form-control" value="" placeholder="Model" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.model" class="text-danger">{{ errors.model[0] }}</div>
                </div>
                <div class="form-group col-md-1">
                    <label for="isConcept" class="label">Concept?</label>
                    <input v-model="fields.isConcept" class="form-control" name="isConcept" type="checkbox" value="" id="isConcept" >
                    <div v-if="errors && errors.isConcept" class="text-danger">{{ errors.isConcept[0] }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label for="releaseDate" class="label">Release Date</label>
                    <input v-model="fields.releaseDate" type="text" id="releaseDate" name="releaseDate" class="form-control" value="" placeholder="Release Date" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.releaseDate" class="text-danger">{{ errors.releaseDate[0] }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label for="price" class="label">Price ($)</label>
                    <input v-model="fields.price" type="text" id="price" name="price" class="form-control" value="" placeholder="Price" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.price" class="text-danger">{{ errors.price[0] }}</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="acceleration" class="label">Acceleration (sec)</label>
                    <input v-model="fields.acceleration" type="text" id="acceleration" name="acceleration" class="form-control" value="" placeholder="Acceleration" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.acceleration" class="text-danger">{{ errors.acceleration[0] }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label for="speed" class="label">Top Speed (km/h)</label>
                    <input v-model="fields.speed" type="text" id="speed" name="speed" class="form-control" value="" placeholder="Speed" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.speed" class="text-danger">{{ errors.speed[0] }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label for="range" class="label">Range (km)</label>
                    <input v-model="fields.range" type="text" id="range" name="range" class="form-control" value="" placeholder="Range" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.range" class="text-danger">{{ errors.range[0] }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label for="efficiency" class="label">Efficiency (Wh/km)</label>
                    <input v-model="fields.efficiency" type="text" id="efficiency" name="efficiency" class="form-control" value="" placeholder="Efficiency" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.efficiency" class="text-danger">{{ errors.efficiency[0] }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label for="chargeSpeed" class="label">Charge Speed (km/h)</label>
                    <input v-model="fields.chargeSpeed" type="text" id="chargeSpeed" name="chargeSpeed" class="form-control" value="" placeholder="Charge Speed" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.chargeSpeed" class="text-danger">{{ errors.chargeSpeed[0] }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label for="battery" class="label">Battery (kWh)</label>
                    <input v-model="fields.battery" type="text" id="battery" name="battery" class="form-control" value="" placeholder="Battery" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.battery" class="text-danger">{{ errors.battery[0] }}</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="drive" class="label">Drive</label>
                    <select v-model="fields.drive" class="form-control">
                        <option value="">N/A</option>
                        <option v-for="d in drive" :key=d.value :value=d.value>{{d.name}}</option>
                    </select>
                    <div v-if="errors && errors.drive" class="text-danger">{{ errors.drive[0] }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label for="type" class="label">Type</label>
                    <select v-model="fields.type" class="form-control">
                        <option value="">N/A</option>
                        <option v-for="t in types" :key=t.value :value=t.value>{{t.name}}</option>
                    </select>
                    <div v-if="errors && errors.type" class="text-danger">{{ errors.type[0] }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label for="segment" class="label">Segment</label>
                    <select v-model="fields.segment" class="form-control">
                        <option value="">N/A</option>
                        <option v-for="segment in segments" :key=segment.value :value=segment.value>{{segment.name}}</option>
                    </select>
                    <div v-if="errors && errors.segment" class="text-danger">{{ errors.segment[0] }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label for="seats" class="label">Seats</label>
                    <input v-model="fields.seats" type="text" id="seats" name="seats" class="form-control" value="" placeholder="Seats" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.seats" class="text-danger">{{ errors.seats[0] }}</div>
                </div>
                <div class="form-group col-md-4">
                    <label for="slug" class="label">Slug</label>
                    <input v-model="fields.slug" type="text" id="slug" name="slug" class="form-control" value="" placeholder="Slug" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.slug" class="text-danger">{{ errors.slug[0] }}</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="youtube" class="label">Youtube Code (format: 5KZzCo9_zsg)</label>
                    <input v-model="fields.youtube" type="text" id="youtube" name="youtube" class="form-control" value="" placeholder="Youtube" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.youtube" class="text-danger">{{ errors.youtube[0] }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label for="imageSlug" class="label">Image Slug</label>
                    <input v-model="fields.imageSlug" @blur="fields.imageSlug = fields.imageSlug.toLowerCase()" type="text" id="imageSlug" name="imageSlug" class="form-control" value="" placeholder="Image Slug" minlength="2" maxlength="100" required />
                    <div v-if="errors && errors.imageSlug" class="text-danger">{{ errors.imageSlug[0] }}</div>
                </div>
            </div>
            <div class="form-row">
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
                <div class="form-group col-md-4">
                    <img :src="'https://hamstercar.s3-us-west-2.amazonaws.com/images/'+makeSlug()+'/'+fields.imageSlug+'-large.webp'"
                         class="image img-fluid">
                    <a class="btn btn-primary" v-if="!imageUploaded.large"
                       @click="toggleShow(1190,500,makeSlug(),fields.imageSlug,'large')">Upload Large Image</a>
                </div>
                <div class="form-group col-md-4">
                    <img :src="'https://hamstercar.s3-us-west-2.amazonaws.com/images/'+makeSlug()+'/'+fields.imageSlug+'-medium.webp'"
                         class="image img-fluid">
                    <a class="btn btn-primary" v-if="!imageUploaded.medium"
                       @click="toggleShow(920,375,makeSlug(),fields.imageSlug,'medium')">Upload Medium Image</a>
                </div>
                <div class="form-group col-md-3">
                    <img :src="'https://hamstercar.s3-us-west-2.amazonaws.com/images/'+makeSlug()+'/'+fields.imageSlug+'-mobile.webp'"
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
    import { quillEditor } from 'vue-quill-editor'
    import myUpload from 'vue-image-crop-upload'
    export default {
        components: {myUpload, quillEditor},
        props: ['data'],
        name: 'electricCreate',
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
                segments: [
                    {name: 'A - Mini', value: 'A'},
                    {name: 'B - Small', value: 'B'},
                    {name: 'C - Medium', value: 'C'},
                    {name: 'D - Large', value: 'D'},
                    {name: 'E - Executive', value: 'E'},
                    {name: 'F - Luxury', value: 'F'},
                    {name: 'N - Commercial', value: 'N'},
                    {name: 'S - Sports', value: 'S'}
                ],
                types: [
                    {name: 'Hatchback', value: 'hatchback'},
                    {name: 'Sedan', value: 'sedan'},
                    {name: 'SUV', value: 'suv'},
                    {name: 'Wagon', value: 'wagon'},
                    {name: 'Convertible', value: 'convertible'},
                    {name: 'Truck', value: 'truck'},
                    {name: 'Liftback', value: 'liftback'},
                    {name: 'Coupe', value: 'coupe'},
                    {name: 'VAN', value: 'van'},
                    {name: 'Crossover', value: 'crossover'}
                ],
                drive: [
                    {name: 'Front', value: 'front'},
                    {name: 'Rear', value: 'rear'},
                    {name: 'AWD', value: 'awd'}
                ],
                showUploadButton: true,
                imgDataUrl: '',
                onLoadPage: true,
                editorOption: {
                    theme: 'snow'
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
                axios.post('/electric/create', this.fields).then(response => {
                    this.isLoading = false;
                    console.log(response);
                    window.location.href = "/electric/"+response.data[0].id+"/edit";
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
