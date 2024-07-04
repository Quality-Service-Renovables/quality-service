import{L as O,q as p,r as s,o as d,e as _,b as t,w as o,F as f,c as m,a as v,t as g,y as x,d as k,g as y}from"./app-BOTiqfpn.js";import{_ as S}from"./_plugin-vue_export-helper-DlAUqK2U.js";const $={components:{Toaster:O},data:()=>({search:"",dialog:!1,headers:[{title:"Nombre",key:"name"},{title:"Descripción",key:"description"},{title:"Acciones",key:"actions",sortable:!1}],editedIndex:-1,editedItem:{id:"",name:""},defaultItem:{id:"",name:""},loadingRoles:!1,roles:[],permissions:[]}),computed:{formTitle(){return this.editedIndex===-1?"Nuevo rol":"Editar rol"}},watch:{dialog(e){e||this.close()}},methods:{editItem(e){this.editedIndex=this.roles.indexOf(e),this.editedItem=Object.assign({},e),this.dialog=!0,this.restorePermissions(),this.hasPermissionTos()},hasPermissionTos(){this.editedItem.permissions.forEach(e=>{this.permissions.map(a=>{a.permissions.map(i=>{i.id==e.id&&(i.checked=!0)})})})},restorePermissions(){this.permissions.forEach(e=>{e.checked=!1,e.permissions.forEach(a=>{a.checked=!1})})},close(){this.dialog=!1,this.$nextTick(()=>{console.log("Cambiando estatus en close"),this.editedItem=Object.assign({},this.defaultItem),this.editedIndex=-1})},save(){console.log("Guardando...");let e=this.extractPermissions();if(console.log(e),this.editedIndex>-1){const a=()=>axios.put("api/auth-guard/role-permissions/"+this.editedItem.id,{description:this.editedItem.description,permissions:e});p.promise(a(),{loading:"Procesando...",success:i=>(this.$inertia.reload(),this.fetchRoles(),this.close(),"Rol actualizado correctamente"),error:i=>{this.handleErrors(i)}})}},fetchRoles(){return this.loadingRoles=!0,axios.get("api/auth-guard/roles").then(e=>{this.roles=e.data.data,this.loadingRoles=!1}).catch(e=>{this.loadingRoles=!1,p.error("Error al cargar el catálogo de roles")})},fetchPermissions(){return axios.get("api/auth-guard/permissions-grouped").then(e=>{this.permissions=e.data.data}).catch(e=>{p.error("Error al cargar el catálogo de permisos")})},extractPermissions(){let e=new Set;return this.permissions.forEach(a=>{a.permissions.forEach(i=>{i.checked&&(e.add(i.id),e.add(a.id))})}),Array.from(e)}},mounted(){this.fetchRoles(),this.fetchPermissions()}},j={class:"text-h5"},q={class:"text-h5"},z={class:"text-h6"};function G(e,a,i,H,J,c){const C=s("Toaster"),u=s("v-text-field"),P=s("v-toolbar-title"),b=s("v-divider"),I=s("v-spacer"),R=s("v-card-title"),n=s("v-col"),T=s("v-checkbox"),h=s("v-row"),E=s("v-container"),w=s("v-card-text"),V=s("v-btn"),N=s("v-card-actions"),U=s("v-card"),B=s("v-dialog"),A=s("v-toolbar"),D=s("v-icon"),F=s("v-data-table");return d(),_(f,null,[t(C,{position:"top-right",richColors:"",visibleToasts:10}),t(h,null,{default:o(()=>[t(n,{cols:"12",sm:"12"},{default:o(()=>[t(F,{headers:e.headers,items:e.roles,"fixed-header":"",search:e.search,loading:e.loadingRoles},{top:o(()=>[t(A,{flat:""},{default:o(()=>[t(P,{class:"ml-1"},{default:o(()=>[t(u,{modelValue:e.search,"onUpdate:modelValue":a[0]||(a[0]=l=>e.search=l),label:"Buscar","hide-details":"",variant:"solo","append-inner-icon":"mdi-magnify",density:"compact"},null,8,["modelValue"])]),_:1}),t(b,{class:"mx-4",inset:"",vertical:""}),t(I),e.hasPermissionTo("roles.update")?(d(),m(B,{key:0,modelValue:e.dialog,"onUpdate:modelValue":a[3]||(a[3]=l=>e.dialog=l),"max-width":"1200px"},{default:o(()=>[t(U,null,{default:o(()=>[t(R,null,{default:o(()=>[v("span",j,g(c.formTitle),1)]),_:1}),t(w,null,{default:o(()=>[t(E,null,{default:o(()=>[t(h,null,{default:o(()=>[t(n,{cols:"12"},{default:o(()=>[t(u,{modelValue:e.editedItem.name,"onUpdate:modelValue":a[1]||(a[1]=l=>e.editedItem.name=l),label:"Rol",variant:"solo","hide-details":"",disabled:""},null,8,["modelValue"])]),_:1}),t(n,{cols:"12"},{default:o(()=>[t(u,{modelValue:e.editedItem.description,"onUpdate:modelValue":a[2]||(a[2]=l=>e.editedItem.description=l),label:"Descripción",variant:"solo","hide-details":""},null,8,["modelValue"])]),_:1}),t(n,{cols:"12"},{default:o(()=>[t(b)]),_:1}),t(n,{cols:"12"},{default:o(()=>[v("h1",q,'Permisos del rol "'+g(e.editedItem.name)+'"',1)]),_:1}),t(n,{cols:"12"},{default:o(()=>[t(h,null,{default:o(()=>[(d(!0),_(f,null,x(e.permissions,l=>(d(),m(n,{cols:"12",lg:"4",md:"4",sm:"12",key:l.id},{default:o(()=>[v("h1",z,g(l.description),1),(d(!0),_(f,null,x(l.permissions,r=>(d(),m(T,{key:r.id,label:r.description,"hide-details":"",class:"py-0",modelValue:r.checked,"onUpdate:modelValue":L=>r.checked=L},null,8,["label","modelValue","onUpdate:modelValue"]))),128))]),_:2},1024))),128))]),_:1})]),_:1})]),_:1})]),_:1})]),_:1}),t(N,null,{default:o(()=>[t(I),t(V,{color:"blue-darken-1",variant:"text",onClick:c.close},{default:o(()=>[k(" Cancelar ")]),_:1},8,["onClick"]),t(V,{color:"blue-darken-1",variant:"text",onClick:c.save},{default:o(()=>[k(" Guardar ")]),_:1},8,["onClick"])]),_:1})]),_:1})]),_:1},8,["modelValue"])):y("",!0)]),_:1})]),"item.actions":o(({item:l})=>[e.hasPermissionTo("roles.update")?(d(),m(D,{key:0,class:"me-2",size:"small",onClick:r=>c.editItem(l)},{default:o(()=>[k(" mdi-pencil ")]),_:2},1032,["onClick"])):y("",!0)]),_:1},8,["headers","items","search","loading"])]),_:1})]),_:1})],64)}const Q=S($,[["render",G]]);export{Q as default};