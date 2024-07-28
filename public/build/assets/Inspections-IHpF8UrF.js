import{r as n,o as c,e as x,b as t,u as P,w as i,F as B,L as $,q as g,Z as z,a as r,d as a,s as A,x as F,t as R,c as v,g as p}from"./app-B-owkoAJ.js";import{_ as S}from"./AuthenticatedLayout-BV8ikpdc.js";import"./sweetalert2.all-hn7954gU.js";import O from"./Template-CGN9JMOZ.js";import"./ApplicationLogo-CBaZnFU5.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./SectionCard-B7iiHlX2.js";import"./FieldCard-htdxOTxo.js";import"./PrimaryButton-6nCxOTvR.js";const L=r("h2",{class:"font-semibold text-xl leading-tight"},"Categorias de Inspecciones",-1),G={class:"py-12"},M={class:"max-w-7xl mx-auto sm:px-4 lg:px-6"},Z={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},H={key:0},J={class:"text-h5"},K={class:"d-flex"},Q={components:{Toaster:$,TemplateInspectionCategory:O},props:{ct_inspections:{type:Array,required:!0}},data:()=>({panel:[0,1],search:"",dialog:!1,dialogDelete:!1,dialogTemplate:!1,headers:[{title:"Inspección",key:"ct_inspection"},{title:"Descripción",key:"description"},{title:"Estado",key:"active"},{title:"Actions",key:"actions",sortable:!1}],editedIndex:-1,editedItem:{ct_inspection_code:"",ct_inspection_uuid:"",ct_inspection:"",description:"",active:!1,template:{}},defaultItem:{ct_inspection_code:"",ct_inspection_uuid:"",ct_inspection:"",description:"",active:!1,template:{}}}),computed:{formTitle(){return this.editedIndex===-1?"Nueva tipo de inspección":"Editar tipo de inspección"}},watch:{dialog(o){o||this.close()},dialogDelete(o){o||this.closeDelete()}},methods:{editItem(o){this.editedIndex=this.ct_inspections.indexOf(o),o.active=o.active=="1",this.editedItem=Object.assign({},o),this.dialog=!0},deleteItem(o){this.editedIndex=this.ct_inspections.indexOf(o),this.editedItem=Object.assign({},o),this.dialogDelete=!0},deleteItemConfirm(o){this.ct_inspections.splice(this.editedIndex,1);const e=()=>axios.delete("api/inspection/categories/"+o);g.promise(e,{loading:"Procesando...",success:l=>(this.closeDelete(),"Tipo de inspección eliminado correctamente"),error:l=>{this.handleErrors(l)}})},close(){this.dialog=!1,this.$nextTick(()=>{console.log("Cambiando estatus en close"),this.editedItem=Object.assign({},this.defaultItem),this.editedIndex=-1})},closeDelete(){this.dialogDelete=!1,this.$nextTick(()=>{console.log("Cambiando estatus en closeDelete"),this.editedItem=Object.assign({},this.defaultItem),this.editedIndex=-1})},closeTemplate(){this.dialogTemplate=!1,this.editedItem.template={}},save(){if(this.editedIndex>-1){const o=()=>axios.put("api/inspection/categories/"+this.editedItem.ct_inspection_uuid,{ct_inspection:this.editedItem.ct_inspection,description:this.editedItem.description,active:this.editedItem.active});g.promise(o(),{loading:"Procesando...",success:e=>(this.$inertia.reload(),this.close(),"Tipo de inspección actualizado correctamente"),error:e=>{this.handleErrors(e)}})}else{const o=()=>axios.post("api/inspection/categories",{ct_inspection:this.editedItem.ct_inspection,description:this.editedItem.description,active:this.editedItem.active});g.promise(o(),{loading:"Procesando...",success:e=>(this.$inertia.reload(),this.close(),"Tipo de inspección creada correctamente"),error:e=>{this.handleErrors(e)}})}},getColor(o){return o?"green":"red"},showTemplate(o){return this.editedItem=Object.assign({},o),console.log("Consultando template de inspección "+o.ct_inspection_uuid),axios.get("api/inspection/forms/get-form/"+o.ct_inspection_uuid).then(e=>{this.editedItem.template=e.data.data,this.dialogTemplate=!0}).catch(e=>{console.log(e)})}}},ne=Object.assign(Q,{__name:"Inspections",setup(o){return(e,l)=>{const u=n("v-icon"),I=n("v-text-field"),b=n("v-toolbar-title"),E=n("v-divider"),m=n("v-spacer"),d=n("v-btn"),k=n("v-card-title"),_=n("v-col"),U=n("v-textarea"),j=n("v-switch"),C=n("v-row"),T=n("v-container"),V=n("v-card-text"),y=n("v-card-actions"),h=n("v-card"),f=n("v-dialog"),N=n("v-toolbar-items"),w=n("v-toolbar"),q=n("v-data-table");return c(),x(B,null,[t(P($),{position:"top-right",richColors:"",visibleToasts:10}),t(P(z),{title:"Categorias de Inspecciones"}),t(S,null,{header:i(()=>[L]),default:i(()=>[r("div",G,[r("div",M,[r("div",Z,[t(h,null,{default:i(()=>[t(C,null,{default:i(()=>[t(_,{cols:"12",sm:"12"},{default:i(()=>[t(q,{headers:e.headers,items:o.ct_inspections,"fixed-header":"",search:e.search,mobile:e.isMobile()},{"item.active":i(({value:s})=>[t(u,{color:e.getColor(s)},{default:i(()=>[a("mdi-circle-slice-8")]),_:2},1032,["color"])]),top:i(()=>[t(w,{flat:""},{default:i(()=>[t(b,{class:"ml-1"},{default:i(()=>[t(I,{modelValue:e.search,"onUpdate:modelValue":l[0]||(l[0]=s=>e.search=s),label:"Buscar","hide-details":"",variant:"solo","append-inner-icon":"mdi-magnify",density:"compact"},null,8,["modelValue"])]),_:1}),t(E,{class:"mx-4",inset:"",vertical:""}),t(m),e.hasPermissionTo("inspections.create")||e.hasPermissionTo("inspections.update")?(c(),x("div",H,[t(f,{modelValue:e.dialog,"onUpdate:modelValue":l[4]||(l[4]=s=>e.dialog=s),"max-width":"500px"},A({default:i(()=>[t(h,null,{default:i(()=>[t(k,null,{default:i(()=>[r("span",J,R(e.formTitle),1)]),_:1}),t(V,null,{default:i(()=>[t(T,null,{default:i(()=>[t(C,null,{default:i(()=>[t(_,{cols:"12"},{default:i(()=>[t(I,{modelValue:e.editedItem.ct_inspection,"onUpdate:modelValue":l[1]||(l[1]=s=>e.editedItem.ct_inspection=s),label:"Nombre",variant:"solo","hide-details":""},null,8,["modelValue"])]),_:1}),t(_,{cols:"12"},{default:i(()=>[t(U,{modelValue:e.editedItem.description,"onUpdate:modelValue":l[2]||(l[2]=s=>e.editedItem.description=s),label:"Descripción",variant:"solo","hide-details":""},null,8,["modelValue"])]),_:1}),t(_,{cols:"12"},{default:i(()=>[t(j,{label:"Activo",modelValue:e.editedItem.active,"onUpdate:modelValue":l[3]||(l[3]=s=>e.editedItem.active=s),color:"primary"},null,8,["modelValue"])]),_:1})]),_:1})]),_:1})]),_:1}),t(y,null,{default:i(()=>[t(m),t(d,{color:"blue-darken-1",variant:"text",onClick:e.close},{default:i(()=>[a(" Cancelar ")]),_:1},8,["onClick"]),t(d,{color:"blue-darken-1",variant:"text",onClick:e.save},{default:i(()=>[a(" Guardar ")]),_:1},8,["onClick"])]),_:1})]),_:1})]),_:2},[e.hasPermissionTo("inspections.create")?{name:"activator",fn:i(({props:s})=>[t(d,F({class:"mb-2",color:"primary",dark:""},s,{icon:"mdi-plus"}),null,16)]),key:"0"}:void 0]),1032,["modelValue"]),t(f,{modelValue:e.dialogTemplate,"onUpdate:modelValue":l[5]||(l[5]=s=>e.dialogTemplate=s),transition:"dialog-bottom-transition",fullscreen:"",persistent:""},{default:i(()=>[t(h,null,{default:i(()=>[t(w,null,{default:i(()=>[t(d,{icon:"mdi-close",onClick:e.closeTemplate},null,8,["onClick"]),t(b,null,{default:i(()=>[a("Template")]),_:1}),t(m),t(N,null,{default:i(()=>[t(d,{text:"Cerrar",variant:"text",onClick:e.closeTemplate},null,8,["onClick"])]),_:1})]),_:1}),t(V,null,{default:i(()=>[e.editedItem.template?(c(),v(T,{key:0},{default:i(()=>[t(O,{item:e.editedItem},null,8,["item"])]),_:1})):p("",!0)]),_:1})]),_:1})]),_:1},8,["modelValue"])])):p("",!0),t(f,{modelValue:e.dialogDelete,"onUpdate:modelValue":l[7]||(l[7]=s=>e.dialogDelete=s),"max-width":"500px"},{default:i(()=>[t(h,null,{default:i(()=>[t(k,{class:"text-h5 text-center"},{default:i(()=>[a("¿Estás seguro de eliminar?")]),_:1}),t(y,null,{default:i(()=>[t(m),t(d,{color:"blue-darken-1",variant:"text",onClick:e.closeDelete},{default:i(()=>[a("Cancel")]),_:1},8,["onClick"]),t(d,{color:"blue-darken-1",variant:"text",onClick:l[6]||(l[6]=s=>e.deleteItemConfirm(e.editedItem.ct_inspection_uuid))},{default:i(()=>[a("Si, eliminar")]),_:1}),t(m)]),_:1})]),_:1})]),_:1},8,["modelValue"])]),_:1})]),"item.actions":i(({item:s})=>[r("div",K,[e.hasPermissionTo("inspections.update")?(c(),v(u,{key:0,class:"me-2",size:"small",onClick:D=>e.editItem(s)},{default:i(()=>[a(" mdi-pencil ")]),_:2},1032,["onClick"])):p("",!0),e.hasPermissionTo("inspections.update")?(c(),v(u,{key:1,class:"me-2",size:"small",onClick:D=>e.showTemplate(s)},{default:i(()=>[a(" mdi-file-tree-outline ")]),_:2},1032,["onClick"])):p("",!0),e.hasPermissionTo("inspections.delete")?(c(),v(u,{key:2,size:"small",onClick:D=>e.deleteItem(s)},{default:i(()=>[a(" mdi-delete ")]),_:2},1032,["onClick"])):p("",!0)])]),_:1},8,["headers","items","search","mobile"])]),_:1})]),_:1})]),_:1})])])])]),_:1})],64)}}});export{ne as default};