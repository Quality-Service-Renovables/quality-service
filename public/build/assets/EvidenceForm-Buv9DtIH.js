import{L as W,H as C,q as G,r as I,o as P,e as B,c as w,w as f,b as s,F as Y,a as U,n as X,g as V,d as O,t as z,p as j,h as K}from"./app-DHQkOlst.js";import"./sweetalert2.all-CIoFQGsi.js";import{v as Z,p as J,a as Q,b as $}from"./filepond-plugin-image-transform.esm-D0fMk-a-.js";import ee from"./ImageEditor-BO27gF6L.js";import{_ as te}from"./_plugin-vue_export-helper-DlAUqK2U.js";import"./PrimaryButton-kNMMRUtt.js";/*!
 * FilePondPluginFilePoster 2.5.1
 * Licensed under MIT, https://opensource.org/licenses/MIT/
 * Please visit https://pqina.nl/filepond/ for details.
 */const N={type:"spring",stiffness:.5,damping:.45,mass:10},ie=i=>i.utils.createView({name:"file-poster",tag:"div",ignoreRect:!0,create:({root:t})=>{t.ref.image=document.createElement("img"),t.element.appendChild(t.ref.image)},write:i.utils.createRoute({DID_FILE_POSTER_LOAD:({root:t,props:n})=>{const{id:r}=n,e=t.query("GET_ITEM",{id:n.id});if(!e)return;const l=e.getMetadata("poster");t.ref.image.src=l,t.dispatch("DID_FILE_POSTER_DRAW",{id:r})}}),mixins:{styles:["scaleX","scaleY","opacity"],animations:{scaleX:N,scaleY:N,opacity:{type:"tween",duration:750}}}}),ae=(i,t)=>{t.width=i.width,t.height=i.height,t.getContext("2d").drawImage(i,0,0)},ne=i=>i.utils.createView({name:"file-poster-overlay",tag:"canvas",ignoreRect:!0,create:({root:t,props:n})=>{ae(n.template,t.element)},mixins:{styles:["opacity"],animations:{opacity:{type:"spring",mass:25}}}}),oe=(i,t)=>{let n=new Image;n.onload=()=>{const r=n.naturalWidth,e=n.naturalHeight;n=null,t(r,e)},n.src=i},le=i=>-.5*(Math.cos(Math.PI*i)-1),re=(i,t,n=1,r=le,e=10,l=0)=>{const c=1-l,d=t.join(",");for(let u=0;u<=e;u++){const a=u/e,_=l+c*a;i.addColorStop(_,`rgba(${d}, ${r(a)*n})`)}},se=10,ce=10,de=i=>{const t=Math.min(se/i.width,ce/i.height),n=document.createElement("canvas"),r=n.getContext("2d"),e=n.width=Math.ceil(i.width*t),l=n.height=Math.ceil(i.height*t);r.drawImage(i,0,0,e,l);let c=null;try{c=r.getImageData(0,0,e,l).data}catch{return null}const d=c.length;let u=0,a=0,_=0,p=0;for(;p<d;p+=4)u+=c[p]*c[p],a+=c[p+1]*c[p+1],_+=c[p+2]*c[p+2];return u=M(u,d),a=M(a,d),_=M(_,d),{r:u,g:a,b:_}},M=(i,t)=>Math.floor(Math.sqrt(i/(t/4))),R=(i,t,n,r,e)=>{i.width=t,i.height=n;const l=i.getContext("2d"),c=t*.5,d=l.createRadialGradient(c,n+110,n-100,c,n+110,n+100);re(d,r,e,void 0,8,.4),l.save(),l.translate(-t*.5,0),l.scale(2,1),l.fillStyle=d,l.fillRect(0,0,t,n),l.restore()},F=typeof navigator<"u",S=500,D=200,x=F&&document.createElement("canvas"),H=F&&document.createElement("canvas"),k=F&&document.createElement("canvas");let A=[40,40,40],L=[196,78,71],b=[54,151,99];F&&(R(x,S,D,A,.85),R(H,S,D,L,1),R(k,S,D,b,1));const ue=(i,t)=>new Promise((n,r)=>{const e=new Image;typeof crossOrigin=="string"&&(e.crossOrigin=t),e.onload=()=>{n(e)},e.onerror=l=>{r(l)},e.src=i}),pe=i=>{const t=ne(i),n=({root:a,props:_})=>{const{id:p}=_,h=a.query("GET_ITEM",p);if(!h)return;const v=h.getMetadata("poster"),y=o=>{const m=a.query("GET_FILE_POSTER_CALCULATE_AVERAGE_IMAGE_COLOR")?de(o):null;h.setMetadata("color",m,!0),a.dispatch("DID_FILE_POSTER_LOAD",{id:p,data:o})};oe(v,(o,m)=>{a.dispatch("DID_FILE_POSTER_CALCULATE_SIZE",{id:p,width:o,height:m}),ue(v,a.query("GET_FILE_POSTER_CROSS_ORIGIN_ATTRIBUTE_VALUE")).then(y)})},r=({root:a})=>{a.ref.overlayShadow.opacity=1},e=({root:a})=>{const{image:_}=a.ref;_.scaleX=1,_.scaleY=1,_.opacity=1},l=({root:a})=>{a.ref.overlayShadow.opacity=1,a.ref.overlayError.opacity=0,a.ref.overlaySuccess.opacity=0},c=({root:a})=>{a.ref.overlayShadow.opacity=.25,a.ref.overlayError.opacity=1},d=({root:a})=>{a.ref.overlayShadow.opacity=.25,a.ref.overlaySuccess.opacity=1},u=({root:a,props:_})=>{const p=a.query("GET_FILE_POSTER_ITEM_OVERLAY_SHADOW_COLOR"),h=a.query("GET_FILE_POSTER_ITEM_OVERLAY_ERROR_COLOR"),v=a.query("GET_FILE_POSTER_ITEM_OVERLAY_SUCCESS_COLOR");p&&p!==A&&(A=p,R(x,S,D,A,.85)),h&&h!==L&&(L=h,R(H,S,D,L,1)),v&&v!==b&&(b=v,R(k,S,D,b,1));const y=ie(i);a.ref.image=a.appendChildView(a.createChildView(y,{id:_.id,scaleX:1.25,scaleY:1.25,opacity:0})),a.ref.overlayShadow=a.appendChildView(a.createChildView(t,{template:x,opacity:0})),a.ref.overlaySuccess=a.appendChildView(a.createChildView(t,{template:k,opacity:0})),a.ref.overlayError=a.appendChildView(a.createChildView(t,{template:H,opacity:0}))};return i.utils.createView({name:"file-poster-wrapper",create:u,write:i.utils.createRoute({DID_FILE_POSTER_LOAD:r,DID_FILE_POSTER_DRAW:e,DID_FILE_POSTER_CONTAINER_CREATE:n,DID_THROW_ITEM_LOAD_ERROR:c,DID_THROW_ITEM_PROCESSING_ERROR:c,DID_THROW_ITEM_INVALID:c,DID_COMPLETE_ITEM_PROCESSING:d,DID_START_ITEM_PROCESSING:l,DID_REVERT_ITEM_PROCESSING:l})})},q=i=>{const{addFilter:t,utils:n}=i,{Type:r,createRoute:e}=n,l=pe(i);return t("CREATE_VIEW",c=>{const{is:d,view:u,query:a}=c;if(!d("file")||!a("GET_ALLOW_FILE_POSTER"))return;const _=({root:o,props:m})=>{h(o,m)},p=({root:o,props:m,action:g})=>{/poster/.test(g.change.key)&&h(o,m)},h=(o,m)=>{const{id:g}=m,T=a("GET_ITEM",g);!T||!T.getMetadata("poster")||T.archived||o.ref.previousPoster!==T.getMetadata("poster")&&(o.ref.previousPoster=T.getMetadata("poster"),a("GET_FILE_POSTER_FILTER_ITEM")(T)&&(o.ref.filePoster&&u.removeChildView(o.ref.filePoster),o.ref.filePoster=u.appendChildView(u.createChildView(l,{id:g})),o.dispatch("DID_FILE_POSTER_CONTAINER_CREATE",{id:g})))},v=({root:o,action:m})=>{o.ref.filePoster&&(o.ref.imageWidth=m.width,o.ref.imageHeight=m.height,o.ref.shouldUpdatePanelHeight=!0,o.dispatch("KICK"))},y=({root:o})=>{let m=o.query("GET_FILE_POSTER_HEIGHT");if(m)return m;const g=o.query("GET_FILE_POSTER_MIN_HEIGHT"),T=o.query("GET_FILE_POSTER_MAX_HEIGHT");if(g&&o.ref.imageHeight<g)return g;let E=o.rect.element.width*(o.ref.imageHeight/o.ref.imageWidth);return g&&E<g?g:T&&E>T?T:E};u.registerWriter(e({DID_LOAD_ITEM:_,DID_FILE_POSTER_CALCULATE_SIZE:v,DID_UPDATE_ITEM_METADATA:p},({root:o,props:m})=>{o.ref.filePoster&&(o.rect.element.hidden||o.ref.shouldUpdatePanelHeight&&(o.dispatch("DID_UPDATE_PANEL_HEIGHT",{id:m.id,height:y({root:o})}),o.ref.shouldUpdatePanelHeight=!1))}))}),{options:{allowFilePoster:[!0,r.BOOLEAN],filePosterHeight:[null,r.INT],filePosterMinHeight:[null,r.INT],filePosterMaxHeight:[null,r.INT],filePosterFilterItem:[()=>!0,r.FUNCTION],filePosterCalculateAverageImageColor:[!1,r.BOOLEAN],filePosterCrossOriginAttributeValue:["Anonymous",r.STRING],filePosterItemOverlayShadowColor:[null,r.ARRAY],filePosterItemOverlayErrorColor:[null,r.ARRAY],filePosterItemOverlaySuccessColor:[null,r.ARRAY]}}},me=typeof window<"u"&&typeof window.document<"u";me&&document.dispatchEvent(new CustomEvent("FilePond:pluginloaded",{detail:q}));const _e=Z($,Q,q,J),fe={components:{FilePond:_e,Toaster:W,ImageEditor:ee},props:{inspection_uuid:{type:String,required:!0},evidence:{type:Object,required:!1},positionAux:{type:Number,required:!1},inspection_form_id:{type:String,required:!0}},data(){return{myFiles:[],action:"create",dialogDelete:!1,isHoveredDelete:!1,form:{inspection_uuid:this.inspection_uuid,evidence_store:null,evidence_store_secondary:null,title:null,title_secondary:null,description:null,description_secondary:null,inspection_evidence_secondary:null,loading:!1,inspection_form_id:this.inspection_form_id},formDefault:{inspection_uuid:this.inspection_uuid,evidence_store:null,evidence_store_secondary:null,title:null,title_secondary:null,description:null,description_secondary:null,inspection_evidence_secondary:null,loading:!1,inspection_form_id:this.inspection_form_id},serverConfig:{process:(i,t,n,r,e,l,c)=>{console.log(this.inspection_form_id),this.form.evidence_store=t;const u=C.CancelToken.source();this.form.title||(G.error("El título es requerido"),this.abort(u)),this.save(u,r,e,l)}},editImage:!1}},mounted(){this.evidence&&(this.action="update",this.setEvidence(this.evidence))},methods:{setEvidence(i){this.form.evidence_store=i.inspection_evidence,this.form.title=i.title,this.form.description=i.description,this.form.loading=!1,this.myFiles=[{source:i.inspection_evidence,options:{type:"remote"}}]},handleFilePondInit(){},save(i,t,n,r){this.form.position=this.positionAux,this.action==="create"?C.post("api/inspection/evidences",this.form,{headers:{"Content-Type":"multipart/form-data"},cancelToken:i.token,onUploadProgress:e=>{r(e.lengthComputable,e.loaded,e.total)}}).then(e=>{t(e.data.fileId),setTimeout(()=>{this.myFiles=[],this.form=this.formDefault,this.$emit("getEvidences")},2e3)}).catch(e=>{C.isCancel(e)?this.abort(i):(n("Error al subir la información."),this.handleErrors(e))}):this.action==="update"&&(this.form.loading=!0,C.post("api/inspection/evidences/update/"+this.evidence.inspection_evidence_uuid,this.form,{headers:{"Content-Type":"multipart/form-data"},cancelToken:i.token,onUploadProgress:e=>{r(e.lengthComputable,e.loaded,e.total)}}).then(e=>{t(e.data.fileId),setTimeout(()=>{let l=e.data.data;this.setEvidence(l)},2e3)}).catch(e=>{this.form.loading=!1,C.isCancel(e)?this.abort(i):(n("Error al subir la información."),this.handleErrors(e))}))},abort(){source.cancel("Operación cancelada por el usuario.")},deleteEvidence(){console.log("Entro a eliminar"),C.delete("api/inspection/evidences/"+this.evidence.inspection_evidence_uuid).then(i=>{G.success("Evidencia eliminada"),this.$emit("getEvidences")}).catch(i=>{this.handleErrors(i)})},openEditImageDialog(){this.form.position=this.positionAux,this.editImage=!0},closeEditImageDialog(){this.editImage=!1}}},Ee=i=>(j("data-v-e3fd4c98"),i=i(),K(),i),he={class:"container-img p-0"},ge=Ee(()=>U("br",null,null,-1));function ve(i,t,n,r,e,l){const c=I("file-pond"),d=I("v-btn"),u=I("v-text-field"),a=I("v-card-title"),_=I("v-textarea"),p=I("v-icon"),h=I("v-card-actions"),v=I("v-card"),y=I("v-skeleton-loader"),o=I("v-spacer"),m=I("v-dialog"),g=I("ImageEditor"),T=I("v-card-text");return P(),B(Y,null,[e.form.loading?(P(),w(v,{key:1,class:"pb-0",border:"dashed thin dark md"},{default:f(()=>[s(y,{type:"card"}),s(y,{type:"paragraph"}),s(y,{type:"paragraph"}),ge]),_:1})):(P(),w(v,{key:0,class:"p-0",border:"dashed thin dark md"},{default:f(()=>[U("div",he,[s(c,{name:"evidence",ref:"pond","label-idle":"Arrastra y suelta tu archivo o <span class='filepond--label-action'>selecciona</span>","allow-multiple":!1,"accepted-file-types":"image/jpeg, image/png",files:e.myFiles,onInit:l.handleFilePondInit,server:e.serverConfig,instantUpload:"false",allowProcess:"true",allowReplace:"true",allowImagePreview:"true",labelInvalidField:"Tipo de archivo no permitido",labelFileLoading:"Cargando",labelFileLoadError:"Error al subir el archivo",labelFileProcessing:"Procesando",labelFileProcessingComplete:"Proceso completado",labelFileProcessingAborted:"Proceso abortado",labelFileProcessingError:"Error al procesar",labelTapToCancel:"Toca para cancelar",labelTapToRetry:"Toca para reintentar",labelTapToUndo:"Toca para deshacer",labelButtonAbortItemLoad:"Cancelar",labelButtonRetryItemLoad:"Reintentar",labelButtonAbortItemProcessing:"Cancelar",labelButtonProcessItem:"Subir",class:X(n.evidence?"min-height":"")},null,8,["files","onInit","server","class"]),n.evidence?(P(),w(d,{key:0,icon:"mdi-pencil",density:"compact",class:"bg-grey-darken-3 btn-edit",onClick:l.openEditImageDialog},null,8,["onClick"])):V("",!0)]),s(a,null,{default:f(()=>[s(u,{label:"Título",modelValue:e.form.title,"onUpdate:modelValue":t[0]||(t[0]=E=>e.form.title=E),variant:"outlined","hide-details":"",density:"compact"},null,8,["modelValue"])]),_:1}),s(a,{class:"pb-1"},{default:f(()=>[s(_,{label:"Descripción",modelValue:e.form.description,"onUpdate:modelValue":t[1]||(t[1]=E=>e.form.description=E),variant:"outlined",rows:"2","hide-details":"",density:"compact"},null,8,["modelValue"])]),_:1}),n.evidence?(P(),w(h,{key:0,class:"p-0 m-0"},{default:f(()=>[n.evidence?(P(),w(d,{key:0,color:"error",onClick:t[2]||(t[2]=E=>e.dialogDelete=!0),block:"",onMouseover:t[3]||(t[3]=E=>e.isHoveredDelete=!0),onMouseleave:t[4]||(t[4]=E=>e.isHoveredDelete=!1)},{default:f(()=>[s(p,{left:"",class:"text-h5 primary-color"},{default:f(()=>[O(z(e.isHoveredDelete?"mdi-delete-empty-outline":"mdi-delete-outline"),1)]),_:1})]),_:1})):V("",!0)]),_:1})):V("",!0)]),_:1})),s(m,{modelValue:e.dialogDelete,"onUpdate:modelValue":t[7]||(t[7]=E=>e.dialogDelete=E),"max-width":"500px"},{default:f(()=>[s(v,null,{default:f(()=>[s(a,{class:"text-h5 text-center"},{default:f(()=>[O("¿Estás seguro de eliminar?")]),_:1}),s(h,null,{default:f(()=>[s(o),s(d,{color:"blue-darken-1",variant:"text",onClick:t[5]||(t[5]=E=>e.dialogDelete=!1)},{default:f(()=>[O("Cancelar")]),_:1}),s(d,{color:"blue-darken-1",variant:"text",onClick:t[6]||(t[6]=E=>l.deleteEvidence())},{default:f(()=>[O("Si, eliminar")]),_:1}),s(o)]),_:1})]),_:1})]),_:1},8,["modelValue"]),s(m,{modelValue:e.editImage,"onUpdate:modelValue":t[8]||(t[8]=E=>e.editImage=E),class:"width-edit"},{default:f(()=>[s(v,{title:"Editando imágen de evidencia"},{default:f(()=>[s(T,null,{default:f(()=>[s(g,{evidence:n.evidence,form:e.form,onCloseEditImageDialog:l.closeEditImageDialog,onSetEvidence:l.setEvidence},null,8,["evidence","form","onCloseEditImageDialog","onSetEvidence"])]),_:1}),s(h,null,{default:f(()=>[s(o),s(d,{text:"Cancelar",variant:"text",onClick:l.closeEditImageDialog},null,8,["onClick"])]),_:1})]),_:1})]),_:1},8,["modelValue"])],64)}const Se=te(fe,[["render",ve],["__scopeId","data-v-e3fd4c98"]]);export{Se as default};
