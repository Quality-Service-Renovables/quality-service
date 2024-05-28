import{r as l,o as $,e as T,b as e,u as b,w as t,F as j,L as q,l as _,Z as U,a as r,d,m as N,t as B}from"./app-iRdYC2KL.js";import{_ as P}from"./AuthenticatedLayout-DHRXjxRi.js";import"./sweetalert2.all-D0LEVVQv.js";import"./ApplicationLogo-DdpmPKnm.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const z=r("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"},"Categorias de Equipos",-1),A={class:"py-12"},F={class:"max-w-7xl mx-auto sm:px-4 lg:px-6"},R={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},L={class:"text-h5"},S={components:{Toaster:q},props:{ct_equipments:{type:Array,required:!0}},data:()=>({search:"",dialog:!1,dialogDelete:!1,headers:[{title:"Categoria",key:"ct_equipment"},{title:"Descripción",key:"description"},{title:"Estado",key:"active"},{title:"Actions",key:"actions",sortable:!1}],editedIndex:-1,editedItem:{ct_equipment_uuid:"",ct_equipment:"",description:"",active:!1},defaultItem:{ct_equipment_uuid:"",ct_equipment:"",description:"",active:!1}}),computed:{formTitle(){return this.editedIndex===-1?"Nueva categoria":"Editar categoria"}},watch:{dialog(o){o||this.close()},dialogDelete(o){o||this.closeDelete()}},methods:{editItem(o){this.editedIndex=this.ct_equipments.indexOf(o),o.active=o.active=="1",this.editedItem=Object.assign({},o),this.dialog=!0},deleteItem(o){this.editedIndex=this.ct_equipments.indexOf(o),this.editedItem=Object.assign({},o),this.dialogDelete=!0},deleteItemConfirm(o){this.ct_equipments.splice(this.editedIndex,1);const i=()=>axios.delete("api/equipment/categories/"+o);_.promise(i,{loading:"Procesando...",success:s=>(this.closeDelete(),"Categoria eliminada correctamente"),error:s=>{this.handleErrors(s)}})},close(){this.dialog=!1,this.$nextTick(()=>{console.log("Cambiando estatus en close"),this.editedItem=Object.assign({},this.defaultItem),this.editedIndex=-1})},closeDelete(){this.dialogDelete=!1,this.$nextTick(()=>{console.log("Cambiando estatus en closeDelete"),this.editedItem=Object.assign({},this.defaultItem),this.editedIndex=-1})},save(){if(this.editedIndex>-1){Object.assign(this.ct_equipments[this.editedIndex],this.editedItem);const o=()=>axios.put("api/equipment/categories/"+this.editedItem.ct_equipment_uuid,{ct_equipment:this.editedItem.ct_equipment,description:this.editedItem.description,active:this.editedItem.active});_.promise(o(),{loading:"Procesando...",success:i=>(this.$inertia.reload(),this.close(),"Categoria actualizada correctamente"),error:i=>{this.handleErrors(i)}})}else{this.ct_equipments.push(this.editedItem);const o=()=>axios.post("api/equipment/categories",{ct_equipment:this.editedItem.ct_equipment,description:this.editedItem.description,active:this.editedItem.active});_.promise(o(),{loading:"Procesando...",success:i=>(this.$inertia.reload(),this.close(),"Categoria creada correctamente"),error:i=>{this.handleErrors(i)}})}},getColor(o){return o?"green":"red"}}},M=Object.assign(S,{__name:"EquipmentCategories",setup(o){return(i,s)=>{const u=l("v-icon"),v=l("v-text-field"),C=l("v-toolbar-title"),k=l("v-divider"),c=l("v-spacer"),n=l("v-btn"),h=l("v-card-title"),m=l("v-col"),x=l("v-textarea"),V=l("v-switch"),f=l("v-row"),D=l("v-container"),w=l("v-card-text"),g=l("v-card-actions"),p=l("v-card"),I=l("v-dialog"),y=l("v-toolbar"),E=l("v-data-table");return $(),T(j,null,[e(b(q),{position:"top-right",richColors:"",visibleToasts:10}),e(b(U),{title:"Equipments"}),e(P,null,{header:t(()=>[z]),default:t(()=>[r("div",A,[r("div",F,[r("div",R,[e(p,null,{default:t(()=>[e(f,null,{default:t(()=>[e(m,{cols:"12",sm:"12"},{default:t(()=>[e(E,{headers:i.headers,items:o.ct_equipments,"fixed-header":"",search:i.search},{"item.active":t(({value:a})=>[e(u,{color:i.getColor(a)},{default:t(()=>[d("mdi-circle-slice-8")]),_:2},1032,["color"])]),top:t(()=>[e(y,{flat:""},{default:t(()=>[e(C,{class:"ml-1"},{default:t(()=>[e(v,{modelValue:i.search,"onUpdate:modelValue":s[0]||(s[0]=a=>i.search=a),label:"Buscar","hide-details":"",variant:"solo","append-inner-icon":"mdi-magnify",density:"compact"},null,8,["modelValue"])]),_:1}),e(k,{class:"mx-4",inset:"",vertical:""}),e(c),e(I,{modelValue:i.dialog,"onUpdate:modelValue":s[4]||(s[4]=a=>i.dialog=a),"max-width":"500px"},{activator:t(({props:a})=>[e(n,N({class:"mb-2",color:"primary",dark:""},a,{icon:"mdi-plus"}),null,16)]),default:t(()=>[e(p,null,{default:t(()=>[e(h,null,{default:t(()=>[r("span",L,B(i.formTitle),1)]),_:1}),e(w,null,{default:t(()=>[e(D,null,{default:t(()=>[e(f,null,{default:t(()=>[e(m,{cols:"12"},{default:t(()=>[e(v,{modelValue:i.editedItem.ct_equipment,"onUpdate:modelValue":s[1]||(s[1]=a=>i.editedItem.ct_equipment=a),label:"Nombre",variant:"solo","hide-details":""},null,8,["modelValue"])]),_:1}),e(m,{cols:"12"},{default:t(()=>[e(x,{modelValue:i.editedItem.description,"onUpdate:modelValue":s[2]||(s[2]=a=>i.editedItem.description=a),label:"Descripción",variant:"solo","hide-details":""},null,8,["modelValue"])]),_:1}),e(m,{cols:"12"},{default:t(()=>[e(V,{label:"Activo",modelValue:i.editedItem.active,"onUpdate:modelValue":s[3]||(s[3]=a=>i.editedItem.active=a),color:"primary"},null,8,["modelValue"])]),_:1})]),_:1})]),_:1})]),_:1}),e(g,null,{default:t(()=>[e(c),e(n,{color:"blue-darken-1",variant:"text",onClick:i.close},{default:t(()=>[d(" Cancelar ")]),_:1},8,["onClick"]),e(n,{color:"blue-darken-1",variant:"text",onClick:i.save},{default:t(()=>[d(" Guardar ")]),_:1},8,["onClick"])]),_:1})]),_:1})]),_:1},8,["modelValue"]),e(I,{modelValue:i.dialogDelete,"onUpdate:modelValue":s[6]||(s[6]=a=>i.dialogDelete=a),"max-width":"500px"},{default:t(()=>[e(p,null,{default:t(()=>[e(h,{class:"text-h5 text-center"},{default:t(()=>[d("¿Estás seguro de eliminar?")]),_:1}),e(g,null,{default:t(()=>[e(c),e(n,{color:"blue-darken-1",variant:"text",onClick:i.closeDelete},{default:t(()=>[d("Cancel")]),_:1},8,["onClick"]),e(n,{color:"blue-darken-1",variant:"text",onClick:s[5]||(s[5]=a=>i.deleteItemConfirm(i.editedItem.ct_equipment_uuid))},{default:t(()=>[d("Si, eliminar")]),_:1}),e(c)]),_:1})]),_:1})]),_:1},8,["modelValue"])]),_:1})]),"item.actions":t(({item:a})=>[e(u,{class:"me-2",size:"small",onClick:O=>i.editItem(a)},{default:t(()=>[d(" mdi-pencil ")]),_:2},1032,["onClick"]),e(u,{size:"small",onClick:O=>i.deleteItem(a)},{default:t(()=>[d(" mdi-delete ")]),_:2},1032,["onClick"])]),_:1},8,["headers","items","search"])]),_:1})]),_:1})]),_:1})])])])]),_:1})],64)}}});export{M as default};
