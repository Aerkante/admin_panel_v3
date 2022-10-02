<template>
  <q-layout view="lHh LpR fff">
    <q-page-container class="bg-primary">
      <q-page padding class="auth-layout">
        <router-view />
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<style lang="sass" scoped>
.auth-layout
  background-image: url('~assets/auth-background.png')
  background-repeat: no-repeat
  background-position: 2% calc(100% - 2%)
</style>
