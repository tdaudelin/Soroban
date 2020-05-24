<template>
  <div class="deck">
    <div
      class="cell"
      v-for="(_, cellIndex) in cells"
      :key="cellIndex"
    >
      <button
        v-if="shouldDisplayBead(cellIndex)"
        :style="{
          backgroundColor: firstBeadColor && convertToBeadIndex(cellIndex) == 0
            ? firstBeadColor
            : beadColor
        }"
        @click="moveBead(convertToBeadIndex(cellIndex))"
      />
    </div>
  </div>
</template>

<script lang="ts">
import Vue from 'vue'
import EventBus from '../event-bus'

export default Vue.extend({
  name: 'Deck',

  props: {
    beadCount: {
      type: Number,
      required: true,
    },

    beadColor: {
      type: String,
      required: true,
    },

    firstBeadColor: {
      type: String,
      required: false,
      default: undefined,
    },

    deckValue: {
      type: Number,
      required: true,
    },

    startAtTop: {
      type: Boolean,
      default: false,
    },
  },

  data() {
    return {
      beads: new Array(this.beadCount).fill(false),
      cells: new Array(this.beadCount + 1),
    }
  },

  methods: {
    accountForDirection(cellIndex: number): number {
      return this.startAtTop
        ? this.cells.length - cellIndex - 1
        : cellIndex
    },

    convertToBeadIndex(cellIndex: number): number {
      const index = this.accountForDirection(cellIndex)

      // assume that cellIndex contains a bead, if bead's value is true then cellIndex == beadIndex
      // if not, then there was a gap at some earlier cell position so beadIndex = cellIndex - 1
      const bead = this.beads[index];
      return bead ? index : index - 1;
    },

    shouldDisplayBead(cellIndex: number): boolean {
      const index = this.accountForDirection(cellIndex)
      const bead = this.beads[index];
      return bead || (index > 0 ? this.beads[index - 1] === false : false)
    },

    moveBead(beadIndex: number): void {
      const deactivating = this.beads[beadIndex]
      this.beads = this.beads.map((_, i) => {
        if (deactivating) {
          return !(i >= beadIndex) // set all beads >= the clicked bead to false
        }
        return i <= beadIndex // set all beads <= the clicked bead to true
      })
      this.$emit('update:deckValue', this.beads.reduce((acc, bead) => (bead ? acc + 1 : acc), 0))
    },
  },

  mounted(): void {
    EventBus.$on('reset', () => {
      this.beads = new Array(this.beadCount).fill(false)
      this.$emit('update:deckValue', 0)
    })
  },
})
</script>

<style lang="scss" scoped>
  .deck {
    padding: 0px 5px;
    background: linear-gradient(#000, #000) no-repeat center/2px 100%;
  }

  .cell {
    height: 40px;
  }

  button {
    border-radius: 25px;
    border: 1px solid #454545;
    height: 100%;
    width: 100%;
    cursor: pointer;
  }
</style>
