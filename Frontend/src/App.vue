<template>
  <div class="app-container">
    <SideNav />
    <div class="main-content">
      <router-view />
    </div>
  </div>
</template>

<script>
import SideNav from './Components/SideNav.vue';
export default {
  name: 'App',
  components: {
    SideNav
  }
};
</script>

<style scoped>
.app-container {
  display: flex;
}

.main-content {
  margin-left: 220px;
  padding: 20px;
  width: 100%;
}
</style>
<style src="../src/assets/styles.css"></style>