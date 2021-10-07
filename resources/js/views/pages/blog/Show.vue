<template>
    <div class="row">
        <div class="col-md-8 mb-3">
            <div class="card mb-3">
                <img :src="blog.banner" class="card-img-top" :alt="blog.name">
                <div class="card-body">
                    <h5 class="card-title">{{ blog.name }}</h5>
                    <p class="card-text" v-html="blog.body"></p>
                    <p class="card-text"><small class="text-muted">Last updated {{ blog.updated_at_humans }}</small></p>
                </div>
            </div>

            <hr/>

            <form @submit.prevent="sendComment($event)" class="mb-3">
                <div class="mb-3">
                    <label class="form-label">Comment</label>
                    <textarea data-comment="comment" v-model="aComment" rows="5" class="form-control"></textarea>
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
                            <small class="d-block">- 20 October, 2018</small>
                        </div>
                    </div>
                    <br>
                    <p>
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
                                <small class="d-block">- 20 October, 2018</small>
                            </div>
                        </div>
                        <br>
                        <p>
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
                                <input data-comment="comment" class="form-control me-2"/>
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
export default {
    name: "Show",
    data() {
        return {
            blog    : {},
            aComment: '',
            aReply  : '',
        }
    },
    mounted() {
        this.getBlog()
    },
    methods: {
        getBlog() {
            axios.get(`/api/blog/${this.$route.params.id}`).then((response) => {
                this.blog = response.data;
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

            axios.post(`/api/comment`, param).then((response) => {
                index !== -1
                ? this.blog.comments[index].children.push(response.data)
                : this.blog.comments.unshift(response.data);

                target.value  = '';
                this.aComment = '';
            })
        },
    }
}
</script>

<style scoped>

</style>
