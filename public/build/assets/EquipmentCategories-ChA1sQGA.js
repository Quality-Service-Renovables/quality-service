import{r as s,o as u,e as j,b as e,u as k,w as i,F as N,L as V,q as h,Z as U,a as r,d,c as v,s as B,x as z,t as A,g as f}from"./app-K-shZ7NT.js";import{_ as F}from"./AuthenticatedLayout-De2P2DPL.js";import"./sweetalert2.all-CDV-19Y8.js";import"./ApplicationLogo-CZ_VtXkg.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const R=r("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"},"Categorias de Equipos",-1),S={class:"py-12"},L={class:"max-w-7xl mx-auto sm:px-4 lg:px-6"},G={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},Z={class:"text-h5"},H={components:{Toaster:V},props:{ct_equipments:{type:Array,required:!0}},data:()=>({search:"",dialog:!1,dialogDelete:!1,headers:[{title:"Categoria",key:"ct_equipment"},{title:"Descripción",key:"description"},{title:"Estado",key:"active"},{title:"Actions",key:"actions",sortable:!1}],editedIndex:-1,editedItem:{ct_equipment_uuid:"",ct_equipment:"",description:"",active:!1},defaultItem:{ct_equipment_uuid:"",ct_equipment:"",description:"",active:!1}}),computed:{formTitle(){return this.editedIndex===-1?"Nueva categoria":"Editar categoria"}},watch:{dialog(o){o||this.close()},dialogDelete(o){o||this.closeDelete()}},methods:{editItem(o){this.editedIndex=this.ct_equipments.indexOf(o),o.active=o.active=="1",this.editedItem=Object.assign({},o),this.dialog=!0},deleteItem(o){this.editedIndex=this.ct_equipments.indexOf(o),this.editedItem=Object.assign({},o),this.dialogDelete=!0},deleteItemConfirm(o){this.ct_equipments.splice(this.editedIndex,1);const t=()=>axios.delete("api/equipment/categories/"+o);h.promise(t,{loading:"Procesando...",success:l=>(this.closeDelete(),"Categoria eliminada correctamente"),error:l=>{this.handleErrors(l)}})},close(){this.dialog=!1,this.$nextTick(()=>{console.log("Cambiando estatus en close"),this.editedItem=Object.assign({},this.defaultItem),this.editedIndex=-1})},closeDelete(){this.dialogDelete=!1,this.$nextTick(()=>{console.log("Cambiando estatus en closeDelete"),this.editedItem=Object.assign({},this.defaultItem),this.editedIndex=-1})},save(){if(this.editedIndex>-1){Object.assign(this.ct_equipments[this.editedIndex],this.editedItem);const o=()=>axios.put("api/equipment/categories/"+this.editedItem.ct_equipment_uuid,{ct_equipment:this.editedItem.ct_equipment,description:this.editedItem.description,active:this.editedItem.active});h.promise(o(),{loading:"Procesando...",success:t=>(this.$inertia.reload(),this.close(),"Categoria actualizada correctamente"),error:t=>{this.handleErrors(t)}})}else{this.ct_equipments.push(this.editedItem);const o=()=>axios.post("api/equipment/categories",{ct_equipment:this.editedItem.ct_equipment,description:this.editedItem.description,active:this.editedItem.active});h.promise(o(),{loading:"Procesando...",success:t=>(this.$inertia.reload(),this.close(),"Categoria creada correctamente"),error:t=>{this.handleErrors(t)}})}},getColor(o){return o?"green":"red"}}},X=Object.assign(H,{__name:"EquipmentCategories",setup(o){return(t,l)=>{const p=s("v-icon"),g=s("v-text-field"),x=s("v-toolbar-title"),y=s("v-divider"),c=s("v-spacer"),n=s("v-btn"),I=s("v-card-title"),m=s("v-col"),D=s("v-textarea"),w=s("v-switch"),q=s("v-row"),T=s("v-container"),E=s("v-card-text"),b=s("v-card-actions"),_=s("v-card"),C=s("v-dialog"),P=s("v-toolbar"),O=s("v-data-table");return u(),j(N,null,[e(k(V),{position:"top-right",richColors:"",visibleToasts:10}),e(k(U),{title:"Categorias de Equipos"}),e(F,null,{header:i(()=>[R]),default:i(()=>[r("div",S,[r("div",L,[r("div",G,[e(_,null,{default:i(()=>[e(q,null,{default:i(()=>[e(m,{cols:"12",sm:"12"},{default:i(()=>[e(O,{headers:t.headers,items:o.ct_equipments,"fixed-header":"",search:t.search},{"item.active":i(({value:a})=>[e(p,{color:t.getColor(a)},{default:i(()=>[d("mdi-circle-slice-8")]),_:2},1032,["color"])]),top:i(()=>[e(P,{flat:""},{default:i(()=>[e(x,{class:"ml-1"},{default:i(()=>[e(g,{modelValue:t.search,"onUpdate:modelValue":l[0]||(l[0]=a=>t.search=a),label:"Buscar","hide-details":"",variant:"solo","append-inner-icon":"mdi-magnify",density:"compact"},null,8,["modelValue"])]),_:1}),e(y,{class:"mx-4",inset:"",vertical:""}),e(c),t.hasPermissionTo("equipments_categories.create")||t.hasPermissionTo("equipments_categories.update")?(u(),v(C,{key:0,modelValue:t.dialog,"onUpdate:modelValue":l[4]||(l[4]=a=>t.dialog=a),"max-width":"500px"},B({default:i(()=>[e(_,null,{default:i(()=>[e(I,null,{default:i(()=>[r("span",Z,A(t.formTitle),1)]),_:1}),e(E,null,{default:i(()=>[e(T,null,{default:i(()=>[e(q,null,{default:i(()=>[e(m,{cols:"12"},{default:i(()=>[e(g,{modelValue:t.editedItem.ct_equipment,"onUpdate:modelValue":l[1]||(l[1]=a=>t.editedItem.ct_equipment=a),label:"Nombre",variant:"solo","hide-details":""},null,8,["modelValue"])]),_:1}),e(m,{cols:"12"},{default:i(()=>[e(D,{modelValue:t.editedItem.description,"onUpdate:modelValue":l[2]||(l[2]=a=>t.editedItem.description=a),label:"Descripción",variant:"solo","hide-details":""},null,8,["modelValue"])]),_:1}),e(m,{cols:"12"},{default:i(()=>[e(w,{label:"Activo",modelValue:t.editedItem.active,"onUpdate:modelValue":l[3]||(l[3]=a=>t.editedItem.active=a),color:"primary"},null,8,["modelValue"])]),_:1})]),_:1})]),_:1})]),_:1}),e(b,null,{default:i(()=>[e(c),e(n,{color:"blue-darken-1",variant:"text",onClick:t.close},{default:i(()=>[d(" Cancelar ")]),_:1},8,["onClick"]),e(n,{color:"blue-darken-1",variant:"text",onClick:t.save},{default:i(()=>[d(" Guardar ")]),_:1},8,["onClick"])]),_:1})]),_:1})]),_:2},[t.hasPermissionTo("equipments_categories.create")?{name:"activator",fn:i(({props:a})=>[e(n,z({class:"mb-2",color:"primary",dark:""},a,{icon:"mdi-plus"}),null,16)]),key:"0"}:void 0]),1032,["modelValue"])):f("",!0),e(C,{modelValue:t.dialogDelete,"onUpdate:modelValue":l[6]||(l[6]=a=>t.dialogDelete=a),"max-width":"500px"},{default:i(()=>[e(_,null,{default:i(()=>[e(I,{class:"text-h5 text-center"},{default:i(()=>[d("¿Estás seguro de eliminar?")]),_:1}),e(b,null,{default:i(()=>[e(c),e(n,{color:"blue-darken-1",variant:"text",onClick:t.closeDelete},{default:i(()=>[d("Cancel")]),_:1},8,["onClick"]),e(n,{color:"blue-darken-1",variant:"text",onClick:l[5]||(l[5]=a=>t.deleteItemConfirm(t.editedItem.ct_equipment_uuid))},{default:i(()=>[d("Si, eliminar")]),_:1}),e(c)]),_:1})]),_:1})]),_:1},8,["modelValue"])]),_:1})]),"item.actions":i(({item:a})=>[t.hasPermissionTo("equipments_categories.update")?(u(),v(p,{key:0,class:"me-2",size:"small",onClick:$=>t.editItem(a)},{default:i(()=>[d(" mdi-pencil ")]),_:2},1032,["onClick"])):f("",!0),t.hasPermissionTo("equipments_categories.delete")?(u(),v(p,{key:1,size:"small",onClick:$=>t.deleteItem(a)},{default:i(()=>[d(" mdi-delete ")]),_:2},1032,["onClick"])):f("",!0)]),_:1},8,["headers","items","search"])]),_:1})]),_:1})]),_:1})])])])]),_:1})],64)}}});export{X as default};
