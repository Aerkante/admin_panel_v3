<template>
  <q-layout view="lHh LpR fff">
    <q-page-container class="bg-gradient">
      <q-page padding class="auth-layout">
        <router-view />
      </q-page>
    </q-page-container>
  </q-layout>
</template>
<style lang="scss" scoped>
.bg-gradient {
  background: rgb(113, 21, 117);
  background: linear-gradient(
    45deg,
    rgba(113, 21, 150, 1) 20%,
    rgba(17, 111, 152, 1) 50%,
    rgba(22, 174, 205, 1) 100%
  );
}
</style>
