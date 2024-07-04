import{r as i,o as p,e as $,b as t,u as C,w as a,F,L as T,q as m,Z as M,a as u,d as r,c as f,s as N,x as j,t as B,g}from"./app-BOTiqfpn.js";import{_ as z}from"./AuthenticatedLayout-u_jC1oFD.js";import"./sweetalert2.all-Dnr-bOLc.js";import"./ApplicationLogo-DigZeKdz.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const R=u("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"},"Aceites",-1),S={class:"py-12"},L={class:"max-w-7xl mx-auto sm:px-4 lg:px-6"},G={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},Z={class:"text-h5"},H={components:{Toaster:T},props:{oils:{type:Array,required:!0}},data:()=>({search:"",dialog:!1,dialogDelete:!1,headers:[{title:"Aceite",key:"oil"},{title:"Viscosidad",key:"viscosity"},{title:"Descripción",key:"description"},{title:"Cantidad",key:"quantity"},{title:"Categoria",key:"category.ct_oil"},{title:"Marca",key:"trademark.trademark"},{title:"Modelo",key:"trademark.model.trademark_model"},{title:"Fecha producción",key:"production_date"},{title:"Fecha expiración",key:"expiration_date"},{title:"Estatus",key:"active"},{title:"Acciones",key:"actions",sortable:!1}],editedIndex:-1,editedItem:{oil_uuid:"",oil:"",viscosity:"",description:"",production_date:"",expiration_date:"",quantity:"",active:!1,ct_oil_code:"",trademark_code:"",trademark_model_code:""},defaultItem:{oil_uuid:"",oil:"",viscosity:"",description:"",production_date:"",expiration_date:"",quantity:"",active:!1,ct_oil_code:"",trademark_code:"",trademark_model_code:""},ct_oils:[],trademarks:[],trademark_models:[]}),computed:{formTitle(){return this.editedIndex===-1?"Nuevo aceite":"Editar aceite"}},watch:{dialog(d){d||this.close()},dialogDelete(d){d||this.closeDelete()}},methods:{editItem(d){this.editedIndex=this.oils.indexOf(d),d.active=d.active=="1",d.ct_oil_code=d.category.ct_oil_code,d.trademark_code=d.trademark.trademark_code,d.trademark_model_code=d.trademark.model.trademark_model_code,this.editedItem=Object.assign({},d),this.dialog=!0},deleteItem(d){this.editedIndex=this.oils.indexOf(d),this.editedItem=Object.assign({},d),this.dialogDelete=!0},deleteItemConfirm(d){this.oils.splice(this.editedIndex,1);const e=()=>axios.delete("api/oils/"+d);m.promise(e,{loading:"Procesando...",success:o=>(this.closeDelete(),"Aceite eliminado correctamente"),error:o=>{this.handleErrors(o)}})},close(){this.dialog=!1,this.$nextTick(()=>{console.log("Cambiando estatus en close"),this.editedItem=Object.assign({},this.defaultItem),this.editedIndex=-1})},closeDelete(){this.dialogDelete=!1,this.$nextTick(()=>{console.log("Cambiando estatus en closeDelete"),this.editedItem=Object.assign({},this.defaultItem),this.editedIndex=-1})},save(){let d={oil:this.editedItem.oil,viscosity:this.editedItem.viscosity,description:this.editedItem.description,ct_oil_code:this.editedItem.ct_oil_code,trademark_code:this.editedItem.trademark_code,trademark_model_code:this.editedItem.trademark_model_code,production_date:this.editedItem.production_date,expiration_date:this.editedItem.expiration_date,quantity:this.editedItem.quantity,active:this.editedItem.active};if(this.editedIndex>-1){const e=()=>axios.put("api/oils/"+this.editedItem.oil_uuid,d);m.promise(e(),{loading:"Procesando...",success:o=>(this.$inertia.reload(),this.close(),"Aceite actualizado correctamente"),error:o=>{this.handleErrors(o)}})}else{const e=()=>axios.post("api/oils",d);m.promise(e(),{loading:"Procesando...",success:o=>(this.$inertia.reload(),this.close(),"Aceite creado correctamente"),error:o=>{this.handleErrors(o)}})}},getColor(d){return d?"green":"red"},getOilCategories(){axios.get("api/oil/categories").then(d=>{this.ct_oils=d.data.data}).catch(d=>{m.error("Error al obtener las categorias de aceites")})},getTrademarks(){axios.get("api/trademarks").then(d=>{this.trademarks=d.data.data}).catch(d=>{m.error("Error al obtener las marcas")})},getTrademarkModels(){axios.get("api/trademark/models").then(d=>{this.trademark_models=d.data.data}).catch(d=>{m.error("Error al obtener los modelos de la marca")})}},mounted(){this.getOilCategories(),this.getTrademarks(),this.getTrademarkModels()}},Y=Object.assign(H,{__name:"Oil",setup(d){return(e,o)=>{const v=i("v-icon"),n=i("v-text-field"),D=i("v-toolbar-title"),x=i("v-divider"),_=i("v-spacer"),c=i("v-btn"),I=i("v-card-title"),s=i("v-col"),w=i("v-textarea"),h=i("v-select"),U=i("v-switch"),V=i("v-row"),q=i("v-container"),E=i("v-card-text"),y=i("v-card-actions"),k=i("v-card"),b=i("v-dialog"),O=i("v-toolbar"),A=i("v-data-table");return p(),$(F,null,[t(C(T),{position:"top-right",richColors:"",visibleToasts:10}),t(C(M),{title:"Aceites"}),t(z,null,{header:a(()=>[R]),default:a(()=>[u("div",S,[u("div",L,[u("div",G,[t(k,null,{default:a(()=>[t(V,null,{default:a(()=>[t(s,{cols:"12",sm:"12"},{default:a(()=>[t(A,{headers:e.headers,items:d.oils,"fixed-header":"",search:e.search},{"item.active":a(({value:l})=>[t(v,{color:e.getColor(l)},{default:a(()=>[r("mdi-circle-slice-8")]),_:2},1032,["color"])]),top:a(()=>[t(O,{flat:""},{default:a(()=>[t(D,{class:"ml-1"},{default:a(()=>[t(n,{modelValue:e.search,"onUpdate:modelValue":o[0]||(o[0]=l=>e.search=l),label:"Buscar","hide-details":"",variant:"solo","append-inner-icon":"mdi-magnify",density:"compact"},null,8,["modelValue"])]),_:1}),t(x,{class:"mx-4",inset:"",vertical:""}),t(_),e.hasPermissionTo("oils.create")||e.hasPermissionTo("oils.update")?(p(),f(b,{key:0,modelValue:e.dialog,"onUpdate:modelValue":o[11]||(o[11]=l=>e.dialog=l),"max-width":"500px"},N({default:a(()=>[t(k,null,{default:a(()=>[t(I,null,{default:a(()=>[u("span",Z,B(e.formTitle),1)]),_:1}),t(E,null,{default:a(()=>[t(q,null,{default:a(()=>[t(V,null,{default:a(()=>[t(s,{cols:"12"},{default:a(()=>[t(n,{modelValue:e.editedItem.oil,"onUpdate:modelValue":o[1]||(o[1]=l=>e.editedItem.oil=l),label:"Nombre",variant:"solo","hide-details":""},null,8,["modelValue"])]),_:1}),t(s,{cols:"12"},{default:a(()=>[t(n,{modelValue:e.editedItem.viscosity,"onUpdate:modelValue":o[2]||(o[2]=l=>e.editedItem.viscosity=l),label:"Viscosidad",variant:"solo","hide-details":""},null,8,["modelValue"])]),_:1}),t(s,{cols:"12"},{default:a(()=>[t(w,{modelValue:e.editedItem.description,"onUpdate:modelValue":o[3]||(o[3]=l=>e.editedItem.description=l),label:"Descripción",variant:"solo","hide-details":""},null,8,["modelValue"])]),_:1}),t(s,{cols:"12"},{default:a(()=>[t(n,{modelValue:e.editedItem.quantity,"onUpdate:modelValue":o[4]||(o[4]=l=>e.editedItem.quantity=l),label:"Cantidad",variant:"solo","hide-details":"",type:"number"},null,8,["modelValue"])]),_:1}),t(s,{cols:"12"},{default:a(()=>[t(h,{modelValue:e.editedItem.ct_oil_code,"onUpdate:modelValue":o[5]||(o[5]=l=>e.editedItem.ct_oil_code=l),items:e.ct_oils,label:"Categoria","item-title":"ct_oil","item-value":"ct_oil_code","hide-details":"",variant:"solo"},null,8,["modelValue","items"])]),_:1}),t(s,{cols:"12"},{default:a(()=>[t(h,{modelValue:e.editedItem.trademark_code,"onUpdate:modelValue":o[6]||(o[6]=l=>e.editedItem.trademark_code=l),items:e.trademarks,label:"Marca","item-title":"trademark","item-value":"trademark_code","hide-details":"",variant:"solo"},null,8,["modelValue","items"])]),_:1}),t(s,{cols:"12"},{default:a(()=>[t(h,{modelValue:e.editedItem.trademark_model_code,"onUpdate:modelValue":o[7]||(o[7]=l=>e.editedItem.trademark_model_code=l),items:e.trademark_models,label:"Modelo","item-title":"trademark_model","item-value":"trademark_model_code","hide-details":"",variant:"solo"},null,8,["modelValue","items"])]),_:1}),t(s,{cols:"12"},{default:a(()=>[t(n,{modelValue:e.editedItem.production_date,"onUpdate:modelValue":o[8]||(o[8]=l=>e.editedItem.production_date=l),label:"Fecha producción",variant:"solo","hide-details":"",type:"date"},null,8,["modelValue"])]),_:1}),t(s,{cols:"12"},{default:a(()=>[t(n,{modelValue:e.editedItem.expiration_date,"onUpdate:modelValue":o[9]||(o[9]=l=>e.editedItem.expiration_date=l),label:"Fecha expiración",variant:"solo","hide-details":"",type:"date"},null,8,["modelValue"])]),_:1}),t(s,{cols:"12"},{default:a(()=>[t(U,{label:"Activo",modelValue:e.editedItem.active,"onUpdate:modelValue":o[10]||(o[10]=l=>e.editedItem.active=l),color:"primary"},null,8,["modelValue"])]),_:1})]),_:1})]),_:1})]),_:1}),t(y,null,{default:a(()=>[t(_),t(c,{color:"blue-darken-1",variant:"text",onClick:e.close},{default:a(()=>[r(" Cancelar ")]),_:1},8,["onClick"]),t(c,{color:"blue-darken-1",variant:"text",onClick:e.save},{default:a(()=>[r(" Guardar ")]),_:1},8,["onClick"])]),_:1})]),_:1})]),_:2},[e.hasPermissionTo("oils.create")?{name:"activator",fn:a(({props:l})=>[t(c,j({class:"mb-2",color:"primary",dark:""},l,{icon:"mdi-plus"}),null,16)]),key:"0"}:void 0]),1032,["modelValue"])):g("",!0),t(b,{modelValue:e.dialogDelete,"onUpdate:modelValue":o[13]||(o[13]=l=>e.dialogDelete=l),"max-width":"500px"},{default:a(()=>[t(k,null,{default:a(()=>[t(I,{class:"text-h5 text-center"},{default:a(()=>[r("¿Estás seguro de eliminar?")]),_:1}),t(y,null,{default:a(()=>[t(_),t(c,{color:"blue-darken-1",variant:"text",onClick:e.closeDelete},{default:a(()=>[r("Cancel")]),_:1},8,["onClick"]),t(c,{color:"blue-darken-1",variant:"text",onClick:o[12]||(o[12]=l=>e.deleteItemConfirm(e.editedItem.oil_uuid))},{default:a(()=>[r("Si, eliminar")]),_:1}),t(_)]),_:1})]),_:1})]),_:1},8,["modelValue"])]),_:1})]),"item.actions":a(({item:l})=>[e.hasPermissionTo("oils.update")?(p(),f(v,{key:0,class:"me-2",size:"small",onClick:P=>e.editItem(l)},{default:a(()=>[r(" mdi-pencil ")]),_:2},1032,["onClick"])):g("",!0),e.hasPermissionTo("oils.delete")?(p(),f(v,{key:1,size:"small",onClick:P=>e.deleteItem(l)},{default:a(()=>[r(" mdi-delete ")]),_:2},1032,["onClick"])):g("",!0)]),_:1},8,["headers","items","search"])]),_:1})]),_:1})]),_:1})])])])]),_:1})],64)}}});export{Y as default};