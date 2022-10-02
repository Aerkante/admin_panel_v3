import { Notify } from 'quasar'

const notify = (type: string, message: string, icon = '') => {
  Notify.create({
    position: 'top',
    timeout: 3000,
    progress: true,
    type,
    message,
    icon
  })
}

export function useNotifier () {
  return {
    success (message: string, icon = 'mdi-check') {
      notify('positive', message, icon)
    },
    warning (message: string, icon = 'mdi-alert-circle') {
      notify('warning', message, icon)
    },
    error (message: string, icon = 'mdi-alert-circle') {
      notify('negative', message, icon)
    }
  }
}
