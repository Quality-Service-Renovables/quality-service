import{r as s,o as d,e as O,b as t,u as I,w as a,F as U,L as w,q as f,Z as j,a as m,d as r,c,s as q,x as B,t as z,g as u}from"./app-BOTiqfpn.js";import{_ as A}from"./AuthenticatedLayout-u_jC1oFD.js";import"./sweetalert2.all-Dnr-bOLc.js";import"./ApplicationLogo-DigZeKdz.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const R=m("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"},"Fallas",-1),S={class:"py-12"},G={class:"max-w-7xl mx-auto sm:px-4 lg:px-6"},L={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},Z={class:"text-h5"},H={class:"text-right"},J={components:{Toaster:w},props:{failures:{type:Array,required:!0}},data:()=>({search:"",dialog:!1,dialogDelete:!1,headers:[{title:"Falla",key:"failure"},{title:"Estado",key:"active"},{title:"Categoría",key:"category.ct_failure"},{title:"Acciones",key:"actions",sortable:!1}],editedIndex:-1,editedItem:{failure_uuid:"",failure:"",active:!1,ct_failure_code:""},defaultItem:{failure_uuid:"",failure:"",active:!1,ct_failure_code:""},ct_failures:[],showCreateCategoryField:!1,new_ct_failure:"",loading_creating_category:!1}),computed:{formTitle(){return this.editedIndex===-1?"Nueva falla":"Editar falla"}},watch:{dialog(l){l||this.close()},dialogDelete(l){l||this.closeDelete()}},methods:{editItem(l){this.editedIndex=this.failures.indexOf(l),l.active=l.active=="1",l.ct_failure_code=l.category.ct_failure_code,this.editedItem=Object.assign({},l),this.dialog=!0},deleteItem(l){this.editedIndex=this.failures.indexOf(l),this.editedItem=Object.assign({},l),this.dialogDelete=!0},deleteItemConfirm(l){const e=()=>axios.delete("api/failures/"+l);f.promise(e,{loading:"Procesando...",success:i=>(this.closeDelete(),this.$inertia.reload(),"Falla eliminada correctamente"),error:i=>{this.handleErrors(i)}})},close(){this.dialog=!1,this.$nextTick(()=>{console.log("Cambiando estatus en close"),this.editedItem=Object.assign({},this.defaultItem),this.editedIndex=-1})},closeDelete(){this.dialogDelete=!1,this.$nextTick(()=>{console.log("Cambiando estatus en closeDelete"),this.editedItem=Object.assign({},this.defaultItem),this.editedIndex=-1})},save(){if(this.editedIndex>-1){const l=()=>axios.put("api/failures/"+this.editedItem.failure_uuid,{failure:this.editedItem.failure,active:this.editedItem.active,ct_failure_code:this.editedItem.ct_failure_code});f.promise(l(),{loading:"Procesando...",success:e=>(this.close(),this.$inertia.reload(),"Falla actualizada correctamente"),error:e=>{this.handleErrors(e)}})}else{const l=()=>axios.post("api/failures",{failure:this.editedItem.failure,active:this.editedItem.active,ct_failure_code:this.editedItem.ct_failure_code});f.promise(l(),{loading:"Procesando...",success:e=>(this.close(),this.$inertia.reload(),"Falla creada correctamente"),error:e=>{this.handleErrors(e)}})}},getColor(l){return l?"green":"red"},getfailureCategories(){axios.get("api/failure/categories").then(l=>{this.ct_failures=l.data.data}).catch(l=>{f.error("Error al cargar las categorías de fallas")})},saveCategory(){this.loading_creating_category=!0,axios.post("api/failure/categories",{ct_failure:this.new_ct_failure,active:!0}).then(async l=>{let e=l.data.data;this.loading_creating_category=!1,this.showCreateCategoryField=!1,await this.getfailureCategories(),this.new_ct_failure="",console.log("ct_failure_code: "+e.ct_failure_code),this.editedItem.ct_failure_code=e.ct_failure_code,f.success("Categoría creada correctamente")}).catch(l=>{this.loading_creating_category=!1,this.handleErrors(l)})}},mounted(){this.getfailureCategories()}},Y=Object.assign(J,{__name:"Failure",setup(l){return(e,i)=>{const g=s("v-icon"),h=s("v-text-field"),V=s("v-toolbar-title"),F=s("v-divider"),_=s("v-spacer"),n=s("v-btn"),C=s("v-card-title"),p=s("v-col"),D=s("v-select"),T=s("v-switch"),y=s("v-row"),$=s("v-container"),x=s("v-card-text"),b=s("v-card-actions"),v=s("v-card"),k=s("v-dialog"),E=s("v-toolbar"),P=s("v-data-table");return d(),O(U,null,[t(I(w),{position:"top-right",richColors:"",visibleToasts:10}),t(I(j),{title:"Fallas"}),t(A,null,{header:a(()=>[R]),default:a(()=>[m("div",S,[m("div",G,[m("div",L,[t(v,null,{default:a(()=>[t(y,null,{default:a(()=>[t(p,{cols:"12",sm:"12"},{default:a(()=>[t(P,{headers:e.headers,items:l.failures,"fixed-header":"",search:e.search},{"item.active":a(({value:o})=>[t(g,{color:e.getColor(o)},{default:a(()=>[r("mdi-circle-slice-8")]),_:2},1032,["color"])]),top:a(()=>[t(E,{flat:""},{default:a(()=>[t(V,{class:"ml-1"},{default:a(()=>[t(h,{modelValue:e.search,"onUpdate:modelValue":i[0]||(i[0]=o=>e.search=o),label:"Buscar","hide-details":"",variant:"solo","append-inner-icon":"mdi-magnify",density:"compact"},null,8,["modelValue"])]),_:1}),t(F,{class:"mx-4",inset:"",vertical:""}),t(_),e.hasPermissionTo("failures.create")||e.hasPermissionTo("failures.update")?(d(),c(k,{key:0,modelValue:e.dialog,"onUpdate:modelValue":i[8]||(i[8]=o=>e.dialog=o),"max-width":"500px"},q({default:a(()=>[t(v,null,{default:a(()=>[t(C,null,{default:a(()=>[m("span",Z,z(e.formTitle),1)]),_:1}),t(x,null,{default:a(()=>[t($,null,{default:a(()=>[t(y,null,{default:a(()=>[t(p,{cols:"12"},{default:a(()=>[t(h,{modelValue:e.editedItem.failure,"onUpdate:modelValue":i[1]||(i[1]=o=>e.editedItem.failure=o),label:"Nombre",variant:"solo","hide-details":""},null,8,["modelValue"])]),_:1}),t(p,{cols:"12"},{default:a(()=>[m("div",H,[e.showCreateCategoryField?u("",!0):(d(),c(n,{key:0,density:"compact","prepend-icon":"mdi-plus",class:"mb-1 pr-0 text-none text-primary",variant:"plain",onClick:i[2]||(i[2]=o=>e.showCreateCategoryField=!0)},{default:a(()=>[r("Nueva categoría")]),_:1})),e.showCreateCategoryField&&!e.loading_creating_category?(d(),c(n,{key:1,density:"compact","prepend-icon":"mdi-close",class:"mb-1 pr-0 text-none text-red",variant:"plain",onClick:i[3]||(i[3]=o=>e.showCreateCategoryField=!1)},{default:a(()=>[r("Cancelar")]),_:1})):u("",!0),e.showCreateCategoryField?(d(),c(n,{key:2,density:"compact","prepend-icon":"mdi-content-save-check-outline",class:"mb-1 pr-0 text-none text-primary",variant:"plain",onClick:i[4]||(i[4]=o=>e.saveCategory()),loading:e.loading_creating_category,disabled:!e.new_ct_failure},{default:a(()=>[r("Guardar")]),_:1},8,["loading","disabled"])):u("",!0)]),e.showCreateCategoryField?u("",!0):(d(),c(D,{key:0,modelValue:e.editedItem.ct_failure_code,"onUpdate:modelValue":i[5]||(i[5]=o=>e.editedItem.ct_failure_code=o),items:e.ct_failures,"item-title":"ct_failure","item-value":"ct_failure_code",label:"Categoría",variant:"solo","hide-details":""},null,8,["modelValue","items"])),e.showCreateCategoryField?(d(),c(h,{key:1,modelValue:e.new_ct_failure,"onUpdate:modelValue":i[6]||(i[6]=o=>e.new_ct_failure=o),label:"Categoría",variant:"solo","hide-details":""},null,8,["modelValue"])):u("",!0)]),_:1}),t(p,{cols:"12"},{default:a(()=>[t(T,{label:"Activo",modelValue:e.editedItem.active,"onUpdate:modelValue":i[7]||(i[7]=o=>e.editedItem.active=o),color:"primary"},null,8,["modelValue"])]),_:1})]),_:1})]),_:1})]),_:1}),t(b,null,{default:a(()=>[t(_),t(n,{color:"blue-darken-1",variant:"text",onClick:e.close},{default:a(()=>[r(" Cancelar ")]),_:1},8,["onClick"]),t(n,{color:"blue-darken-1",variant:"text",onClick:e.save,disabled:e.showCreateCategoryField},{default:a(()=>[r(" Guardar ")]),_:1},8,["onClick","disabled"])]),_:1})]),_:1})]),_:2},[e.hasPermissionTo("failures.create")?{name:"activator",fn:a(({props:o})=>[t(n,B({class:"mb-2",color:"primary",dark:""},o,{icon:"mdi-plus"}),null,16)]),key:"0"}:void 0]),1032,["modelValue"])):u("",!0),t(k,{modelValue:e.dialogDelete,"onUpdate:modelValue":i[10]||(i[10]=o=>e.dialogDelete=o),"max-width":"500px"},{default:a(()=>[t(v,null,{default:a(()=>[t(C,{class:"text-h5 text-center"},{default:a(()=>[r("¿Estás seguro de eliminar?")]),_:1}),t(b,null,{default:a(()=>[t(_),t(n,{color:"blue-darken-1",variant:"text",onClick:e.closeDelete},{default:a(()=>[r("Cancel")]),_:1},8,["onClick"]),t(n,{color:"blue-darken-1",variant:"text",onClick:i[9]||(i[9]=o=>e.deleteItemConfirm(e.editedItem.failure_uuid))},{default:a(()=>[r("Si, eliminar")]),_:1}),t(_)]),_:1})]),_:1})]),_:1},8,["modelValue"])]),_:1})]),"item.actions":a(({item:o})=>[e.hasPermissionTo("failures.update")?(d(),c(g,{key:0,class:"me-2",size:"small",onClick:N=>e.editItem(o)},{default:a(()=>[r(" mdi-pencil ")]),_:2},1032,["onClick"])):u("",!0),e.hasPermissionTo("failures.delete")?(d(),c(g,{key:1,size:"small",onClick:N=>e.deleteItem(o)},{default:a(()=>[r(" mdi-delete ")]),_:2},1032,["onClick"])):u("",!0)]),_:1},8,["headers","items","search"])]),_:1})]),_:1})]),_:1})])])])]),_:1})],64)}}});export{Y as default};