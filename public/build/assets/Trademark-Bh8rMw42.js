import{r as l,o as O,e as M,b as e,u as I,w as a,F as U,L as b,l as u,Z as j,a as n,d as s,m as N,t as q}from"./app-iRdYC2KL.js";import{_ as B}from"./AuthenticatedLayout-DHRXjxRi.js";import"./sweetalert2.all-D0LEVVQv.js";import"./ApplicationLogo-DdpmPKnm.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const P=n("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"},"Marcas",-1),z={class:"py-12"},A={class:"max-w-7xl mx-auto sm:px-4 lg:px-6"},F={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},R={class:"text-h5"},L={components:{Toaster:b},props:{trademarks:{type:Array,required:!0}},data:()=>({search:"",dialog:!1,dialogDelete:!1,headers:[{title:"Marca",key:"trademark"},{title:"Estado",key:"active"},{title:"Categoría",key:"category.ct_trademark"},{title:"Acciones",key:"actions",sortable:!1}],editedIndex:-1,editedItem:{trademark_uuid:"",trademark:"",active:!1,ct_trademark_code:""},defaultItem:{trademark_uuid:"",trademark:"",active:!1,ct_trademark_code:""},ct_trademarks:[]}),computed:{formTitle(){return this.editedIndex===-1?"Nueva marca":"Editar marca"}},watch:{dialog(o){o||this.close()},dialogDelete(o){o||this.closeDelete()}},methods:{editItem(o){this.editedIndex=this.trademarks.indexOf(o),o.active=o.active=="1",o.ct_trademark_code=o.category.ct_trademark_code,this.editedItem=Object.assign({},o),this.dialog=!0},deleteItem(o){this.editedIndex=this.trademarks.indexOf(o),this.editedItem=Object.assign({},o),this.dialogDelete=!0},deleteItemConfirm(o){const t=()=>axios.delete("api/trademarks/"+o);u.promise(t,{loading:"Procesando...",success:r=>(this.closeDelete(),this.$inertia.reload(),"Marca eliminada correctamente"),error:r=>{this.handleErrors(r)}})},close(){this.dialog=!1,this.$nextTick(()=>{console.log("Cambiando estatus en close"),this.editedItem=Object.assign({},this.defaultItem),this.editedIndex=-1})},closeDelete(){this.dialogDelete=!1,this.$nextTick(()=>{console.log("Cambiando estatus en closeDelete"),this.editedItem=Object.assign({},this.defaultItem),this.editedIndex=-1})},save(){if(this.editedIndex>-1){const o=()=>axios.put("api/trademarks/"+this.editedItem.trademark_uuid,{trademark:this.editedItem.trademark,active:this.editedItem.active,ct_trademark_code:this.editedItem.ct_trademark_code});u.promise(o(),{loading:"Procesando...",success:t=>(this.close(),this.$inertia.reload(),"Marca actualizada correctamente"),error:t=>{this.handleErrors(t)}})}else{const o=()=>axios.post("api/trademarks",{trademark:this.editedItem.trademark,active:this.editedItem.active,ct_trademark_code:this.editedItem.ct_trademark_code});u.promise(o(),{loading:"Procesando...",success:t=>(this.close(),this.$inertia.reload(),"Marca creada correctamente"),error:t=>{this.handleErrors(t)}})}},getColor(o){return o?"green":"red"},getTrademarkCategories(){axios.get("api/trademark/categories").then(o=>{this.ct_trademarks=o.data.data}).catch(o=>{u.error("Error al cargar las categorías de marcas")})}},mounted(){this.getTrademarkCategories()}},K=Object.assign(L,{__name:"Trademark",setup(o){return(t,r)=>{const _=l("v-icon"),p=l("v-text-field"),C=l("v-toolbar-title"),V=l("v-divider"),c=l("v-spacer"),i=l("v-btn"),h=l("v-card-title"),m=l("v-col"),x=l("v-select"),y=l("v-switch"),k=l("v-row"),w=l("v-container"),D=l("v-card-text"),f=l("v-card-actions"),v=l("v-card"),g=l("v-dialog"),T=l("v-toolbar"),$=l("v-data-table");return O(),M(U,null,[e(I(b),{position:"top-right",richColors:"",visibleToasts:10}),e(I(j),{title:"Marcas"}),e(B,null,{header:a(()=>[P]),default:a(()=>[n("div",z,[n("div",A,[n("div",F,[e(v,null,{default:a(()=>[e(k,null,{default:a(()=>[e(m,{cols:"12",sm:"12"},{default:a(()=>[e($,{headers:t.headers,items:o.trademarks,"fixed-header":"",search:t.search},{"item.active":a(({value:d})=>[e(_,{color:t.getColor(d)},{default:a(()=>[s("mdi-circle-slice-8")]),_:2},1032,["color"])]),top:a(()=>[e(T,{flat:""},{default:a(()=>[e(C,{class:"ml-1"},{default:a(()=>[e(p,{modelValue:t.search,"onUpdate:modelValue":r[0]||(r[0]=d=>t.search=d),label:"Buscar","hide-details":"",variant:"solo","append-inner-icon":"mdi-magnify",density:"compact"},null,8,["modelValue"])]),_:1}),e(V,{class:"mx-4",inset:"",vertical:""}),e(c),e(g,{modelValue:t.dialog,"onUpdate:modelValue":r[4]||(r[4]=d=>t.dialog=d),"max-width":"500px"},{activator:a(({props:d})=>[e(i,N({class:"mb-2",color:"primary",dark:""},d,{icon:"mdi-plus"}),null,16)]),default:a(()=>[e(v,null,{default:a(()=>[e(h,null,{default:a(()=>[n("span",R,q(t.formTitle),1)]),_:1}),e(D,null,{default:a(()=>[e(w,null,{default:a(()=>[e(k,null,{default:a(()=>[e(m,{cols:"12"},{default:a(()=>[e(p,{modelValue:t.editedItem.trademark,"onUpdate:modelValue":r[1]||(r[1]=d=>t.editedItem.trademark=d),label:"Nombre",variant:"solo","hide-details":""},null,8,["modelValue"])]),_:1}),e(m,{cols:"12"},{default:a(()=>[e(x,{modelValue:t.editedItem.ct_trademark_code,"onUpdate:modelValue":r[2]||(r[2]=d=>t.editedItem.ct_trademark_code=d),items:t.ct_trademarks,"item-title":"ct_trademark","item-value":"ct_trademark_code",label:"Categoría",variant:"solo","hide-details":""},null,8,["modelValue","items"])]),_:1}),e(m,{cols:"12"},{default:a(()=>[e(y,{label:"Activo",modelValue:t.editedItem.active,"onUpdate:modelValue":r[3]||(r[3]=d=>t.editedItem.active=d),color:"primary"},null,8,["modelValue"])]),_:1})]),_:1})]),_:1})]),_:1}),e(f,null,{default:a(()=>[e(c),e(i,{color:"blue-darken-1",variant:"text",onClick:t.close},{default:a(()=>[s(" Cancelar ")]),_:1},8,["onClick"]),e(i,{color:"blue-darken-1",variant:"text",onClick:t.save},{default:a(()=>[s(" Guardar ")]),_:1},8,["onClick"])]),_:1})]),_:1})]),_:1},8,["modelValue"]),e(g,{modelValue:t.dialogDelete,"onUpdate:modelValue":r[6]||(r[6]=d=>t.dialogDelete=d),"max-width":"500px"},{default:a(()=>[e(v,null,{default:a(()=>[e(h,{class:"text-h5 text-center"},{default:a(()=>[s("¿Estás seguro de eliminar?")]),_:1}),e(f,null,{default:a(()=>[e(c),e(i,{color:"blue-darken-1",variant:"text",onClick:t.closeDelete},{default:a(()=>[s("Cancel")]),_:1},8,["onClick"]),e(i,{color:"blue-darken-1",variant:"text",onClick:r[5]||(r[5]=d=>t.deleteItemConfirm(t.editedItem.trademark_uuid))},{default:a(()=>[s("Si, eliminar")]),_:1}),e(c)]),_:1})]),_:1})]),_:1},8,["modelValue"])]),_:1})]),"item.actions":a(({item:d})=>[e(_,{class:"me-2",size:"small",onClick:E=>t.editItem(d)},{default:a(()=>[s(" mdi-pencil ")]),_:2},1032,["onClick"]),e(_,{size:"small",onClick:E=>t.deleteItem(d)},{default:a(()=>[s(" mdi-delete ")]),_:2},1032,["onClick"])]),_:1},8,["headers","items","search"])]),_:1})]),_:1})]),_:1})])])])]),_:1})],64)}}});export{K as default};
