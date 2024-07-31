import{O as g,r as p,o as t,c as i,w as c,a as r,b as l,d as T,t as b,e as u,u as w,F as V,Z as P,f as q,v as C,g as s,p as I,h as S}from"./app-CjLPoRMk.js";import{_ as B}from"./AuthenticatedLayout-CAQa14Tg.js";import{_ as f}from"./_plugin-vue_export-helper-DlAUqK2U.js";import"./ApplicationLogo-DarURmLE.js";const A={props:{path:{type:String,required:!0},title:{type:String,required:!0},icon:{type:String,required:!0}},data(){return{}},methods:{redirecTo(o){if(o.includes("http")){window.open(o,"_blank");return}g.visit(o)}}},D={class:"px-0 py-4"};function R(o,e,n,h,m,d){const k=p("v-icon"),v=p("v-card-text"),_=p("v-card");return t(),i(_,{class:"app text-center bg-surface-light",onClick:e[0]||(e[0]=Z=>d.redirecTo(n.path))},{default:c(()=>[r("div",D,[l(k,{icon:n.icon},null,8,["icon"]),l(v,{class:"title-app font-weight-black text-wrap"},{default:c(()=>[T(b(n.title),1)]),_:1})])]),_:1})}const a=f(A,[["render",R],["__scopeId","data-v-4f836228"]]),y=o=>(I("data-v-b1ca8f6a"),o=o(),S(),o),$=y(()=>r("h2",{class:"font-semibold text-xl leading-tight"},"Home",-1)),x={class:"py-12"},F={class:"max-w-7xl mx-auto sm:px-4 lg:px-6"},L={class:"search-wrapper"},N=y(()=>r("button",{class:"search-button"},[r("i",{class:"fa fa-search"})],-1)),j={key:0,class:"text-grey-darken-1"},E={class:"d-flex align-start flex-wrap"},O={key:0,class:"text-grey-darken-1"},U={class:"d-flex align-start flex-wrap"},H={data(){return{permissions:[],searchTerm:"",hideTittleSection:!1}},mounted(){this.getPermissions()},methods:{getPermissions(){},handleInput(){console.log("Búsqueda:",this.searchTerm)},checkVisivility(o){return this.hideTittleSection=this.searchTerm!="",this.searchTerm!=""?o.toLowerCase().includes(this.searchTerm.toLowerCase()):!0},checkRole(o){return o.includes(this.$page.props.auth.role.name)}}},M=Object.assign(H,{__name:"Apps",setup(o){return(e,n)=>{const h=p("v-col"),m=p("v-row");return t(),u(V,null,[l(w(P),{title:"Dashboard"}),l(B,null,{header:c(()=>[$]),default:c(()=>[r("div",x,[r("div",F,[l(m,null,{default:c(()=>[l(h,{cols:"12",class:"text-left pt-0 mb-5 pb-5"},{default:c(()=>[r("div",L,[q(r("input",{type:"text",class:"search-input",placeholder:"Buscar App","onUpdate:modelValue":n[0]||(n[0]=d=>e.searchTerm=d),onInput:n[1]||(n[1]=(...d)=>e.handleInput&&e.handleInput(...d))},null,544),[[C,e.searchTerm]]),N])]),_:1}),e.checkRole(["admin","tecnico","cliente"])?(t(),i(h,{key:0,cols:"12",lg:e.searchTerm?"12":"6",class:"text-left"},{default:c(()=>[e.hideTittleSection?s("",!0):(t(),u("h4",j,"Administración")),r("div",E,[e.checkVisivility("Dashboard")?(t(),i(a,{key:0,path:"dashboard",title:"Dashboard",icon:"mdi-monitor-dashboard"})):s("",!0),e.checkVisivility("Proyectos")&&e.hasPermissionTo("projects")?(t(),i(a,{key:1,path:"projects",title:"Proyectos",icon:"mdi-folder-text-outline"})):s("",!0),e.checkVisivility("Usuarios")&&e.hasPermissionTo("users")?(t(),i(a,{key:2,path:"users",title:"Usuarios",icon:"mdi-account-group"})):s("",!0),e.checkVisivility("Roles y permisos")&&e.hasPermissionTo("roles")?(t(),i(a,{key:3,path:"roles-permissions",title:"Roles y permisos",icon:"mdi-account-lock"})):s("",!0),e.checkVisivility("Perfil")?(t(),i(a,{key:4,path:"profile",title:"Perfil",icon:"mdi-face-man-profile"})):s("",!0),e.checkVisivility("Landing page")?(t(),i(a,{key:5,path:"https://www.qualityservicerenovables.com.mx",title:"Landing page",icon:"mdi-monitor"})):s("",!0)])]),_:1},8,["lg"])):s("",!0),e.checkRole(["admin","tecnico"])?(t(),i(h,{key:1,cols:"12",lg:e.searchTerm?"12":"6",class:"text-left"},{default:c(()=>[e.hideTittleSection?s("",!0):(t(),u("h4",O,"Configuración")),r("div",U,[e.checkVisivility("Equipos")&&e.hasPermissionTo("equipments")?(t(),i(a,{key:0,path:"equipments",title:"Equipos",icon:"mdi-clipboard-list-outline"})):s("",!0),e.checkVisivility("Categorias")&&e.hasPermissionTo("equipments_categories")?(t(),i(a,{key:1,path:"equipments-categories",title:"Categorias",icon:"mdi-list-box-outline"})):s("",!0),e.checkVisivility("Clientes")&&e.hasPermissionTo("clients")?(t(),i(a,{key:2,path:"customers",title:"Clientes",icon:"mdi-format-list-checkbox"})):s("",!0),e.checkVisivility("Inspecciones")&&e.hasPermissionTo("inspections")?(t(),i(a,{key:3,path:"inspections-categories",title:"Inspecciones",icon:"mdi-table-cog"})):s("",!0),e.checkVisivility("Fallas")&&e.hasPermissionTo("failures")?(t(),i(a,{key:4,path:"failures",title:"Fallas",icon:"mdi-playlist-remove"})):s("",!0)])]),_:1},8,["lg"])):s("",!0)]),_:1})])])]),_:1})],64)}}}),Q=f(M,[["__scopeId","data-v-b1ca8f6a"]]);export{Q as default};
