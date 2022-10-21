import { defineStore } from 'pinia';

export const useCounterStore = defineStore('counter', {
  state: () => ({
    user:{},
    isLoggedIn:!!localStorage.getItem('tokenPort'),
  }),
  getters: {
    doubleCount: (state) => state.counter * 2,
  },
  actions: {
    increment() {
      this.counter++;
    },
  },
});
