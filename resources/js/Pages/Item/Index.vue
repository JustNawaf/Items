<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Items Management Page
            </h2>
        </template>
        <div class="py-12">
            <div class="w-full h-full px-4 py-4 flex flex-col justify-center items-center">
                <div class="w-full lg:w-1/2 h-full">
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full h-full flex flex-col">
                            <div class="w-full px-3 my-4">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name">
                                    Item Name
                                </label>
                                <input class="appearance-none block w-full bg-gray-200 text-gray-700
                                border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                :class="name.errors?'border-red-400':'border-gray-200'"
                                 id="name" type="text" v-model="name.value">
                                <p class="text-gray-600 text-xs italic" :class="name.errors?'text-red-400':'text-gray-600'">
                                    {{ name.errors?name.errors.name[0]:"Make sure it's not empty when adding." }}
                                </p>
                            </div>
                            <div class="w-full h-full px-3">
                                <button class="w-full h-full tracking-wide
                                 font-bold py-2 border rounded-md text-white bg-gradient-to-r from-gray-400 to-blue-500 hover:to-green-600 focus:outline-none" @click="addItem">Create</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full h-full px-4 py-4 flex flex-col justify-center items-center">
                <div class="w-full lg:w-1/2 h-full flex flex-row justify-center items-center">

                    <div class="w-full h-full">
                        <div class="w-full h-72 overflow-y-auto flex flex-col shadow-lg border rounded-md px-2 py-2">
                            <Item :item="item" :selectedID="selectedID" v-for="item in unselectedItems" :key="item.id" @select="selectedID = item.id"/>
                        </div>
                        <span v-if="errors.remove" class="text-red-400 text-xs px-1 py-2">The Item already unselected!</span>
                    </div>
                    <div class="flex flex-col justify-between mx-2">
                        <button class="w-full h-full cursor-pointer bg-blue-400
                         text-center text-white px-4 py-4 my-8 border rounded-md text-2xl hover:bg-blue-500 focus:outline-none" @click="addToSelected">&gt;</button>
                        <button class="w-full h-full cursor-pointer bg-blue-400
                         text-center text-white px-4 py-4 my-8 border rounded-md text-2xl hover:bg-blue-500 focus:outline-none" @click="removeFromSelected">&lt;</button>

                    </div>
                    <div class="w-full h-full">
                        <div class="w-full h-72 overflow-y-auto flex flex-col shadow-lg border rounded-md px-2 py-2">
                            <Item :item="item" :selectedID="selectedID" v-for="item in selectedItems" :key="item.id" @select="selectedID = item.id"/>
                        </div>
                        <span v-if="errors.add" class="text-red-400 text-xs px-1 py-2">The Item already selected!</span>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '../../Layouts/AppLayout'
import Item from './components/Item'
export default {
    name:'Index',
    components:{
        AppLayout,
        Item,
    },
    props:{
        items:Array,
    },
    data() {
        return {
            name:{
                value:'',
                errors:null,
            },
            errors:{
                add:null,
                remove:null,
            },
            itemsData:this.items,
            selectedID:null,
        }
    },
    computed: {
        selectedItems(){
            return this.itemsData.filter((item)=>item.selected)
        },
        unselectedItems(){
            return this.itemsData.filter((item)=>!item.selected)
        }
    },
    methods: {
        addItem(){
            if(this.checkName()){
                axios.post('/add/item',{name:this.name.value})
                .then((res)=>{
                    this.name.value = ''
                    this.name.errors = null
                    this.itemsData.push(res.data)
                })
                .catch((res)=>{
                    this.name.errors = res.response.data.errors
                })
            }
        },
        checkName(){
            if(this.name.value != '')
                return true
            return false
        },
        addToSelected(){
            if(this.selectedID){
                let item = this.itemsData.find((item) => item.id == this.selectedID)
                if(!item.selected)
                    axios.post('/update/item',{id:item.id,selected:item.selected})
                    .then(()=>{
                        this.errors.add = null
                        this.errors.remove = null
                        this.selectedID = null
                        item.selected = !item.selected
                    })
                    .catch((res)=>{
                        this.errors.add = true
                    })
                else{
                    this.errors.add = true
                }
            }
        },
        removeFromSelected(){
            if(this.selectedID){
                let item = this.itemsData.find((item) => item.id == this.selectedID)
                if(item.selected)
                    axios.post('/update/item',{id:item.id,selected:item.selected})
                    .then(()=>{
                        this.errors.add = null
                        this.errors.remove = null
                        this.selectedID = null
                        item.selected = !item.selected
                    })
                    .catch((res)=>{
                        this.errors.remove = true
                    })
                else{
                    this.errors.remove = true
                }
            }
        }
    },
}
</script>
