import{O as _,r as p,o as t,c as s,w as l,a as r,b as n,d as b,t as V,e as u,u as w,F as P,Z as T,f as q,v as C,g as i,p as I,h as S}from"./app-C9DKsVGQ.js";import{_ as A}from"./AuthenticatedLayout-BuM4LBJr.js";import{_ as k}from"./_plugin-vue_export-helper-DlAUqK2U.js";import"./ApplicationLogo-D3W-Zd-8.js";const B={props:{path:{type:String,required:!0},title:{type:String,required:!0},icon:{type:String,required:!0}},data(){return{}},methods:{redirecTo(a){if(a.includes("http")){window.open(a,"_blank");return}_.visit(a)}}},D={class:"px-0 py-4"};function M(a,e,c,h,m,d){const f=p("v-icon"),v=p("v-card-text"),g=p("v-card");return t(),s(g,{class:"app text-center bg-surface-light",onClick:e[0]||(e[0]=z=>d.redirecTo(c.path))},{default:l(()=>[r("div",D,[n(f,{icon:c.icon},null,8,["icon"]),n(v,{class:"title-app font-weight-black text-wrap"},{default:l(()=>[b(V(c.title),1)]),_:1})])]),_:1})}const o=k(B,[["render",M],["__scopeId","data-v-4f836228"]]),y=a=>(I("data-v-8d2424e6"),a=a(),S(),a),R=y(()=>r("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"},"Dashboard",-1)),$={class:"py-12"},E={class:"max-w-7xl mx-auto sm:px-4 lg:px-6"},F={class:"search-wrapper"},L=y(()=>r("button",{class:"search-button"},[r("i",{class:"fa fa-search"})],-1)),N={key:0,class:"text-grey-darken-1"},O={class:"d-flex align-start flex-wrap"},U={key:0,class:"text-grey-darken-1"},j={class:"d-flex align-start flex-wrap"},Z={data(){return{permissions:[],searchTerm:"",hideTittleSection:!1}},mounted(){this.getPermissions()},methods:{getPermissions(){},handleInput(){console.log("Búsqueda:",this.searchTerm)},checkVisivility(a){return this.hideTittleSection=this.searchTerm!="",this.searchTerm!=""?a.toLowerCase().includes(this.searchTerm.toLowerCase()):!0},checkRole(a){return a.includes(this.$page.props.auth.role.guard_name)}}},x=Object.assign(Z,{__name:"Apps",setup(a){return(e,c)=>{const h=p("v-col"),m=p("v-row");return t(),u(P,null,[n(w(T),{title:"Equipments"}),n(A,null,{header:l(()=>[R]),default:l(()=>[r("div",$,[r("div",E,[n(m,null,{default:l(()=>[n(h,{cols:"12",class:"text-left pt-0 mb-5 pb-5"},{default:l(()=>[r("div",F,[q(r("input",{type:"text",class:"search-input",placeholder:"Buscar App","onUpdate:modelValue":c[0]||(c[0]=d=>e.searchTerm=d),onInput:c[1]||(c[1]=(...d)=>e.handleInput&&e.handleInput(...d))},null,544),[[C,e.searchTerm]]),L])]),_:1}),e.checkRole(["admin","technical","client"])?(t(),s(h,{key:0,cols:"12",lg:e.searchTerm?"12":"6",class:"text-left"},{default:l(()=>[e.hideTittleSection?i("",!0):(t(),u("h4",N,"Administración")),r("div",O,[e.checkVisivility("Dashboard")?(t(),s(o,{key:0,path:"dashboard",title:"Dashboard",icon:"mdi-monitor-dashboard"})):i("",!0),e.checkVisivility("Proyectos")&&e.checkPermission("projects")?(t(),s(o,{key:1,path:"#",title:"Proyectos",icon:"mdi-folder-text-outline"})):i("",!0),e.checkVisivility("Usuarios")&&e.checkPermission("users")?(t(),s(o,{key:2,path:"#",title:"Usuarios",icon:"mdi-account-group"})):i("",!0),e.checkVisivility("Roles y permisos")&&e.checkPermission("roles")?(t(),s(o,{key:3,path:"roles-permissions",title:"Roles y permisos",icon:"mdi-account-lock"})):i("",!0),e.checkVisivility("Perfil")?(t(),s(o,{key:4,path:"profile",title:"Perfil",icon:"mdi-face-man-profile"})):i("",!0),e.checkVisivility("Landing page")?(t(),s(o,{key:5,path:"https://www.qualityservicerenovables.com.mx",title:"Landing page",icon:"mdi-monitor"})):i("",!0)])]),_:1},8,["lg"])):i("",!0),e.checkRole(["admin","technical"])?(t(),s(h,{key:1,cols:"12",lg:e.searchTerm?"12":"6",class:"text-left"},{default:l(()=>[e.hideTittleSection?i("",!0):(t(),u("h4",U,"Configuración")),r("div",j,[e.checkVisivility("Equipos")&&e.checkPermission("equipments")?(t(),s(o,{key:0,path:"equipments",title:"Equipos",icon:"mdi-clipboard-list-outline"})):i("",!0),e.checkVisivility("Categorias")&&e.checkPermission("equipments_categories")?(t(),s(o,{key:1,path:"equipments-categories",title:"Categorias",icon:"mdi-list-box-outline"})):i("",!0),e.checkVisivility("Clientes")&&e.checkPermission("clients")?(t(),s(o,{key:2,path:"customers",title:"Clientes",icon:"mdi-format-list-checkbox"})):i("",!0),e.checkVisivility("Inspecciones")&&e.checkPermission("inspections")?(t(),s(o,{key:3,path:"#",title:"Inspecciones",icon:"mdi-table-cog"})):i("",!0),e.checkVisivility("Fallas")&&e.checkPermission("failures")?(t(),s(o,{key:4,path:"failures",title:"Fallas",icon:"mdi-playlist-remove"})):i("",!0),e.checkVisivility("Marcas")&&e.checkPermission("trademarks")?(t(),s(o,{key:5,path:"trademarks",title:"Marcas",icon:"mdi-playlist-star"})):i("",!0),e.checkVisivility("Modelos")&&e.checkPermission("models")?(t(),s(o,{key:6,path:"models",title:"Modelos",icon:"mdi-format-list-text"})):i("",!0),e.checkVisivility("Aceites")&&e.checkPermission("oils")?(t(),s(o,{key:7,path:"oils",title:"Aceites",icon:"mdi-barrel"})):i("",!0)])]),_:1},8,["lg"])):i("",!0)]),_:1})])])]),_:1})],64)}}}),Q=k(x,[["__scopeId","data-v-8d2424e6"]]);export{Q as default};