import{r as s,o as u,e as j,b as t,u as k,w as i,F as N,L as V,q as h,Z as U,a as r,d,c as v,s as B,x as z,t as A,g as f}from"./app-D4wGiOJT.js";import{_ as F}from"./AuthenticatedLayout-GMy0t1fc.js";import"./sweetalert2.all-DUHnw1ga.js";import"./ApplicationLogo-Hqcxf12t.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const R=r("h2",{class:"font-semibold text-xl leading-tight"},"Categorias de Equipos",-1),S={class:"py-12"},L={class:"max-w-7xl mx-auto sm:px-4 lg:px-6"},G={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},M={class:"text-h5"},Z={components:{Toaster:V},props:{ct_equipments:{type:Array,required:!0}},data:()=>({search:"",dialog:!1,dialogDelete:!1,headers:[{title:"Categoria",key:"ct_equipment"},{title:"Descripción",key:"description"},{title:"Estado",key:"active"},{title:"Actions",key:"actions",sortable:!1}],editedIndex:-1,editedItem:{ct_equipment_uuid:"",ct_equipment:"",description:"",active:!1},defaultItem:{ct_equipment_uuid:"",ct_equipment:"",description:"",active:!1}}),computed:{formTitle(){return this.editedIndex===-1?"Nueva categoria":"Editar categoria"}},watch:{dialog(o){o||this.close()},dialogDelete(o){o||this.closeDelete()}},methods:{editItem(o){this.editedIndex=this.ct_equipments.indexOf(o),o.active=o.active=="1",this.editedItem=Object.assign({},o),this.dialog=!0},deleteItem(o){this.editedIndex=this.ct_equipments.indexOf(o),this.editedItem=Object.assign({},o),this.dialogDelete=!0},deleteItemConfirm(o){this.ct_equipments.splice(this.editedIndex,1);const e=()=>axios.delete("api/equipment/categories/"+o);h.promise(e,{loading:"Procesando...",success:l=>(this.closeDelete(),"Categoria eliminada correctamente"),error:l=>{this.handleErrors(l)}})},close(){this.dialog=!1,this.$nextTick(()=>{console.log("Cambiando estatus en close"),this.editedItem=Object.assign({},this.defaultItem),this.editedIndex=-1})},closeDelete(){this.dialogDelete=!1,this.$nextTick(()=>{console.log("Cambiando estatus en closeDelete"),this.editedItem=Object.assign({},this.defaultItem),this.editedIndex=-1})},save(){if(this.editedIndex>-1){Object.assign(this.ct_equipments[this.editedIndex],this.editedItem);const o=()=>axios.put("api/equipment/categories/"+this.editedItem.ct_equipment_uuid,{ct_equipment:this.editedItem.ct_equipment,description:this.editedItem.description,active:this.editedItem.active});h.promise(o(),{loading:"Procesando...",success:e=>(this.$inertia.reload(),this.close(),"Categoria actualizada correctamente"),error:e=>{this.handleErrors(e)}})}else{this.ct_equipments.push(this.editedItem);const o=()=>axios.post("api/equipment/categories",{ct_equipment:this.editedItem.ct_equipment,description:this.editedItem.description,active:this.editedItem.active});h.promise(o(),{loading:"Procesando...",success:e=>(this.$inertia.reload(),this.close(),"Categoria creada correctamente"),error:e=>{this.handleErrors(e)}})}},getColor(o){return o?"green":"red"}}},X=Object.assign(Z,{__name:"EquipmentCategories",setup(o){return(e,l)=>{const p=s("v-icon"),g=s("v-text-field"),x=s("v-toolbar-title"),y=s("v-divider"),c=s("v-spacer"),n=s("v-btn"),I=s("v-card-title"),m=s("v-col"),D=s("v-textarea"),w=s("v-switch"),q=s("v-row"),T=s("v-container"),E=s("v-card-text"),b=s("v-card-actions"),_=s("v-card"),C=s("v-dialog"),P=s("v-toolbar"),O=s("v-data-table");return u(),j(N,null,[t(k(V),{position:"top-right",richColors:"",visibleToasts:10}),t(k(U),{title:"Categorias de Equipos"}),t(F,null,{header:i(()=>[R]),default:i(()=>[r("div",S,[r("div",L,[r("div",G,[t(_,null,{default:i(()=>[t(q,null,{default:i(()=>[t(m,{cols:"12",sm:"12"},{default:i(()=>[t(O,{headers:e.headers,items:o.ct_equipments,"fixed-header":"",search:e.search,mobile:e.isMobile()},{"item.active":i(({value:a})=>[t(p,{color:e.getColor(a)},{default:i(()=>[d("mdi-circle-slice-8")]),_:2},1032,["color"])]),top:i(()=>[t(P,{flat:""},{default:i(()=>[t(x,{class:"ml-1"},{default:i(()=>[t(g,{modelValue:e.search,"onUpdate:modelValue":l[0]||(l[0]=a=>e.search=a),label:"Buscar","hide-details":"",variant:"solo","append-inner-icon":"mdi-magnify",density:"compact"},null,8,["modelValue"])]),_:1}),t(y,{class:"mx-4",inset:"",vertical:""}),t(c),e.hasPermissionTo("equipments_categories.create")||e.hasPermissionTo("equipments_categories.update")?(u(),v(C,{key:0,modelValue:e.dialog,"onUpdate:modelValue":l[4]||(l[4]=a=>e.dialog=a),"max-width":"500px"},B({default:i(()=>[t(_,null,{default:i(()=>[t(I,null,{default:i(()=>[r("span",M,A(e.formTitle),1)]),_:1}),t(E,null,{default:i(()=>[t(T,null,{default:i(()=>[t(q,null,{default:i(()=>[t(m,{cols:"12"},{default:i(()=>[t(g,{modelValue:e.editedItem.ct_equipment,"onUpdate:modelValue":l[1]||(l[1]=a=>e.editedItem.ct_equipment=a),label:"Nombre",variant:"solo","hide-details":""},null,8,["modelValue"])]),_:1}),t(m,{cols:"12"},{default:i(()=>[t(D,{modelValue:e.editedItem.description,"onUpdate:modelValue":l[2]||(l[2]=a=>e.editedItem.description=a),label:"Descripción",variant:"solo","hide-details":""},null,8,["modelValue"])]),_:1}),t(m,{cols:"12"},{default:i(()=>[t(w,{label:"Activo",modelValue:e.editedItem.active,"onUpdate:modelValue":l[3]||(l[3]=a=>e.editedItem.active=a),color:"primary"},null,8,["modelValue"])]),_:1})]),_:1})]),_:1})]),_:1}),t(b,null,{default:i(()=>[t(c),t(n,{color:"blue-darken-1",variant:"text",onClick:e.close},{default:i(()=>[d(" Cancelar ")]),_:1},8,["onClick"]),t(n,{color:"blue-darken-1",variant:"text",onClick:e.save},{default:i(()=>[d(" Guardar ")]),_:1},8,["onClick"])]),_:1})]),_:1})]),_:2},[e.hasPermissionTo("equipments_categories.create")?{name:"activator",fn:i(({props:a})=>[t(n,z({class:"mb-2",color:"primary",dark:""},a,{icon:"mdi-plus"}),null,16)]),key:"0"}:void 0]),1032,["modelValue"])):f("",!0),t(C,{modelValue:e.dialogDelete,"onUpdate:modelValue":l[6]||(l[6]=a=>e.dialogDelete=a),"max-width":"500px"},{default:i(()=>[t(_,null,{default:i(()=>[t(I,{class:"text-h5 text-center"},{default:i(()=>[d("¿Estás seguro de eliminar?")]),_:1}),t(b,null,{default:i(()=>[t(c),t(n,{color:"blue-darken-1",variant:"text",onClick:e.closeDelete},{default:i(()=>[d("Cancel")]),_:1},8,["onClick"]),t(n,{color:"blue-darken-1",variant:"text",onClick:l[5]||(l[5]=a=>e.deleteItemConfirm(e.editedItem.ct_equipment_uuid))},{default:i(()=>[d("Si, eliminar")]),_:1}),t(c)]),_:1})]),_:1})]),_:1},8,["modelValue"])]),_:1})]),"item.actions":i(({item:a})=>[e.hasPermissionTo("equipments_categories.update")?(u(),v(p,{key:0,class:"me-2",size:"small",onClick:$=>e.editItem(a)},{default:i(()=>[d(" mdi-pencil ")]),_:2},1032,["onClick"])):f("",!0),e.hasPermissionTo("equipments_categories.delete")?(u(),v(p,{key:1,size:"small",onClick:$=>e.deleteItem(a)},{default:i(()=>[d(" mdi-delete ")]),_:2},1032,["onClick"])):f("",!0)]),_:1},8,["headers","items","search","mobile"])]),_:1})]),_:1})]),_:1})])])])]),_:1})],64)}}});export{X as default};