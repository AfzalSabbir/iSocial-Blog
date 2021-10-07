<template>
    <div class="row">
        <div class="col-md-8">
            <div class="d-flex justify-content-between">
                <h4 class="my-auto">
                    Blog list
                </h4>
                <div>
                    <router-link class="me-2 btn btn-primary" to="/blog/create">New Blog</router-link>
                    <a class="me-2 btn btn-light" @click.prevent="getBlogList(true)">Refresh List</a>
                </div>
            </div>
            <hr/>

            <div v-if="!loading">

                <table v-if="blogs.length" class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(blog, index) in blogs">
                        <th scope="row">{{ index + 1 }}</th>
                        <td>{{ blog.name }}</td>
                        <td>{{ blog.category.title }}</td>
                        <td>
                            <div class="btn-group">
                                <router-link class="btn btn-info" :to="`/blog/${blog.id}/show`">View</router-link>
                                <router-link class="btn btn-warning" :to="`/blog/${blog.id}/edit`">Edit</router-link>
                                <button class="btn btn-danger" @click="deleteBlog(blog.id, index)">Delete</button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div v-else>
                    <div class="alert alert-secondary text-center">
                        No blog found
                    </div>
                </div>

            </div>
            <div v-else>
                <div class="alert alert-secondary text-center">
                    Loading...
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "List",
    data() {
        return {
            blogs  : [],
            loading: false,
        }
    },
    mounted() {
        this.getBlogList()
    },
    methods: {
        getBlogList(refresh = false) {
            this.loading = true;
            axios.get('/api/blog')
                .then((response) => {
                    this.blogs = response.data;
                    if (refresh) {
                        toastr.success('Refreshed')
                    }
                })
                .finally(() => {
                    this.loading = false;
                })
                .catch((error) => {
                    toastr.error(error.message)
                })
        },
        deleteBlog(id, index) {
            let r = confirm("Do you want to delete?");
            if (r === true) {
                axios.delete(`/api/blog/${id}`)
                    .then((response) => {
                        this.blogs.splice(index, 1);
                        if (response.data) {
                            toastr.success('Deleted')
                        }
                    })
                    .finally(() => {
                    })
                    .catch((error) => {
                        toastr.error(error.message)
                    })
            } else {
                toastr.info('Canceled')
            }
        }
    }
}
</script>

<style scoped>

</style>
