<template>
    <div class="row">
        <div class="col-md-8 mb-3">
            <div class="d-flex justify-content-between">
                <h4 class="my-auto">
                    {{ !id ? 'Create' : 'Update' }} blog
                </h4>
                <div>
                    <router-link class="me-2 btn btn-primary" to="/blog/create">New Blog</router-link>
                    <router-link class="me-2 btn btn-info" v-if="id" :to="`/blog/${id}/show`">View</router-link>
                    <router-link class="me-2 btn btn-success" to="/blog">Blog List</router-link>
                </div>
            </div>
            <hr/>

            <form @submit.prevent="createBlog()">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" v-model="blog.name" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select v-model="blog.category_id" class="form-control">
                        <option :value="category.id" v-for="category in categories">
                            {{ category.title }}
                        </option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Body</label>
                    <ckeditor
                        :editor="editor"
                        v-model="blog.body"
                        :config="editorConfig"
                    ></ckeditor>
                </div>
                <div class="mb-3">
                    <label class="form-label">
                        Banner
                        <a v-if="id" target="_blank" :href="blog.old_banner"><small>View old</small></a>
                    </label>
                    <input type="file" @change="processImage($event)" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tag</label>
                    <input type="text" v-model="blog.tag" placeholder="please comma(,) to seperate tags"
                           class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">
                    {{ id ? 'Update' : 'Submit' }}
                </button>
            </form>
        </div>
    </div>
</template>

<script>
import CKEditor      from '@ckeditor/ckeditor5-vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import _             from "lodash";

export default {
    name      : "Create",
    components: {
        // Use the <ckeditor> component in this view.
        ckeditor: CKEditor.component
    },
    data() {
        return {
            id          : '',
            categories  : [],
            blog        : {
                body       : '',
                name       : '',
                category_id: '',
            },
            maxSize     : 1024 * 1024 * 2,

            editor      : ClassicEditor,
            editorConfig: {
                toolbar    : [
                    'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'insertTable', '|',
                    'imageUpload', 'mediaEmbed', '|', 'undo', 'redo'
                ],
                table      : {
                    toolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                },
                extraPlugin: [],
                language   : 'en',
            },
        };
    },
    mounted() {
        this.getCategories();

        if (this.$route?.params?.id) {
            this.id = this.$route.params.id;
            this.getBlog();
        }
    },
    methods: {
        getBlog() {
            axios.get(`/api/blog/${this.id}`)
                .then(({data}) => {
                    this.blog = _.pick(data, [
                        'body', 'name', 'category_id', 'banner', 'old_banner', 'id', 'tag',
                    ]);
                })
                .catch((error) => {
                    toastr.error(error.message)
                })
        },
        processImage(event) {
            let file         = event.target.files[0];
            this.blog.banner = '';
            if (file && file.size <= this.maxSize) {
                this.getBase64(file, (base64Data) => {
                    // Here you can have your code which uses Base64 for its operation, // file to Base64 by oneshubh
                    this.blog.banner = base64Data;
                });
            } else if (file && file.size > this.maxSize) {
                alert(`Max file size is 2MB`);
            }
        },
        getBase64(file, callback) {
            const reader = new FileReader();
            reader.addEventListener('load', () => callback(reader.result));
            reader.readAsDataURL(file);
        },
        getCategories() {
            axios.get('/api/category')
                .then((response) => {
                    this.categories = response.data;
                })
                .catch((error) => {
                    toastr.error(error.message)
                });
        },
        createBlog() {
            let url = `/api/blog${this.id ? '/' + this.id : ''}`;

            axios[this.id ? 'put' : 'post'](url, this.blog)
                .then((response) => {
                    if (response.data) {
                        toastr.success('Created')
                        this.$router.push('/blog')
                    }
                })
                .finally(() => {
                })
                .catch((error) => {
                    toastr.error(error.message)
                })
        }
    }
}
</script>

<style>
.ck-editor__editable {
    min-height: 300px;
}
</style>
