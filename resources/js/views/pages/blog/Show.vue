<template>
    <div class="row">
        <div class="col-md-8 mb-3">
            <div class="d-flex justify-content-between">
                <h4 class="my-auto">
                    View blog
                </h4>
                <div>
                    <router-link class="me-2 btn btn-primary" to="/blog/create">New Blog</router-link>
                    <router-link class="me-2 btn btn-warning" :to="`/blog/${blog.id}/edit`">Edit</router-link>
                    <router-link class="me-2 btn btn-success" to="/blog">Blog List</router-link>
                </div>
            </div>
            <hr/>

            <div class="card mb-3">
                <img :src="blog.banner" class="card-img-top" :alt="blog.name">
                <div class="card-body ckeditor-view p-0">
                    <h3 class="card-title py-3 px-3 bg-light mb-0" :title="blog.slug">{{ blog.name }}</h3>
                    <div class="d-none">
                        <h5 class="card-title" :title="blog.slug">{{ blog.name }}</h5>
                        <p class="card-text" v-html="blog.body"></p>
                        <p class="card-text">
                            <small class="text-muted">Last updated {{ blog.updated_at_humans }}</small>
                        </p>
                    </div>
                    <ckeditor
                        :disabled="true"
                        :editor="editor"
                        v-model="blog.body"
                        :config="editorConfig"
                    ></ckeditor>
                    <div class="px-3 py-3 bg-light">
                        <div><strong>Last updated:</strong> {{ blog.updated_at_humans }}</div>
                        <div><strong>Category:</strong> {{ blog?.category?.title }}</div>
                        <div><strong>Slug:</strong> {{ blog.slug }}</div>
                        <div><strong>Tags:</strong> {{ blog.tag }}</div>
                    </div>
                </div>
            </div>

            <hr/>

            <form @submit.prevent="sendComment($event)" class="mb-3">
                <div class="mb-3">
                    <label class="form-label">Comment</label>
                    <textarea data-comment="comment" v-model="aComment" rows="5"
                              placeholder="Write a comment..."
                              class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Comment</button>
            </form>
        </div>


        <div class="col-md-8 mb-4">
            <h1>Comments</h1>
            <div v-if="blog.comments && blog.comments.length"
                 class="comment mt-4 text-justify float-left mt-4"
                 v-for="(comment, indexComment) in blog.comments">
                <div>
                    <div class="d-flex">
                        <img alt="" class="rounded-circle me-2" width="45" height="45"
                             src="https://w7.pngwing.com/pngs/627/693/png-transparent-computer-icons-user-user-icon-thumbnail.png">
                        <div>
                            <strong class="d-block">Jhon Doe</strong>
                            <small class="d-block text-muted">{{ comment.created_at_formatted }}</small>
                        </div>
                    </div>
                    <br>
                    <p class="bg-light px-3 py-2 rounded">
                        {{
                        comment.comment
                        }}
                    </p>
                </div>

                <div class="ms-5">
                    <div v-if="comment.children.length" v-for="(children, indexReply) in comment.children">
                        <div class="d-flex">
                            <img alt="" class="rounded-circle me-2" width="45" height="45"
                                 src="https://w7.pngwing.com/pngs/627/693/png-transparent-computer-icons-user-user-icon-thumbnail.png">
                            <div>
                                <strong class="d-block">Jhon Doe</strong>
                                <small class="d-block text-muted">{{ children.created_at_formatted }}</small>
                            </div>
                        </div>
                        <br>
                        <p class="bg-light px-3 py-2 rounded">
                            {{
                            children.comment
                            }}
                        </p>
                    </div>

                    <form @submit.prevent="sendComment($event, comment.id, indexComment)" class="mb-3">
                        <hr/>
                        <div class="mb-3">
                            <label class="form-label">
                                <strong>Write a reply</strong>
                            </label>
                            <div class="form-group d-flex">
                                <input placeholder="Reply" data-comment="comment" class="form-control me-2"/>
                                <button type="submit" class="btn btn-primary">Reply</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div v-else>
                <div class="alert alert-secondary text-center">No comment found</div>
            </div>
        </div>
    </div>
</template>

<script>
import CKEditor      from '@ckeditor/ckeditor5-vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

export default {
    name      : "Show",
    components: {
        // Use the <ckeditor> component in this view.
        ckeditor: CKEditor.component
    },
    data() {
        return {
            blog    : {},
            aComment: '',
            aReply  : '',

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
        }
    },
    mounted() {
        this.getBlog()
    },
    methods: {
        getBlog() {
            axios.get(`/api/blog/${this.$route.params.id}`)
                .then((response) => {
                    this.blog = response.data;
                })
                .catch((error) => {
                    toastr.error(error.message)
                })
        },
        sendComment(event, parent_id = null, index = -1) {
            let target  = event.target.querySelector('[data-comment="comment"]');
            let comment = target.value;
            let param   = {
                comment,
                parent_id,
                blog_id: this.blog.id,
            };

            axios.post(`/api/comment`, param)
                .then((response) => {
                    index !== -1
                    ? this.blog.comments[index].children.push(response.data)
                    : this.blog.comments.unshift(response.data);

                    target.value  = '';
                    this.aComment = '';

                    if (response.data) {
                        toastr.success(index !== -1 ? 'Replied' : 'Commented')
                    }
                })
                .finally(() => {
                })
                .catch((error) => {
                    toastr.error(error.message)
                })
        },
    }
}
</script>

<style>
.ckeditor-view .ck.ck-sticky-panel__content {
    display: none;
}
</style>
