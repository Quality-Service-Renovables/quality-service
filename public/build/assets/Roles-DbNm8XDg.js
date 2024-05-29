import{L as O,q as u,r as s,o as r,e as h,b as t,w as o,F as _,a as p,t as f,I,d as v,c as V}from"./app-Cv-EFxLF.js";import{_ as S}from"./_plugin-vue_export-helper-DlAUqK2U.js";const $={components:{Toaster:O},data:()=>({search:"",dialog:!1,headers:[{title:"Nombre",key:"name"},{title:"Acciones",key:"actions",sortable:!1}],editedIndex:-1,editedItem:{id:"",name:""},defaultItem:{id:"",name:""},loadingRoles:!1,roles:[],permissions:[]}),computed:{formTitle(){return this.editedIndex===-1?"Nuevo rol":"Editar rol"}},watch:{dialog(e){e||this.close()}},methods:{editItem(e){this.editedIndex=this.roles.indexOf(e),this.editedItem=Object.assign({},e),this.dialog=!0,this.restorePermissions(),this.checkPermissions()},checkPermissions(){this.editedItem.permissions.forEach(e=>{this.permissions.map(a=>{a.permissions.map(i=>{i.id==e.id&&(i.checked=!0)})})})},restorePermissions(){this.permissions.forEach(e=>{e.checked=!1,e.permissions.forEach(a=>{a.checked=!1})})},close(){this.dialog=!1,this.$nextTick(()=>{console.log("Cambiando estatus en close"),this.editedItem=Object.assign({},this.defaultItem),this.editedIndex=-1})},save(){console.log("Guardando...");let e=this.extractPermissions();if(console.log(e),this.editedIndex>-1){const a=()=>axios.put("api/auth-guard/role-permissions/"+this.editedItem.id,{name:this.editedItem.name,permissions:e});u.promise(a(),{loading:"Procesando...",success:i=>(this.$inertia.reload(),this.fetchRoles(),this.close(),"Rol actualizado correctamente"),error:i=>{this.handleErrors(i)}})}},fetchRoles(){return this.loadingRoles=!0,axios.get("api/auth-guard/roles").then(e=>{this.roles=e.data.data,this.loadingRoles=!1}).catch(e=>{this.loadingRoles=!1,u.error("Error al cargar el catálogo de roles")})},fetchPermissions(){return axios.get("api/auth-guard/permissions-grouped").then(e=>{this.permissions=e.data.data}).catch(e=>{u.error("Error al cargar el catálogo de permisos")})},extractPermissions(){let e=new Set;return this.permissions.forEach(a=>{a.permissions.forEach(i=>{i.checked&&(e.add(i.id),e.add(a.id))})}),Array.from(e)}},mounted(){this.fetchRoles(),this.fetchPermissions()}},j={class:"text-h5"},q={class:"text-h5"},z={class:"text-h6"};function G(e,a,i,D,H,c){const C=s("Toaster"),g=s("v-text-field"),R=s("v-toolbar-title"),k=s("v-divider"),b=s("v-spacer"),E=s("v-card-title"),n=s("v-col"),P=s("v-checkbox"),m=s("v-row"),y=s("v-container"),T=s("v-card-text"),x=s("v-btn"),w=s("v-card-actions"),N=s("v-card"),B=s("v-dialog"),U=s("v-toolbar"),A=s("v-icon"),F=s("v-data-table");return r(),h(_,null,[t(C,{position:"top-right",richColors:"",visibleToasts:10}),t(m,null,{default:o(()=>[t(n,{cols:"12",sm:"12"},{default:o(()=>[t(F,{headers:e.headers,items:e.roles,"fixed-header":"",search:e.search,loading:e.loadingRoles},{top:o(()=>[t(U,{flat:""},{default:o(()=>[t(R,{class:"ml-1"},{default:o(()=>[t(g,{modelValue:e.search,"onUpdate:modelValue":a[0]||(a[0]=l=>e.search=l),label:"Buscar","hide-details":"",variant:"solo","append-inner-icon":"mdi-magnify",density:"compact"},null,8,["modelValue"])]),_:1}),t(k,{class:"mx-4",inset:"",vertical:""}),t(b),t(B,{modelValue:e.dialog,"onUpdate:modelValue":a[2]||(a[2]=l=>e.dialog=l),"max-width":"1200px"},{default:o(()=>[t(N,null,{default:o(()=>[t(E,null,{default:o(()=>[p("span",j,f(c.formTitle),1)]),_:1}),t(T,null,{default:o(()=>[t(y,null,{default:o(()=>[t(m,null,{default:o(()=>[t(n,{cols:"12"},{default:o(()=>[t(g,{modelValue:e.editedItem.name,"onUpdate:modelValue":a[1]||(a[1]=l=>e.editedItem.name=l),label:"Nombre del rol",variant:"solo","hide-details":""},null,8,["modelValue"])]),_:1}),t(n,{cols:"12"},{default:o(()=>[t(k)]),_:1}),t(n,{cols:"12"},{default:o(()=>[p("h1",q,'Permisos del rol "'+f(e.editedItem.name)+'"',1)]),_:1}),t(n,{cols:"12"},{default:o(()=>[t(m,null,{default:o(()=>[(r(!0),h(_,null,I(e.permissions,l=>(r(),V(n,{cols:"12",lg:"4",md:"4",sm:"12",key:l.id},{default:o(()=>[p("h1",z,f(l.name),1),(r(!0),h(_,null,I(l.permissions,d=>(r(),V(P,{key:d.id,label:d.name,"hide-details":"",class:"py-0",modelValue:d.checked,"onUpdate:modelValue":L=>d.checked=L},null,8,["label","modelValue","onUpdate:modelValue"]))),128))]),_:2},1024))),128))]),_:1})]),_:1})]),_:1})]),_:1})]),_:1}),t(w,null,{default:o(()=>[t(b),t(x,{color:"blue-darken-1",variant:"text",onClick:c.close},{default:o(()=>[v(" Cancelar ")]),_:1},8,["onClick"]),t(x,{color:"blue-darken-1",variant:"text",onClick:c.save},{default:o(()=>[v(" Guardar ")]),_:1},8,["onClick"])]),_:1})]),_:1})]),_:1},8,["modelValue"])]),_:1})]),"item.actions":o(({item:l})=>[t(A,{class:"me-2",size:"small",onClick:d=>c.editItem(l)},{default:o(()=>[v(" mdi-pencil ")]),_:2},1032,["onClick"])]),_:1},8,["headers","items","search","loading"])]),_:1})]),_:1})],64)}const M=S($,[["render",G]]);export{M as default};
