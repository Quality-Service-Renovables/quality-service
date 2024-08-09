import{Q as W}from"./vue-quill.esm-bundler-BbcM9JEO.js";import{_ as X}from"./PrimaryButton-kNMMRUtt.js";import Y from"./Evidence-DGbfDreA.js";import{L as Z,H as b,q as S,r as i,o as s,e as p,a as r,b as t,w as e,F as w,z as E,c,d as l,t as h,g as m,G as O,x as A}from"./app-DHQkOlst.js";import{_ as $}from"./_plugin-vue_export-helper-DlAUqK2U.js";import"./EvidenceForm-Buv9DtIH.js";import"./sweetalert2.all-CIoFQGsi.js";import"./filepond-plugin-image-transform.esm-D0fMk-a-.js";import"./ImageEditor-BO27gF6L.js";import"./api-tbeJV3PM.js";const ee={components:{QuillEditor:W,PrimaryButton:X,Toaster:Z,Evidence:Y},props:{dialogForm:{type:Boolean,required:!0},ct_inspection_uuid:{type:String,required:!0},inspection_uuid:{type:String,required:!0}},data(){return{dialogFormLoading:!1,sectionsForm:[],expandedPanel:[0,1,2,3,4,5,6],ct_risks:[],suggestions:[],failures:[]}},methods:{getForm(){this.dialogFormLoading=!0,b.get("api/inspection/forms/get-form-inspection/"+this.inspection_uuid).then(n=>{this.dialogFormLoading=!1,this.sectionsForm=n.data.data.sections}).catch(n=>{this.dialogFormLoading=!1,this.handleErrors(n)})},closeSectionDialog(){this.$emit("closeSectionDialog")},saveField(n){n.loading=!0;let d={inspection_uuid:this.inspection_uuid,form:[{inspection_form_value:n.content.inspection_form_value??" ",inspection_form_comments:n.content.inspection_form_comments,ct_inspection_form_uuid:n.ct_inspection_form_uuid,ct_risk_id:n.content.ct_risk_id}]};b.post("api/inspection/forms/set-form-inspection",d).then(g=>{n.loading=!1,S.success("Campo guardado correctamente"),g.data.data.length>0?(n.content=g.data.data[0],this.getSuggestions(n)):this.getForm()}).catch(g=>{n.loading=!1,this.handleErrors(g)})},complementData(n){n.content==null&&(n.content={inspection_form_value:"",inspection_form_comments:"",ct_risk_id:null,inspection_form_id:null})},isEmptyField(n){return n==null||n==""||n=="<p><br></p>"},getRisks(){b.get("api/risks").then(n=>{this.ct_risks=n.data.data}).catch(n=>{this.handleErrors(n)})},getFailures(){b.get("api/failures").then(n=>{this.failures=n.data.data}).catch(n=>{this.handleErrors(n)})},getBgColor(n){let d=this.ct_risks.filter(g=>n===g.ct_risk_id);return d.length>0?d[0].ct_color:""},async getSuggestions(n){n.loadingSuggestions=!0,await b.get("api/inspection/forms/get-field-suggestions/"+n.ct_inspection_form_uuid).then(d=>{n.loadingSuggestions=!1,n.suggestions=d.data.data}).catch(d=>{n.loadingSuggestions=!1,this.handleErrors(d)})},setComment(n,d){n.content.inspection_form_comments=d}},mounted(){this.getForm(),this.getRisks(),this.getFailures()}},te={class:"max-w-7xl mx-auto sm:px-4 lg:px-6 mb-5 pb-5"},ne={class:"overflow-hidden shadow-sm sm:rounded-lg"},oe=r("p",{class:"text-grey mb-2 text-h5 font-weight-bold"}," Carga de evidencias ",-1),se=r("p",{class:"text-primary"},"Rellena la información relacionada con las evidencias de la inspección.",-1),ae={key:0},ie={class:"d-flex align-center"},le={class:"d-flex align-center gap-3"},ce={class:"text-grey"},re=r("p",{class:"text-grey"}," Riesgo:",-1),_e=r("p",{class:"mt-3 text-grey"}," Comentarios:",-1),de=r("span",{class:"mdi mdi-lightbulb-on-outline"},null,-1),ue=["innerHTML"],me={key:1},pe={key:0},ge={class:"d-flex align-center"},ve={class:"d-lg-flex align-center gap-3"},fe={class:"text-grey"},he=r("p",{class:"text-grey"}," Riesgo:",-1),ye=r("p",{class:"mt-3 text-grey"}," Comentarios: ",-1),ke=r("span",{class:"mdi mdi-lightbulb-on-outline"},null,-1),xe=["innerHTML"];function Ce(n,d,g,Fe,f,_){const I=i("v-divider"),U=i("v-chip"),F=i("v-card-subtitle"),D=i("v-expansion-panel-title"),L=i("v-icon"),P=i("v-card-title"),B=i("v-autocomplete"),v=i("v-col"),R=i("v-list-item"),y=i("v-row"),N=i("QuillEditor"),k=i("v-card"),x=i("v-card-text"),H=i("v-skeleton-loader"),M=i("Evidence"),Q=i("PrimaryButton"),G=i("v-expansion-panel-text"),j=i("v-expansion-panel"),z=i("v-expansion-panels"),J=i("v-container");return s(),p("div",te,[r("div",ne,[t(k,{loading:f.dialogFormLoading},{default:e(()=>[t(x,{class:""},{default:e(()=>[oe,se,t(I),t(J,null,{default:e(()=>[t(y,null,{default:e(()=>[t(v,{cols:"12",class:"padding-0"},{default:e(()=>[t(z,{multiple:"",modelValue:f.expandedPanel,"onUpdate:modelValue":d[0]||(d[0]=C=>f.expandedPanel=C)},{default:e(()=>[(s(!0),p(w,null,E(f.sectionsForm,(C,K)=>(s(),c(j,{key:K,class:"my-5 border",expanded:!0},{default:e(()=>[t(D,{class:"text-h6"},{default:e(()=>[t(U,{color:"primary",variant:"elevated"},{default:e(()=>[l(h(C.section_details.ct_inspection_section),1)]),_:2},1024),t(F,{class:"ml-2 mt-0 pt-0"},{default:e(()=>[l(" Sección ")]),_:1})]),_:2},1024),t(G,null,{default:e(()=>[C.fields?(s(),p("div",ae,[(s(!0),p(w,null,E(C.fields,(a,T)=>(s(),c(k,{key:T,class:"my-5 border",loading:a.loading},{default:e(()=>[l(h(_.complementData(a))+" ",1),t(P,{class:"d-lg-flex justify-between"},{default:e(()=>[r("div",ie,[t(U,{color:"primary"},{default:e(()=>[l(h(a.ct_inspection_form),1)]),_:2},1024),t(F,null,{default:e(()=>[l("Campo")]),_:1})]),r("div",le,[_.isEmptyField(a.content.inspection_form_value)?m("",!0):(s(),c(L,{key:0,color:"success"},{default:e(()=>[l("mdi-check")]),_:1})),_.isEmptyField(a.content.inspection_form_value)&&a.required?(s(),c(L,{key:1,color:"red"},{default:e(()=>[l("mdi-alert-circle-outline")]),_:1})):m("",!0)])]),_:2},1024),t(x,{class:"pt-0"},{default:e(()=>[t(y,null,{default:e(()=>[t(v,{cols:"12",lg:"6"},{default:e(()=>[r("p",ce,"Código de falla ("+h(a.required?"*Requerido":"Opcional")+"):",1),t(B,{modelValue:a.content.inspection_form_value,"onUpdate:modelValue":o=>a.content.inspection_form_value=o,items:f.failures,"item-title":"failure","item-value":"failure",variant:"outlined","hide-details":"",class:"rounded",density:"compact",clearable:""},null,8,["modelValue","onUpdate:modelValue","items"])]),_:2},1024),t(v,{cols:"12",lg:"6"},{default:e(()=>[re,t(B,{modelValue:a.content.ct_risk_id,"onUpdate:modelValue":o=>a.content.ct_risk_id=o,items:f.ct_risks,"item-title":"ct_risk","item-value":"ct_risk_id",variant:"outlined","hide-details":"",class:"rounded",density:"compact",style:O({"background-color":_.getBgColor(a.content.ct_risk_id)}),clearable:""},{item:e(({props:o,item:V})=>[t(R,A(o,{title:V.raw.ct_risk,style:{"background-color":V.raw.ct_color},value:"ct_risk"}),null,16,["title","style"])]),_:2},1032,["modelValue","onUpdate:modelValue","items","style"])]),_:2},1024)]),_:2},1024),_e,t(y,null,{default:e(()=>[t(v,{cols:"12",lg:"8"},{default:e(()=>[t(N,{content:a.content.inspection_form_comments,"onUpdate:content":o=>a.content.inspection_form_comments=o,theme:"snow",toolbar:"essential",contentType:"html",onClick:o=>_.getSuggestions(a)},null,8,["content","onUpdate:content","onClick"])]),_:2},1024),t(v,{cols:"12",lg:"4"},{default:e(()=>[t(k,{class:"mx-auto border",color:"primary",variant:"outlined"},{default:e(()=>[t(F,{class:"mt-2 mb-0"},{default:e(()=>[de,l(" Sugerencias")]),_:1}),a.loadingSuggestions?(s(),c(H,{key:1,type:"paragraph"})):(s(),c(x,{key:0,class:"py-1 card-suggestions overflow-y-auto"},{default:e(()=>[(s(!0),p(w,null,E(a.suggestions,(o,V)=>(s(),c(k,{variant:"tonal",class:"my-1",key:V,onClick:u=>_.setComment(a,o)},{default:e(()=>[r("div",{class:"m-1",innerHTML:o},null,8,ue)]),_:2},1032,["onClick"]))),128))]),_:2},1024)),a.suggestions?m("",!0):(s(),c(x,{key:2,class:"pt-0 card-suggestions overflow-y-auto"},{default:e(()=>[l("No hay sugerencias")]),_:1}))]),_:2},1024)]),_:2},1024)]),_:2},1024),a.content.inspection_form_id?(s(),c(y,{key:0},{default:e(()=>[t(M,{inspection_uuid:g.inspection_uuid,inspection_form_id:a.content.inspection_form_id},null,8,["inspection_uuid","inspection_form_id"])]),_:2},1024)):m("",!0),t(Q,{onClick:o=>_.saveField(a),class:"mt-2",disabled:a.loading},{default:e(()=>[l("Guardar ")]),_:2},1032,["onClick","disabled"])]),_:2},1024)]),_:2},1032,["loading"]))),128))])):m("",!0),C.sub_sections?(s(),p("div",me,[t(z,{multiple:""},{default:e(()=>[(s(!0),p(w,null,E(C.sub_sections,(a,T)=>(s(),c(j,{key:T,class:"my-5 border"},{default:e(()=>[t(D,{class:"text-h6"},{default:e(()=>[t(U,{color:"primary",variant:"elevated"},{default:e(()=>[l(h(a.ct_inspection_section),1)]),_:2},1024),t(F,{class:"ml-2 mt-0 pt-0"},{default:e(()=>[l(" Sub-sección ")]),_:1})]),_:2},1024),t(G,null,{default:e(()=>[a.fields?(s(),p("div",pe,[(s(!0),p(w,null,E(a.fields,(o,V)=>(s(),c(k,{key:V,class:"my-5 border",loading:o.loading},{default:e(()=>[l(h(_.complementData(o))+" ",1),t(P,{class:"d-lg-flex justify-between"},{default:e(()=>[r("div",ge,[t(U,{color:"primary"},{default:e(()=>[l(h(o.ct_inspection_form),1)]),_:2},1024),t(F,null,{default:e(()=>[l("Campo")]),_:1})]),r("div",ve,[_.isEmptyField(o.content.inspection_form_value)?m("",!0):(s(),c(L,{key:0,color:"success"},{default:e(()=>[l("mdi-check")]),_:1})),_.isEmptyField(o.content.inspection_form_value)&&o.required?(s(),c(L,{key:1,color:"red"},{default:e(()=>[l("mdi-alert-circle-outline")]),_:1})):m("",!0)])]),_:2},1024),t(x,{class:"pt-0"},{default:e(()=>[t(y,null,{default:e(()=>[t(v,{cols:"12",lg:"6"},{default:e(()=>[r("p",fe,"Código de falla ("+h(o.required?"*Requerido":"Opcional")+"):",1),t(B,{modelValue:o.content.inspection_form_value,"onUpdate:modelValue":u=>o.content.inspection_form_value=u,items:f.failures,"item-title":"failure","item-value":"failure",variant:"outlined","hide-details":"",class:"rounded",density:"compact",clearable:""},null,8,["modelValue","onUpdate:modelValue","items"])]),_:2},1024),t(v,{cols:"12",lg:"6"},{default:e(()=>[he,t(B,{modelValue:o.content.ct_risk_id,"onUpdate:modelValue":u=>o.content.ct_risk_id=u,items:f.ct_risks,"item-title":"ct_risk","item-value":"ct_risk_id",variant:"outlined","hide-details":"",class:"rounded",density:"compact",style:O({"background-color":_.getBgColor(o.content.ct_risk_id)}),clearable:""},{item:e(({props:u,item:q})=>[t(R,A(u,{title:q.raw.ct_risk,style:{"background-color":q.raw.ct_color},value:"ct_risk"}),null,16,["title","style"])]),_:2},1032,["modelValue","onUpdate:modelValue","items","style"])]),_:2},1024)]),_:2},1024),ye,t(y,null,{default:e(()=>[t(v,{cols:"12",lg:"8"},{default:e(()=>[t(N,{content:o.content.inspection_form_comments,"onUpdate:content":u=>o.content.inspection_form_comments=u,theme:"snow",toolbar:"essential",heigth:"100%",contentType:"html",onClick:u=>_.getSuggestions(o)},null,8,["content","onUpdate:content","onClick"])]),_:2},1024),t(v,{cols:"12",lg:"4"},{default:e(()=>[t(k,{class:"mx-auto border",color:"primary",variant:"outlined"},{default:e(()=>[t(F,{class:"mt-2 mb-0"},{default:e(()=>[ke,l(" Sugerencias")]),_:1}),o.loadingSuggestions?(s(),c(H,{key:1,type:"paragraph"})):(s(),c(x,{key:0,class:"py-1 card-suggestions overflow-y-auto"},{default:e(()=>[(s(!0),p(w,null,E(o.suggestions,(u,q)=>(s(),c(k,{variant:"tonal",class:"my-1",key:q,onClick:Ve=>_.setComment(o,u)},{default:e(()=>[r("div",{class:"m-1",innerHTML:u},null,8,xe)]),_:2},1032,["onClick"]))),128))]),_:2},1024)),o.suggestions?m("",!0):(s(),c(x,{key:2,class:"pt-0 card-suggestions overflow-y-auto"},{default:e(()=>[l("No hay sugerencias")]),_:1}))]),_:2},1024)]),_:2},1024)]),_:2},1024),o.content.inspection_form_id?(s(),c(y,{key:0},{default:e(()=>[t(M,{inspection_uuid:g.inspection_uuid,inspection_form_id:o.content.inspection_form_id},null,8,["inspection_uuid","inspection_form_id"])]),_:2},1024)):m("",!0),t(Q,{onClick:u=>_.saveField(o),class:"mt-2",disabled:o.loading},{default:e(()=>[l(" Guardar")]),_:2},1032,["onClick","disabled"])]),_:2},1024)]),_:2},1032,["loading"]))),128))])):m("",!0)]),_:2},1024)]),_:2},1024))),128))]),_:2},1024)])):m("",!0)]),_:2},1024)]),_:2},1024))),128))]),_:1},8,["modelValue"])]),_:1})]),_:1})]),_:1})]),_:1})]),_:1},8,["loading"])])])}const Re=$(ee,[["render",Ce]]);export{Re as default};
