<template>
  <Soroban
    :column-count="9"
    :decimal-places="3"
  />
</template>

<script lang="ts">
import Vue from 'vue';
import Soroban from './components/Soroban.vue';

export default Vue.extend({
  name: 'App',

  components: {
    Soroban,
  },
});
</script>
