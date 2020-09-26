<template>
    <div class="px-2 py-2 bg-gray-200 text-gray-600 shadow border border-gray-300 rounded-md my-1 cursor-pointer"
    @click="select"
    :class="isItemSelected?'bg-blue-300 text-white':''">
        {{ item.name }}
    </div>
</template>

<script>
export default {
    name:'Item',
    props:{
        item:Object,
        selectedID:Number,
    },
    computed: {
        isItemSelected(){
            if(this.item.id == this.selectedID)
                return true
            return false
        }
    },
    methods: {
        select(){
            this.$emit('select',this.item.id)
        }
    },
}
</script>
