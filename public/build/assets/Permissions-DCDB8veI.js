import{L as v,l as f,r as o,o as u,e as g,b as s,w as t,F as b}from"./app-iRdYC2KL.js";import{_ as P}from"./_plugin-vue_export-helper-DlAUqK2U.js";const k={components:{Toaster:v},data:()=>({search:"",headers:[{title:"Nombre",key:"name"},{title:"Código",key:"guard_name"}],loadingPermissions:!1,permissions:[]}),methods:{fetchPermissions(){return this.loadingPermissions=!0,axios.get("api/auth-guard/permissions").then(e=>{this.permissions=e.data.data,this.loadingPermissions=!1}).catch(e=>{this.loadingPermissions=!1,f.error("Error al cargar el catálogo de permisos")})}},mounted(){this.fetchPermissions()}};function w(e,a,y,C,T,V){const n=o("Toaster"),r=o("v-text-field"),i=o("v-toolbar-title"),l=o("v-divider"),d=o("v-spacer"),c=o("v-toolbar"),m=o("v-data-table"),_=o("v-col"),p=o("v-row");return u(),g(b,null,[s(n,{position:"top-right",richColors:"",visibleToasts:10}),s(p,null,{default:t(()=>[s(_,{cols:"12",sm:"12"},{default:t(()=>[s(m,{headers:e.headers,items:e.permissions,"fixed-header":"",search:e.search,loading:e.loadingPermissions},{top:t(()=>[s(c,{flat:""},{default:t(()=>[s(i,{class:"ml-1"},{default:t(()=>[s(r,{modelValue:e.search,"onUpdate:modelValue":a[0]||(a[0]=h=>e.search=h),label:"Buscar","hide-details":"",variant:"solo","append-inner-icon":"mdi-magnify",density:"compact"},null,8,["modelValue"])]),_:1}),s(l,{class:"mx-4",inset:"",vertical:""}),s(d)]),_:1})]),_:1},8,["headers","items","search","loading"])]),_:1})]),_:1})],64)}const B=P(k,[["render",w]]);export{B as default};
