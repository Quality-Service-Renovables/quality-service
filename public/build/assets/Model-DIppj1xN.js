import{r as l,o as u,e as N,b as t,u as V,w as a,F as U,L as y,q as _,Z as j,a as n,d as r,c as p,s as q,x as B,t as z,g as k}from"./app-DHtr17ZB.js";import{_ as A}from"./AuthenticatedLayout-BWmW5bik.js";import"./sweetalert2.all-Cte-CPa1.js";import"./ApplicationLogo-fH9I3PiO.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const F=n("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"},"Modelos",-1),R={class:"py-12"},S={class:"max-w-7xl mx-auto sm:px-4 lg:px-6"},L={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},G={class:"text-h5"},Z={components:{Toaster:y},props:{models:{type:Array,required:!0}},data:()=>({search:"",dialog:!1,dialogDelete:!1,headers:[{title:"Modelo",key:"trademark_model"},{title:"Marca",key:"trademark.trademark"},{title:"Estado",key:"active"},{title:"Actions",key:"actions",sortable:!1}],editedIndex:-1,editedItem:{trademark_model_uuid:"",trademark_model:"",trademark_code:"",active:!1},defaultItem:{trademark_model_uuid:"",trademark_model:"",trademark_code:"",active:!1},trademarks:[]}),computed:{formTitle(){return this.editedIndex===-1?"Nuevo modelo":"Editar modelo"}},watch:{dialog(o){o||this.close()},dialogDelete(o){o||this.closeDelete()}},methods:{editItem(o){this.editedIndex=this.models.indexOf(o),o.active=o.active=="1",o.trademark_code=o.trademark.trademark_code,this.editedItem=Object.assign({},o),this.dialog=!0},deleteItem(o){this.editedIndex=this.models.indexOf(o),this.editedItem=Object.assign({},o),this.dialogDelete=!0},deleteItemConfirm(o){const e=()=>axios.delete("api/trademark/models/"+o);_.promise(e,{loading:"Procesando...",success:s=>(this.closeDelete(),this.$inertia.reload(),"Modelo eliminada correctamente"),error:s=>{this.handleErrors(s)}})},close(){this.dialog=!1,this.$nextTick(()=>{console.log("Cambiando estatus en close"),this.editedItem=Object.assign({},this.defaultItem),this.editedIndex=-1})},closeDelete(){this.dialogDelete=!1,this.$nextTick(()=>{console.log("Cambiando estatus en closeDelete"),this.editedItem=Object.assign({},this.defaultItem),this.editedIndex=-1})},save(){if(this.editedIndex>-1){const o=()=>axios.put("api/trademark/models/"+this.editedItem.trademark_model_uuid,{trademark_model:this.editedItem.trademark_model,trademark_code:this.editedItem.trademark_code,active:this.editedItem.active});_.promise(o(),{loading:"Procesando...",success:e=>(this.$inertia.reload(),this.close(),"Modelo actualizada correctamente"),error:e=>{this.handleErrors(e)}})}else{const o=()=>axios.post("api/trademark/models",{trademark_model:this.editedItem.trademark_model,trademark_code:this.editedItem.trademark_code,active:this.editedItem.active});_.promise(o(),{loading:"Procesando...",success:e=>(this.$inertia.reload(),this.close(),"Modelo creada correctamente"),error:e=>{this.handleErrors(e)}})}},getColor(o){return o?"green":"red"},getTrademarks(){axios.get("api/trademarks").then(o=>{this.trademarks=o.data.data}).catch(o=>{_.error("Error al cargar las marcas")})}},mounted(){this.getTrademarks()}},X=Object.assign(Z,{__name:"Model",setup(o){return(e,s)=>{const h=l("v-icon"),f=l("v-text-field"),x=l("v-toolbar-title"),T=l("v-divider"),m=l("v-spacer"),i=l("v-btn"),g=l("v-card-title"),c=l("v-col"),w=l("v-select"),D=l("v-switch"),I=l("v-row"),M=l("v-container"),P=l("v-card-text"),b=l("v-card-actions"),v=l("v-card"),C=l("v-dialog"),$=l("v-toolbar"),E=l("v-data-table");return u(),N(U,null,[t(V(y),{position:"top-right",richColors:"",visibleToasts:10}),t(V(j),{title:"Modelos"}),t(A,null,{header:a(()=>[F]),default:a(()=>[n("div",R,[n("div",S,[n("div",L,[t(v,null,{default:a(()=>[t(I,null,{default:a(()=>[t(c,{cols:"12",sm:"12"},{default:a(()=>[t(E,{headers:e.headers,items:o.models,"fixed-header":"",search:e.search},{"item.active":a(({value:d})=>[t(h,{color:e.getColor(d)},{default:a(()=>[r("mdi-circle-slice-8")]),_:2},1032,["color"])]),top:a(()=>[t($,{flat:""},{default:a(()=>[t(x,{class:"ml-1"},{default:a(()=>[t(f,{modelValue:e.search,"onUpdate:modelValue":s[0]||(s[0]=d=>e.search=d),label:"Buscar","hide-details":"",variant:"solo","append-inner-icon":"mdi-magnify",density:"compact"},null,8,["modelValue"])]),_:1}),t(T,{class:"mx-4",inset:"",vertical:""}),t(m),e.hasPermissionTo("models.create")||e.hasPermissionTo("models.update")?(u(),p(C,{key:0,modelValue:e.dialog,"onUpdate:modelValue":s[4]||(s[4]=d=>e.dialog=d),"max-width":"500px"},q({default:a(()=>[t(v,null,{default:a(()=>[t(g,null,{default:a(()=>[n("span",G,z(e.formTitle),1)]),_:1}),t(P,null,{default:a(()=>[t(M,null,{default:a(()=>[t(I,null,{default:a(()=>[t(c,{cols:"12"},{default:a(()=>[t(f,{modelValue:e.editedItem.trademark_model,"onUpdate:modelValue":s[1]||(s[1]=d=>e.editedItem.trademark_model=d),label:"Nombre",variant:"solo","hide-details":""},null,8,["modelValue"])]),_:1}),t(c,{cols:"12"},{default:a(()=>[t(w,{modelValue:e.editedItem.trademark_code,"onUpdate:modelValue":s[2]||(s[2]=d=>e.editedItem.trademark_code=d),items:e.trademarks,"item-title":"trademark","item-value":"trademark_code",label:"Marca",variant:"solo","hide-details":""},null,8,["modelValue","items"])]),_:1}),t(c,{cols:"12"},{default:a(()=>[t(D,{label:"Activo",modelValue:e.editedItem.active,"onUpdate:modelValue":s[3]||(s[3]=d=>e.editedItem.active=d),color:"primary"},null,8,["modelValue"])]),_:1})]),_:1})]),_:1})]),_:1}),t(b,null,{default:a(()=>[t(m),t(i,{color:"blue-darken-1",variant:"text",onClick:e.close},{default:a(()=>[r(" Cancelar ")]),_:1},8,["onClick"]),t(i,{color:"blue-darken-1",variant:"text",onClick:e.save},{default:a(()=>[r(" Guardar ")]),_:1},8,["onClick"])]),_:1})]),_:1})]),_:2},[e.hasPermissionTo("models.create")?{name:"activator",fn:a(({props:d})=>[t(i,B({class:"mb-2",color:"primary",dark:""},d,{icon:"mdi-plus"}),null,16)]),key:"0"}:void 0]),1032,["modelValue"])):k("",!0),t(C,{modelValue:e.dialogDelete,"onUpdate:modelValue":s[6]||(s[6]=d=>e.dialogDelete=d),"max-width":"500px"},{default:a(()=>[t(v,null,{default:a(()=>[t(g,{class:"text-h5 text-center"},{default:a(()=>[r("¿Estás seguro de eliminar?")]),_:1}),t(b,null,{default:a(()=>[t(m),t(i,{color:"blue-darken-1",variant:"text",onClick:e.closeDelete},{default:a(()=>[r("Cancel")]),_:1},8,["onClick"]),t(i,{color:"blue-darken-1",variant:"text",onClick:s[5]||(s[5]=d=>e.deleteItemConfirm(e.editedItem.trademark_model_uuid))},{default:a(()=>[r("Si, eliminar")]),_:1}),t(m)]),_:1})]),_:1})]),_:1},8,["modelValue"])]),_:1})]),"item.actions":a(({item:d})=>[e.hasPermissionTo("models.update")?(u(),p(h,{key:0,class:"me-2",size:"small",onClick:O=>e.editItem(d)},{default:a(()=>[r(" mdi-pencil ")]),_:2},1032,["onClick"])):k("",!0),e.hasPermissionTo("models.delete")?(u(),p(h,{key:1,size:"small",onClick:O=>e.deleteItem(d)},{default:a(()=>[r(" mdi-delete ")]),_:2},1032,["onClick"])):k("",!0)]),_:1},8,["headers","items","search"])]),_:1})]),_:1})]),_:1})])])])]),_:1})],64)}}});export{X as default};
