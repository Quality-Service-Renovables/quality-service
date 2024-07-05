import{r as b,o as R,e as Z,b as n,u as O,w as u,F as x,L as j,H as C,q as A,Z as J,a as V,d as T,c as P,s as K,x as Q,t as X,f as Y,g as M,p as ee,h as te}from"./app-BLZv_gJ1.js";import{_ as se}from"./AuthenticatedLayout-DxEDoREL.js";import{v as ae,p as oe,a as le,b as ie}from"./filepond-plugin-image-transform.esm-CaNECEkG.js";import{_ as ne}from"./_plugin-vue_export-helper-DlAUqK2U.js";import"./ApplicationLogo-Dn_PHM0t.js";/*!
 * FilePondPluginImageCrop 2.0.6
 * Licensed under MIT, https://opensource.org/licenses/MIT/
 * Please visit https://pqina.nl/filepond/ for details.
 */const F=t=>/^image/.test(t.type),$=({addFilter:t,utils:e})=>{const{Type:s,isFile:a,getNumericAspectRatioFromString:o}=e,i=(l,d)=>!(!F(l.file)||!d("GET_ALLOW_IMAGE_CROP")),f=l=>typeof l=="object",h=l=>typeof l=="number",p=(l,d)=>l.setMetadata("crop",Object.assign({},l.getMetadata("crop"),d));return t("DID_CREATE_ITEM",(l,{query:d})=>{l.extend("setImageCrop",r=>{if(!(!i(l,d)||!f(center)))return l.setMetadata("crop",r),r}),l.extend("setImageCropCenter",r=>{if(!(!i(l,d)||!f(r)))return p(l,{center:r})}),l.extend("setImageCropZoom",r=>{if(!(!i(l,d)||!h(r)))return p(l,{zoom:Math.max(1,r)})}),l.extend("setImageCropRotation",r=>{if(!(!i(l,d)||!h(r)))return p(l,{rotation:r})}),l.extend("setImageCropFlip",r=>{if(!(!i(l,d)||!f(r)))return p(l,{flip:r})}),l.extend("setImageCropAspectRatio",r=>{if(!i(l,d)||typeof r>"u")return;const k=l.getMetadata("crop"),v=o(r),_={center:{x:.5,y:.5},flip:k?Object.assign({},k.flip):{horizontal:!1,vertical:!1},rotation:0,zoom:1,aspectRatio:v};return l.setMetadata("crop",_),_})}),t("DID_LOAD_ITEM",(l,{query:d})=>new Promise((r,k)=>{const v=l.file;if(!a(v)||!F(v)||!d("GET_ALLOW_IMAGE_CROP")||l.getMetadata("crop"))return r(l);const I=d("GET_IMAGE_CROP_ASPECT_RATIO");l.setMetadata("crop",{center:{x:.5,y:.5},flip:{horizontal:!1,vertical:!1},rotation:0,zoom:1,aspectRatio:I?o(I):null}),r(l)})),{options:{allowImageCrop:[!0,s.BOOLEAN],imageCropAspectRatio:[null,s.STRING]}}},re=typeof window<"u"&&typeof window.document<"u";re&&document.dispatchEvent(new CustomEvent("FilePond:pluginloaded",{detail:$}));/*!
 * FilePondPluginImageResize 2.0.10
 * Licensed under MIT, https://opensource.org/licenses/MIT/
 * Please visit https://pqina.nl/filepond/ for details.
 */const de=t=>/^image/.test(t.type),ue=(t,e)=>{let s=new Image;s.onload=()=>{const a=s.naturalWidth,o=s.naturalHeight;s=null,e({width:a,height:o})},s.onerror=()=>e(null),s.src=t},z=({addFilter:t,utils:e})=>{const{Type:s}=e;return t("DID_LOAD_ITEM",(a,{query:o})=>new Promise((i,f)=>{const h=a.file;if(!de(h)||!o("GET_ALLOW_IMAGE_RESIZE"))return i(a);const p=o("GET_IMAGE_RESIZE_MODE"),l=o("GET_IMAGE_RESIZE_TARGET_WIDTH"),d=o("GET_IMAGE_RESIZE_TARGET_HEIGHT"),r=o("GET_IMAGE_RESIZE_UPSCALE");if(l===null&&d===null)return i(a);const k=l===null?d:l,v=d===null?k:d,_=URL.createObjectURL(h);ue(_,I=>{if(URL.revokeObjectURL(_),!I)return i(a);let{width:c,height:g}=I;const w=(a.getMetadata("exif")||{}).orientation||-1;if(w>=5&&w<=8&&([c,g]=[g,c]),c===k&&g===v)return i(a);if(!r){if(p==="cover"){if(c<=k||g<=v)return i(a)}else if(c<=k&&g<=k)return i(a)}a.setMetadata("resize",{mode:p,upscale:r,size:{width:k,height:v}}),i(a)})})),{options:{allowImageResize:[!0,s.BOOLEAN],imageResizeMode:["cover",s.STRING],imageResizeUpscale:[!0,s.BOOLEAN],imageResizeTargetWidth:[null,s.INT],imageResizeTargetHeight:[null,s.INT]}}},ce=typeof window<"u"&&typeof window.document<"u";ce&&document.dispatchEvent(new CustomEvent("FilePond:pluginloaded",{detail:z}));var me=Object.defineProperty,pe=(t,e,s)=>e in t?me(t,e,{enumerable:!0,configurable:!0,writable:!0,value:s}):t[e]=s,U=(t,e,s)=>(pe(t,typeof e!="symbol"?e+"":e,s),s);const S={"#":{pattern:/[0-9]/},"@":{pattern:/[a-zA-Z]/},"*":{pattern:/[a-zA-Z0-9]/}},D=(t,e,s)=>t.replaceAll(e,"").replace(s,".").replace("..",".").replace(/[^.\d]/g,""),G=(t,e,s)=>{var a;return new Intl.NumberFormat(((a=s.number)==null?void 0:a.locale)??"en",{minimumFractionDigits:t,maximumFractionDigits:e,roundingMode:"trunc"})},he=(t,e=!0,s)=>{var a,o,i,f;const h=((a=s.number)==null?void 0:a.unsigned)==null&&t.startsWith("-")?"-":"",p=((o=s.number)==null?void 0:o.fraction)??0;let l=G(0,p,s);const d=l.formatToParts(1000.12),r=((i=d.find(c=>c.type==="group"))==null?void 0:i.value)??" ",k=((f=d.find(c=>c.type==="decimal"))==null?void 0:f.value)??".",v=D(t,r,k);if(v===""||Number.isNaN(v))return h;const _=v.split(".");if(_[1]!=null&&_[1].length>=1){const c=_[1].length<=p?_[1].length:p;l=G(c,p,s)}let I=l.format(parseFloat(v));return e?p>0&&v.endsWith(".")&&!v.slice(0,-1).includes(".")&&(I+=k):I=D(I,r,k),h+I};class fe{constructor(e={}){U(this,"opts",{}),U(this,"memo",new Map);const s={...e};if(s.tokens!=null){s.tokens=s.tokensReplace?{...s.tokens}:{...S,...s.tokens};for(const a of Object.values(s.tokens))typeof a.pattern=="string"&&(a.pattern=new RegExp(a.pattern))}else s.tokens=S;Array.isArray(s.mask)&&(s.mask.length>1?s.mask=[...s.mask].sort((a,o)=>a.length-o.length):s.mask=s.mask[0]??""),s.mask===""&&(s.mask=null),this.opts=s}masked(e){return this.process(e,this.findMask(e))}unmasked(e){return this.process(e,this.findMask(e),!1)}isEager(){return this.opts.eager===!0}isReversed(){return this.opts.reversed===!0}completed(e){const s=this.findMask(e);if(this.opts.mask==null||s==null)return!1;const a=this.process(e,s).length;return typeof this.opts.mask=="string"?a>=this.opts.mask.length:typeof this.opts.mask=="function"?a>=s.length:this.opts.mask.filter(o=>a>=o.length).length===this.opts.mask.length}findMask(e){const s=this.opts.mask;if(s==null)return null;if(typeof s=="string")return s;if(typeof s=="function")return s(e);const a=this.process(e,s.slice(-1).pop()??"",!1);return s.find(o=>this.process(e,o,!1).length>=a.length)??""}escapeMask(e){const s=[],a=[];return e.split("").forEach((o,i)=>{o==="!"&&e[i-1]!=="!"?a.push(i-a.length):s.push(o)}),{mask:s.join(""),escaped:a}}process(e,s,a=!0){if(this.opts.number!=null)return he(e,a,this.opts);if(s==null)return e;const o=`v=${e},mr=${s},m=${a?1:0}`;if(this.memo.has(o))return this.memo.get(o);const{mask:i,escaped:f}=this.escapeMask(s),h=[],p=this.opts.tokens!=null?this.opts.tokens:{},l=this.isReversed()?-1:1,d=this.isReversed()?"unshift":"push",r=this.isReversed()?0:i.length-1,k=this.isReversed()?()=>c>-1&&g>-1:()=>c<i.length&&g<e.length,v=y=>!this.isReversed()&&y<=r||this.isReversed()&&y>=r;let _,I=-1,c=this.isReversed()?i.length-1:0,g=this.isReversed()?e.length-1:0,w=!1;for(;k();){const y=i.charAt(c),E=p[y],m=(E==null?void 0:E.transform)!=null?E.transform(e.charAt(g)):e.charAt(g);if(!f.includes(c)&&E!=null?(m.match(E.pattern)!=null?(h[d](m),E.repeated?(I===-1?I=c:c===r&&c!==I&&(c=I-l),r===I&&(c-=l)):E.multiple&&(w=!0,c-=l),c+=l):E.multiple?w&&(c+=l,g-=l,w=!1):m===_?_=void 0:E.optional&&(c+=l,g-=l),g+=l):(a&&!this.isEager()&&h[d](y),m===y&&!this.isEager()?g+=l:_=y,this.isEager()||(c+=l)),this.isEager())for(;v(c)&&(p[i.charAt(c)]==null||f.includes(c));){if(a){if(h[d](i.charAt(c)),e.charAt(g)===i.charAt(c)){c+=l,g+=l;continue}}else i.charAt(c)===e.charAt(g)&&(g+=l);c+=l}}return this.memo.set(o,h.join("")),this.memo.get(o)}}const W=t=>JSON.parse(t.replaceAll("'",'"')),ge=(t,e={})=>{const s={...e};t.dataset.maska!=null&&t.dataset.maska!==""&&(s.mask=ve(t.dataset.maska)),t.dataset.maskaEager!=null&&(s.eager=L(t.dataset.maskaEager)),t.dataset.maskaReversed!=null&&(s.reversed=L(t.dataset.maskaReversed)),t.dataset.maskaTokensReplace!=null&&(s.tokensReplace=L(t.dataset.maskaTokensReplace)),t.dataset.maskaTokens!=null&&(s.tokens=ke(t.dataset.maskaTokens));const a={};return t.dataset.maskaNumberLocale!=null&&(a.locale=t.dataset.maskaNumberLocale),t.dataset.maskaNumberFraction!=null&&(a.fraction=parseInt(t.dataset.maskaNumberFraction)),t.dataset.maskaNumberUnsigned!=null&&(a.unsigned=L(t.dataset.maskaNumberUnsigned)),(t.dataset.maskaNumber!=null||Object.values(a).length>0)&&(s.number=a),s},L=t=>t!==""?!!JSON.parse(t):!0,ve=t=>t.startsWith("[")&&t.endsWith("]")?W(t):t,ke=t=>{if(t.startsWith("{")&&t.endsWith("}"))return W(t);const e={};return t.split("|").forEach(s=>{const a=s.split(":");e[a[0]]={pattern:new RegExp(a[1]),optional:a[2]==="optional",multiple:a[2]==="multiple",repeated:a[2]==="repeated"}}),e};class Ie{constructor(e,s={}){U(this,"items",new Map),U(this,"onInput",a=>{if(a instanceof CustomEvent&&a.type==="input")return;const o=a.target,i=this.items.get(o),f="inputType"in a&&a.inputType.startsWith("delete"),h=i.isEager(),p=f&&h&&i.unmasked(o.value)===""?"":o.value;this.fixCursor(o,f,()=>this.setValue(o,p))}),this.options=s,this.init(this.getInputs(e))}update(e={}){this.options={...e},this.init(Array.from(this.items.keys()))}updateValue(e){e.value!==""&&e.value!==this.processInput(e).masked&&this.setValue(e,e.value)}destroy(){for(const e of this.items.keys())e.removeEventListener("input",this.onInput);this.items.clear()}init(e){const s=this.getOptions(this.options);for(const a of e){this.items.has(a)||a.addEventListener("input",this.onInput,{capture:!0});const o=new fe(ge(a,s));this.items.set(a,o),queueMicrotask(()=>this.updateValue(a)),a.selectionStart===null&&o.isEager()&&console.warn("Maska: input of `%s` type is not supported",a.type)}}getInputs(e){return typeof e=="string"?Array.from(document.querySelectorAll(e)):"length"in e?Array.from(e):[e]}getOptions(e){const{onMaska:s,preProcess:a,postProcess:o,...i}=e;return i}fixCursor(e,s,a){const o=e.selectionStart,i=e.value;if(a(),o===null||o===i.length&&!s)return;const f=e.value,h=i.slice(0,o),p=f.slice(0,o),l=this.processInput(e,h).unmasked,d=this.processInput(e,p).unmasked;let r=o;h!==p&&(r+=s?f.length-i.length:l.length-d.length),e.setSelectionRange(r,r)}setValue(e,s){const a=this.processInput(e,s);e.value=a.masked,this.options.onMaska!=null&&(Array.isArray(this.options.onMaska)?this.options.onMaska.forEach(o=>o(a)):this.options.onMaska(a)),e.dispatchEvent(new CustomEvent("maska",{detail:a})),e.dispatchEvent(new CustomEvent("input",{detail:a.masked}))}processInput(e,s){const a=this.items.get(e);let o=s??e.value;this.options.preProcess!=null&&(o=this.options.preProcess(o));let i=a.masked(o);return this.options.postProcess!=null&&(i=this.options.postProcess(i)),{masked:i,unmasked:a.unmasked(o),completed:a.completed(o)}}}const N=new WeakMap,be=(t,e)=>{if(t.arg==null||t.instance==null)return;const s="setup"in t.instance.$.type;t.arg in t.instance?t.instance[t.arg]=e:s&&console.warn("Maska: please expose `%s` using defineExpose",t.arg)},B=(t,e)=>{var s;const a=t instanceof HTMLInputElement?t:t.querySelector("input");if(a==null||(a==null?void 0:a.type)==="file")return;let o={};if(e.value!=null&&(o=typeof e.value=="string"?{mask:e.value}:{...e.value}),e.arg!=null){const i=f=>{const h=e.modifiers.unmasked?f.unmasked:e.modifiers.completed?f.completed:f.masked;be(e,h)};o.onMaska=o.onMaska==null?i:Array.isArray(o.onMaska)?[...o.onMaska,i]:[o.onMaska,i]}N.has(a)?(s=N.get(a))==null||s.update(o):N.set(a,new Ie(a,o))},_e=t=>(ee("data-v-14406ce1"),t=t(),te(),t),Ee=_e(()=>V("h2",{class:"font-semibold text-xl leading-tight"},"Usuarios",-1)),we={class:"py-12"},ye={class:"max-w-7xl mx-auto sm:px-4 lg:px-6"},Ce={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},Te={class:"text-h5"},H=ae(ie,le,$,z,oe),Re={directives:{maska:B},components:{Toaster:j,FilePond:H},props:{users:{type:Array,required:!0}},data(){return{search:"",dialog:!1,dialogDelete:!1,headers:[{title:"Usuario",key:"name"},{title:"Email",key:"email"},{title:"Teléfono",key:"phone"},{title:"Cliente",key:"client.client"},{title:"Rol",key:"roles[0].description"},{title:"Estado",key:"active"},{title:"Actions",key:"actions",sortable:!1}],editedIndex:-1,editedItem:{uuid:"",name:"",email:"",image_profile:"",phone:"",password:"",password_confirm:"",client_uuid:"",rol:"",active:!1},defaultItem:{uuid:"",name:"",email:"",image_profile:"",phone:"",password:"",password_confirm:"",client_uuid:"",rol:"",active:!1},roles:[],clients:[],myFiles:[],serverConfig:{process:(t,e,s,a,o,i,f)=>{this.editedItem.image_profile=e;const p=C.CancelToken.source();this.updatePhoto(p,a,o,i)}},options:{mask:"###-###-####",eager:!0},rules:{required:t=>!!t||"Requerido.",email:t=>t?/.+@.+\..+/.test(t)?!0:"Email inválido.":"Requerido.",password:t=>t.length<8?"La contraseña debe tener al menos 8 caracteres.":!0,password_confirm:t=>this.editedItem.password!==""&&this.editedItem.password===this.editedItem.password_confirm?!0:"Las contraseñas no coinciden."}}},computed:{formTitle(){return this.editedIndex===-1?"Nuevo usuario":"Editar usuario"}},watch:{dialog(t){t||this.close()},dialogDelete(t){t||this.closeDelete()}},methods:{editItem(t){this.editedIndex=this.users.indexOf(t),t.active=t.active=="1",t.client_uuid=t.client.client_uuid,t.rol=t.roles[0].name,t.image_profile&&this.setImage(t.image_profile),this.editedItem=Object.assign({},t),this.dialog=!0},setImage(t){this.myFiles=[{source:t,options:{type:"remote"}}]},deleteItem(t){this.editedIndex=this.users.indexOf(t),this.editedItem=Object.assign({},t),this.dialogDelete=!0},deleteItemConfirm(t){const e=()=>C.delete("api/users/"+t);A.promise(e,{loading:"Procesando...",success:s=>(this.closeDelete(),this.$inertia.reload(),"Usuario eliminado correctamente"),error:s=>{this.handleErrors(s)}})},close(){this.dialog=!1,this.$nextTick(()=>{console.log("Cambiando estatus en close"),this.editedItem=Object.assign({},this.defaultItem),this.editedIndex=-1,this.myFiles=[]})},closeDelete(){this.dialogDelete=!1,this.$nextTick(()=>{console.log("Cambiando estatus en closeDelete"),this.editedItem=Object.assign({},this.defaultItem),this.editedIndex=-1})},save(){if(this.editedItem.phone=this.editedItem.phone?this.editedItem.phone.replace(/-/g,""):null,this.editedIndex>-1){const t=()=>C.post("api/users/update/"+this.editedItem.uuid,this.editedItem);A.promise(t(),{loading:"Procesando...",success:e=>(this.$inertia.reload(),this.close(),"Usuario actualizado correctamente"),error:e=>{this.handleErrors(e)}})}else{const t=()=>C.post("api/users",this.editedItem);A.promise(t(),{loading:"Procesando...",success:e=>(this.$inertia.reload(),this.close(),"Usuario creado correctamente"),error:e=>{this.handleErrors(e)}})}},getColor(t){return t?"green":"red"},getRoles(){C.get("api/auth-guard/roles").then(t=>{this.roles=t.data.data}).catch(t=>{A.error("Error al cargar los roles")})},getClients(){C.get("api/clients").then(t=>{this.clients=t.data.data}).catch(t=>{A.error("Error al cargar los clientes")})},updatePhoto(t,e,s,a){return C.post("api/users/update-picture/"+this.editedItem.uuid,this.editedItem,{headers:{"Content-Type":"multipart/form-data"},cancelToken:t.token,onUploadProgress:o=>{a(o.lengthComputable,o.loaded,o.total)}}).then(o=>{e(o.data.fileId),setTimeout(()=>{console.log("Se actualizó la foto de perfil"),this.$inertia.reload(),this.setImage(o.data.data.image_profile)},1500)}).catch(o=>{C.isCancel(o)?this.abort(t):(s("Error al subir la foto."),this.handleErrors(o))})},checkPassword(){return this.editedItem.password!==""&&this.editedItem.password===this.editedItem.password_confirm}},mounted(){this.getRoles(),this.getClients()}},Ae=Object.assign(Re,{__name:"User",setup(t){return(e,s)=>{const a=b("v-icon"),o=b("v-text-field"),i=b("v-toolbar-title"),f=b("v-divider"),h=b("v-spacer"),p=b("v-btn"),l=b("v-card-title"),d=b("v-col"),r=b("v-select"),k=b("v-switch"),v=b("v-row"),_=b("v-container"),I=b("v-card-text"),c=b("v-card-actions"),g=b("v-card"),w=b("v-dialog"),y=b("v-toolbar"),E=b("v-data-table");return R(),Z(x,null,[n(O(j),{position:"top-right",richColors:"",visibleToasts:10}),n(O(J),{title:"Usuarios"}),n(se,null,{header:u(()=>[Ee]),default:u(()=>[V("div",we,[V("div",ye,[V("div",Ce,[n(g,null,{default:u(()=>[n(v,null,{default:u(()=>[n(d,{cols:"12",sm:"12"},{default:u(()=>[n(E,{headers:e.headers,items:t.users,"fixed-header":"",search:e.search},{"item.active":u(({value:m})=>[n(a,{color:e.getColor(m)},{default:u(()=>[T("mdi-circle-slice-8")]),_:2},1032,["color"])]),top:u(()=>[n(y,{flat:""},{default:u(()=>[n(i,{class:"ml-1"},{default:u(()=>[n(o,{modelValue:e.search,"onUpdate:modelValue":s[0]||(s[0]=m=>e.search=m),label:"Buscar","hide-details":"",variant:"solo","append-inner-icon":"mdi-magnify",density:"compact"},null,8,["modelValue"])]),_:1}),n(f,{class:"mx-4",inset:"",vertical:""}),n(h),e.hasPermissionTo("users.create")||e.hasPermissionTo("users.update")?(R(),P(w,{key:0,modelValue:e.dialog,"onUpdate:modelValue":s[9]||(s[9]=m=>e.dialog=m),width:"auto",scrollable:""},K({default:u(()=>[n(g,{"max-width":"100%"},{default:u(()=>[n(l,null,{default:u(()=>[V("span",Te,X(e.formTitle),1)]),_:1}),n(I,null,{default:u(()=>[n(_,null,{default:u(()=>[n(v,{class:"justify-center align-center"},{default:u(()=>[n(d,{cols:"12",lg:"4"},{default:u(()=>[n(O(H),{name:"evidence",ref:"pond","label-idle":"Arrastra y suelta tu archivo o <span class='filepond--label-action'>selecciona</span>","allow-multiple":!1,"accepted-file-types":"image/jpeg, image/png",files:e.myFiles,onInit:e.handleFilePondInit,server:e.serverConfig,instantUpload:"false",allowProcess:"true",allowReplace:"true",allowImagePreview:"true",allowUndo:"false",labelInvalidField:"Tipo de archivo no permitido",labelFileLoading:"Cargando",labelFileLoadError:"Error al subir el archivo",labelFileProcessing:"Procesando",labelFileProcessingComplete:"Proceso completado",labelFileProcessingAborted:"Proceso abortado",labelFileProcessingError:"Error al procesar",labelTapToCancel:"Toca para cancelar",labelTapToRetry:"Toca para reintentar",labelTapToUndo:"",labelButtonAbortItemLoad:"Cancelar",labelButtonRetryItemLoad:"Reintentar",labelButtonAbortItemProcessing:"Cancelar",labelButtonProcessItem:"Subir",imagePreviewHeight:"170",imageCropAspectRatio:"1:1",imageResizeTargetWidth:"200",imageResizeTargetHeight:"200",stylePanelLayout:"compact circle",styleLoadIndicatorPosition:"center bottom",styleProgressIndicatorPosition:"right bottom",styleButtonRemoveItemPosition:"left bottom",styleButtonProcessItemPosition:"right bottom"},null,8,["files","onInit","server"])]),_:1}),n(d,{cols:"12"},{default:u(()=>[n(o,{modelValue:e.editedItem.name,"onUpdate:modelValue":s[1]||(s[1]=m=>e.editedItem.name=m),label:"Nombre",variant:"outlined",rules:[e.rules.required]},null,8,["modelValue","rules"])]),_:1}),n(d,{cols:"12",lg:"6"},{default:u(()=>[n(o,{modelValue:e.editedItem.email,"onUpdate:modelValue":s[2]||(s[2]=m=>e.editedItem.email=m),label:"Email",variant:"outlined",rules:[e.rules.required,e.rules.email]},null,8,["modelValue","rules"])]),_:1}),n(d,{cols:"12",lg:"6"},{default:u(()=>[Y(n(o,{modelValue:e.editedItem.phone,"onUpdate:modelValue":s[3]||(s[3]=m=>e.editedItem.phone=m),label:"Teléfono (opcional)","data-maska-reversed":"",variant:"outlined"},null,8,["modelValue"]),[[O(B),e.options]])]),_:1}),n(d,{cols:"12",lg:"6"},{default:u(()=>[n(r,{modelValue:e.editedItem.client_uuid,"onUpdate:modelValue":s[4]||(s[4]=m=>e.editedItem.client_uuid=m),items:e.clients,label:"Cliente","item-title":"client","item-value":"client_uuid",dense:"",variant:"outlined",rules:[e.rules.required]},null,8,["modelValue","items","rules"])]),_:1}),n(d,{cols:"12",lg:"6"},{default:u(()=>[n(r,{modelValue:e.editedItem.rol,"onUpdate:modelValue":s[5]||(s[5]=m=>e.editedItem.rol=m),items:e.roles,label:"Rol","item-title":"description","item-value":"name",dense:"",variant:"outlined",rules:[e.rules.required]},null,8,["modelValue","items","rules"])]),_:1}),e.editedIndex==-1?(R(),P(d,{key:0,cols:"12",lg:"6"},{default:u(()=>[n(o,{modelValue:e.editedItem.password,"onUpdate:modelValue":s[6]||(s[6]=m=>e.editedItem.password=m),label:"Contraseña",type:"password",variant:"outlined",rules:[e.rules.required,e.rules.password],required:""},null,8,["modelValue","rules"])]),_:1})):M("",!0),e.editedIndex==-1?(R(),P(d,{key:1,cols:"12",lg:"6"},{default:u(()=>[n(o,{modelValue:e.editedItem.password_confirm,"onUpdate:modelValue":s[7]||(s[7]=m=>e.editedItem.password_confirm=m),label:"Confirmar contraseña",type:"password",variant:"outlined",rules:[e.rules.required,e.rules.password_confirm],required:""},null,8,["modelValue","rules"])]),_:1})):M("",!0),n(d,{cols:"12",lg:"3"},{default:u(()=>[n(k,{label:"Activo",modelValue:e.editedItem.active,"onUpdate:modelValue":s[8]||(s[8]=m=>e.editedItem.active=m),color:"primary",readonly:e.editedItem.roles&&e.editedItem.roles[0].name==="admin"},null,8,["modelValue","readonly"])]),_:1})]),_:1})]),_:1})]),_:1}),n(c,null,{default:u(()=>[n(h),n(p,{color:"blue-darken-1",variant:"text",onClick:e.close},{default:u(()=>[T(" Cancelar ")]),_:1},8,["onClick"]),n(p,{color:"blue-darken-1",variant:"text",onClick:e.save},{default:u(()=>[T(" Guardar ")]),_:1},8,["onClick"])]),_:1})]),_:1})]),_:2},[e.hasPermissionTo("users.create")?{name:"activator",fn:u(({props:m})=>[n(p,Q({class:"mb-2",color:"primary",dark:""},m,{icon:"mdi-plus"}),null,16)]),key:"0"}:void 0]),1032,["modelValue"])):M("",!0),n(w,{modelValue:e.dialogDelete,"onUpdate:modelValue":s[11]||(s[11]=m=>e.dialogDelete=m),"max-width":"500px"},{default:u(()=>[n(g,null,{default:u(()=>[n(l,{class:"text-h5 text-center"},{default:u(()=>[T("¿Estás seguro de eliminar?")]),_:1}),n(c,null,{default:u(()=>[n(h),n(p,{color:"blue-darken-1",variant:"text",onClick:e.closeDelete},{default:u(()=>[T("Cancel")]),_:1},8,["onClick"]),n(p,{color:"blue-darken-1",variant:"text",onClick:s[10]||(s[10]=m=>e.deleteItemConfirm(e.editedItem.uuid))},{default:u(()=>[T("Si, eliminar")]),_:1}),n(h)]),_:1})]),_:1})]),_:1},8,["modelValue"])]),_:1})]),"item.actions":u(({item:m})=>[e.hasPermissionTo("users.update")?(R(),P(a,{key:0,class:"me-2",size:"small",onClick:q=>e.editItem(m)},{default:u(()=>[T(" mdi-pencil ")]),_:2},1032,["onClick"])):M("",!0),e.hasPermissionTo("users.delete")&&m.roles[0].name!="admin"?(R(),P(a,{key:1,size:"small",onClick:q=>e.deleteItem(m)},{default:u(()=>[T(" mdi-delete ")]),_:2},1032,["onClick"])):M("",!0)]),_:1},8,["headers","items","search"])]),_:1})]),_:1})]),_:1})])])])]),_:1})],64)}}}),Ue=ne(Ae,[["__scopeId","data-v-14406ce1"]]);export{Ue as default};
