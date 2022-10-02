<template>
  <div
    class="fullscreen bg-primary text-white text-center q-pa-md flex flex-center"
  >
    <div>
      <div style="font-size: 30vh">404</div>

      <div class="text-h2" style="opacity: 0.6">
        Ooops... Página não encontrada!
      </div>

      <q-btn
        class="q-mt-xl"
        color="white"
        text-color="primary"
        unelevated
        to="/"
        label="Tela Inicial"
        no-caps
      />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
  name: 'Error404'
})
</script>
