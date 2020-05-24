<template>
  <div class="column">
    <Deck
      :bead-count="1"
      :bead-color="beadColor"
      :deck-value.sync="upperDeck"
      :style="{ borderBottom: '5px solid dimgray' }"
      start-at-top
    />

    <Deck
      :bead-count="4"
      :bead-color="beadColor"
      :first-bead-color="firstBeadColor"
      :deck-value.sync="lowerDeck"
      :style="{ borderTop: '5px solid black' }"
    />
  </div>
</template>

<script lang="ts">
import Vue from 'vue'
import Deck from '@/components/Deck.vue'

export default Vue.extend({
  name: 'Column',

  components: {
    Deck,
  },

  props: {
    columnValue: {
      type: Number,
      required: true,
    },

    beadColor: {
      type: String,
      default: 'burlywood',
    },

    firstBeadColor: {
      type: String,
      required: false,
      default: undefined,
    },
  },

  data: () => ({
    upperDeck: 0,
    lowerDeck: 0,
  }),

  methods: {
    emitColumnValue(val: number) {
      this.$emit('update:columnValue', val)
    },
  },

  watch: {
    upperDeck(newVal) {
      this.emitColumnValue(newVal * 5 + this.lowerDeck);
    },

    lowerDeck(newVal) {
      this.emitColumnValue(this.upperDeck * 5 + newVal);
    },
  },
})
</script>

<style lang="scss" scoped>
  .column {
    width: 90px;
    border-top: 5px solid black;
    // border-left: 5px solid black;
    // border-right: 5px solid dimgray;
    border-bottom: 5px solid dimgray;
  }
</style>
