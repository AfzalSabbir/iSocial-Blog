<template>
    <div class="row">
        <div class="col-md-8">

            <table class="table table-bordered">
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
                            <button class="btn btn-warning">Edit</button>
                            <button class="btn btn-danger">Delete</button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    name: "List",
    data() {
        return {
            blogs: [],
        }
    },
    mounted() {
        this.getBlogList()
    },
    methods: {
        getBlogList() {
            axios.get('/api/blog').then((response) => {
                this.blogs = response.data;
            })
        }
    }
}
</script>

<style scoped>

</style>
