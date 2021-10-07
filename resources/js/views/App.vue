<template>
    <Nav/>
    <div class="container mt-4">
        <router-view></router-view>
    </div>
</template>

<script>
import Nav from "./partials/Nav";

export default {
    name      : "App",
    components: {Nav}
}
</script>

<style scoped>

</style>
