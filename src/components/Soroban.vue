<template>
  <div>
    <div class="soroban">
      <Column
        v-for="(column, index) in columns"
        :key="index"
        :column-value="column.value"
        :bead-color="column.color"
        :first-bead-color="index === firstBeadIndex ? firstBeadColor : column.color"
        @update:columnValue="updateColumn($event, index)"
      />
    </div>

    <div class="toolbar">
      <button
        :disabled="disableReset"
        @click="reset"
      >
        Reset
      </button>

      <span>Value: {{ integerValue }}</span>

      <span v-if="decimalValue">{{ decimalValue.toPrecision(decimalPrecision).slice(1) }}</span>
    </div>
  </div>
</template>

<script lang="ts">
import Vue from 'vue';
import Column from '@/components/Column.vue';
import EventBus from '../event-bus'

const beadColor = 'burlywood';

export default Vue.extend({
  name: 'Soroban',
  components: {
    Column,
  },

  props: {
    columnCount: {
      type: Number,
      required: true,
    },

    decimalPlaces: {
      type: Number,
      required: true,
    },
  },

  data() {
    return {
      firstBeadColor: '#800000',
      columns: [
        { value: 0, color: beadColor },
        { value: 0, color: beadColor },
        { value: 0, color: beadColor },
        { value: 0, color: beadColor },
        { value: 0, color: beadColor },
        { value: 0, color: beadColor },
        { value: 0, color: beadColor },
        { value: 0, color: beadColor },
        { value: 0, color: beadColor },
      ],
    }
  },

  computed: {
    firstBeadIndex() {
      // @ts-ignore
      return this.columnCount - this.decimalPlaces - 1
    },

    integerValue() {
      // @ts-ignore
      const integerColumns = this.columns.slice(0, this.columnCount - this.decimalPlaces)
      // @ts-ignore
      return integerColumns.reduce(
        // @ts-ignore
        (acc, column, index) => {
          const columnPower = integerColumns.length - index - 1
          const columnValue = 10 ** columnPower * column.value
          return acc + columnValue
        },
        0,
      )
    },

    decimalValue() {
      // @ts-ignore
      const decimalColumns = this.columns.slice(this.columnCount - this.decimalPlaces)

      return decimalColumns.reduce(
        // @ts-ignore
        (acc, column, index) => {
          const columnPower = (index + 1) * -1
          const columnValue = 10 ** columnPower * column.value
          return acc + columnValue
        },
        0,
      )
    },

    decimalPrecision() {
      let precision = 0
      let i: number
      // decimal precision
      for (i = 0; i < this.decimalPlaces; i++) {
        const decimalIndex = this.columnCount - 1 - i;
        if (this.columns[decimalIndex].value > 0) {
          precision += 1
        }
      }
      // @ts-ignore
      return precision
    },

    disableReset() {
      // @ts-ignore
      return (this.integerValue + this.decimalValue) === 0
    },
  },

  methods: {
    updateColumn(value: number, index: number) {
      const column = this.columns[index]
      Vue.set(column, 'value', value)
    },

    reset() {
      EventBus.$emit('reset')
    },
  },
});
</script>

<style lang="scss" scoped>
  .soroban {
    display: inline-flex;
    // border: 5px solid dimgray;
    border-top: 5px solid dimgray;
    border-bottom: 5px solid dimgray;
    border-left: 10px solid dimgray;
    border-right: 10px solid dimgray;
    margin: 10px 0px 0px 10px;
  }

  .toolbar {
    display: flex;
    margin: 10px 0px 0px 10px;

    button {
      margin-right: 10px;
    }
  }
</style>
