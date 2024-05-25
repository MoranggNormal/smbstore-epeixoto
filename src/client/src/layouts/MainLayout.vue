<template>
  <div class="layout">
    <AppHeader />
    <div class="content">
      <slot> </slot>
    </div>
    <AppFooter />
  </div>
</template>
  
  <script>
import AppHeader from "@/components/AppHeader.vue";
import AppFooter from "../components/AppFooter.vue";

export default {
  name: "MainLayout",
  components: {
    AppHeader,
    AppFooter,
  },
};
</script>
  
<style scoped>
.layout {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  margin: 0 auto;
  background: #f9f7f5;
}
.content {
  height: 100vh;
}
</style>