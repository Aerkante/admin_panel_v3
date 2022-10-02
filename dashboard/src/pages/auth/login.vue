<template>
  <div class="flex justify-center full-width q-mt-xl">
    <div class="container-limit">
      <q-card class="bg-white q-card__login q-pa-xl">
        <div
          class="text-h4 text-weight-bold text-center q-my-md text-grey-9 q-my-md"
        >
          Login
        </div>
        <div class="row form_fields_container">
          <div class="col q-gutter-lg">
            <div class="col-12">
              <q-input
                v-model="state.form.email"
                :loading="state.requestLoading"
                label="Email"
                autofocus
                label-color="dark"
                :aria-autocomplete="false"
                autocomplete="off"
              >
                <template v-slot:prepend>
                  <q-icon name="mdi-account" />
                </template>
              </q-input>
            </div>
            <div class="col-12">
              <q-input
                v-model="state.form.password"
                :loading="state.requestLoading"
                label="Senha"
                type="password"
                autofocus
                label-color="dark"
              >
                <template v-slot:prepend>
                  <q-icon name="mdi-key" />
                </template>
              </q-input>
            </div>
          </div>
        </div>
        <div class="q-mt-xl flex justify-center">
          <q-btn
            color="primary"
            icon-right="mdi-arrow-right-circle"
            label="Login"
            @click="submit"
            rounded
            unelevated
          />
        </div>
      </q-card>
    </div>
  </div>
</template>
<script lang="ts">
import { useAuthStore } from 'src/stores'
import { defineComponent, reactive } from 'vue'

export default defineComponent({
  setup() {
    const store = useAuthStore()
    const state = reactive({
      requestLoading: false,
      form: {
        email: '',
        password: ''
      }
    })

    const submit = async () => {
      state.requestLoading = true
      try {
        const statusResponse = await store.login({ ...state.form })
        if (statusResponse >= 200 && statusResponse < 300) {
          console.log('logged')
        }
      } catch (error) {
        console.log(error)
      } finally {
        state.requestLoading = false
      }
    }

    return { state, submit }
  }
})
</script>
<style lang="scss" scoped>
.container-limit {
  max-width: 90vw;
  min-width: 300px;
  width: 40rem;
  min-height: 400px;
  height: 50rem;
  justify-content: center;
}
.q_card__login {
  min-width: 300px;
}

.form_fields_container {
  margin-top: 5rem;
}
</style>
