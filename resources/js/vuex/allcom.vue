<template>
    <div>
        <h1>This is Main Com and Counter is {{ $store.state.counter }}</h1>

        <comA></comA>
        <comB></comB>

        <button @click='increase(1)'>Increase</button>
        <button @click='decrease(5)'>Decrease</button>
    </div>
</template>
<script>
import comA from './comA'
import comB from './comB'
export default {
    components: {
        comA,
        comB
    },
    methods: {
        increase(num){
            this.$store.commit('increase', num)
        },
        decrease(num){
            this.$store.commit('decrease',num)
        }
    }
}
</script>