import{Q as W}from"./vue-quill.esm-bundler-CDSfNZEB.js";import{_ as X}from"./PrimaryButton-B84KU01C.js";import Y from"./Evidence-Bf4CeBjl.js";import{L as Z,G as b,q as S,r as l,o as a,e as m,a as c,b as t,w as e,F as w,y as E,c as r,d as i,t as h,g as v,E as z,x as A}from"./app-CjLPoRMk.js";import{_ as $}from"./_plugin-vue_export-helper-DlAUqK2U.js";import"./EvidenceForm-CSnJINRC.js";import"./sweetalert2.all-0oUSlYVc.js";import"./filepond-plugin-image-transform.esm-CJnK_Hyb.js";import"./ImageEditor-CuhZ8ul7.js";import"./api-kShYN9M8.js";const ee={components:{QuillEditor:W,PrimaryButton:X,Toaster:Z,Evidence:Y},props:{dialogForm:{type:Boolean,required:!0},ct_inspection_uuid:{type:String,required:!0},inspection_uuid:{type:String,required:!0}},data(){return{dialogFormLoading:!1,sectionsForm:[],expandedPanel:[0,1,2,3,4,5,6],ct_risks:[],suggestions:[],failures:[]}},methods:{getForm(){this.dialogFormLoading=!0,b.get("api/inspection/forms/get-form-inspection/"+this.inspection_uuid).then(n=>{this.dialogFormLoading=!1,this.sectionsForm=n.data.data.sections}).catch(n=>{this.dialogFormLoading=!1,this.handleErrors(n)})},closeSectionDialog(){this.$emit("closeSectionDialog")},saveField(n){n.loading=!0;let d={inspection_uuid:this.inspection_uuid,form:[{inspection_form_value:n.content.inspection_form_value,inspection_form_comments:n.content.inspection_form_comments,ct_inspection_form_uuid:n.ct_inspection_form_uuid,ct_risk_id:n.content.ct_risk_id}]};b.post("api/inspection/forms/set-form-inspection",d).then(p=>{n.loading=!1,S.success("Campo guardado correctamente"),p.data.data.length>0?(n.content=p.data.data[0],this.getSuggestions(n)):this.getForm()}).catch(p=>{n.loading=!1,this.handleErrors(p)})},complementData(n){n.content==null&&(n.content={inspection_form_value:"",inspection_form_comments:"",ct_risk_id:null})},isEmptyField(n){return n==null||n==""||n=="<p><br></p>"},getRisks(){b.get("api/risks").then(n=>{this.ct_risks=n.data.data}).catch(n=>{this.handleErrors(n)})},getFailures(){b.get("api/failures").then(n=>{this.failures=n.data.data}).catch(n=>{this.handleErrors(n)})},getBgColor(n){let d=this.ct_risks.filter(p=>n===p.ct_risk_id);return d.length>0?d[0].ct_color:""},async getSuggestions(n){n.loadingSuggestions=!0,await b.get("api/inspection/forms/get-field-suggestions/"+n.ct_inspection_form_uuid).then(d=>{n.loadingSuggestions=!1,n.suggestions=d.data.data}).catch(d=>{n.loadingSuggestions=!1,this.handleErrors(d)})},setComment(n,d){n.content.inspection_form_comments=d}},mounted(){this.getForm(),this.getRisks(),this.getFailures()}},te={class:"max-w-7xl mx-auto sm:px-4 lg:px-6 mb-5 pb-5"},ne={class:"overflow-hidden shadow-sm sm:rounded-lg"},oe=c("p",{class:"text-grey mb-2 text-h5 font-weight-bold"}," Carga de evidencias ",-1),se=c("p",{class:"text-primary"},"Rellena la información relacionada con las evidencias de la inspección.",-1),ae={key:0},le={class:"d-flex align-center"},ie={class:"d-flex align-center gap-3"},ce={class:"text-grey"},re=c("p",{class:"text-grey"}," Riesgo:",-1),_e=c("p",{class:"mt-3 text-grey"}," Comentarios:",-1),de=c("span",{class:"mdi mdi-lightbulb-on-outline"},null,-1),ue=["innerHTML"],me={key:1},pe={key:0},ge={class:"d-flex align-center"},ve={class:"d-lg-flex align-center gap-3"},fe={class:"text-grey"},he=c("p",{class:"text-grey"}," Riesgo:",-1),ye=c("p",{class:"mt-3 text-grey"}," Comentarios: ",-1),ke=c("span",{class:"mdi mdi-lightbulb-on-outline"},null,-1),xe=["innerHTML"];function Ce(n,d,p,Fe,f,_){const I=l("v-divider"),U=l("v-chip"),F=l("v-card-subtitle"),D=l("v-expansion-panel-title"),L=l("v-icon"),P=l("v-card-title"),B=l("v-autocomplete"),g=l("v-col"),R=l("v-list-item"),y=l("v-row"),N=l("QuillEditor"),k=l("v-card"),x=l("v-card-text"),H=l("v-skeleton-loader"),M=l("Evidence"),Q=l("PrimaryButton"),G=l("v-expansion-panel-text"),j=l("v-expansion-panel"),O=l("v-expansion-panels"),J=l("v-container");return a(),m("div",te,[c("div",ne,[t(k,{loading:f.dialogFormLoading},{default:e(()=>[t(x,{class:""},{default:e(()=>[oe,se,t(I),t(J,null,{default:e(()=>[t(y,null,{default:e(()=>[t(g,{cols:"12",class:"padding-0"},{default:e(()=>[t(O,{multiple:"",modelValue:f.expandedPanel,"onUpdate:modelValue":d[0]||(d[0]=C=>f.expandedPanel=C)},{default:e(()=>[(a(!0),m(w,null,E(f.sectionsForm,(C,K)=>(a(),r(j,{key:K,class:"my-5 border",expanded:!0},{default:e(()=>[t(D,{class:"text-h6"},{default:e(()=>[t(U,{color:"primary",variant:"elevated"},{default:e(()=>[i(h(C.section_details.ct_inspection_section),1)]),_:2},1024),t(F,{class:"ml-2 mt-0 pt-0"},{default:e(()=>[i(" Sección ")]),_:1})]),_:2},1024),t(G,null,{default:e(()=>[C.fields?(a(),m("div",ae,[(a(!0),m(w,null,E(C.fields,(s,T)=>(a(),r(k,{key:T,class:"my-5 border",loading:s.loading},{default:e(()=>[i(h(_.complementData(s))+" ",1),t(P,{class:"d-lg-flex justify-between"},{default:e(()=>[c("div",le,[t(U,{color:"primary"},{default:e(()=>[i(h(s.ct_inspection_form),1)]),_:2},1024),t(F,null,{default:e(()=>[i("Campo")]),_:1})]),c("div",ie,[_.isEmptyField(s.content.inspection_form_value)?v("",!0):(a(),r(L,{key:0,color:"success"},{default:e(()=>[i("mdi-check")]),_:1})),_.isEmptyField(s.content.inspection_form_value)&&s.required?(a(),r(L,{key:1,color:"red"},{default:e(()=>[i("mdi-alert-circle-outline")]),_:1})):v("",!0)])]),_:2},1024),t(x,{class:"pt-0"},{default:e(()=>[t(y,null,{default:e(()=>[t(g,{cols:"12",lg:"6"},{default:e(()=>[c("p",ce,"Código de falla ("+h(s.required?"*Requerido":"Opcional")+"):",1),t(B,{modelValue:s.content.inspection_form_value,"onUpdate:modelValue":o=>s.content.inspection_form_value=o,items:f.failures,"item-title":"failure","item-value":"failure",variant:"outlined","hide-details":"",class:"rounded",density:"compact",clearable:""},null,8,["modelValue","onUpdate:modelValue","items"])]),_:2},1024),t(g,{cols:"12",lg:"6"},{default:e(()=>[re,t(B,{modelValue:s.content.ct_risk_id,"onUpdate:modelValue":o=>s.content.ct_risk_id=o,items:f.ct_risks,"item-title":"ct_risk","item-value":"ct_risk_id",variant:"outlined","hide-details":"",class:"rounded",density:"compact",style:z({"background-color":_.getBgColor(s.content.ct_risk_id)}),clearable:""},{item:e(({props:o,item:V})=>[t(R,A(o,{title:V.raw.ct_risk,style:{"background-color":V.raw.ct_color},value:"ct_risk"}),null,16,["title","style"])]),_:2},1032,["modelValue","onUpdate:modelValue","items","style"])]),_:2},1024)]),_:2},1024),_e,t(y,null,{default:e(()=>[t(g,{cols:"12",lg:"8"},{default:e(()=>[t(N,{content:s.content.inspection_form_comments,"onUpdate:content":o=>s.content.inspection_form_comments=o,theme:"snow",toolbar:"essential",contentType:"html",onClick:o=>_.getSuggestions(s)},null,8,["content","onUpdate:content","onClick"])]),_:2},1024),t(g,{cols:"12",lg:"4"},{default:e(()=>[t(k,{class:"mx-auto border",color:"primary",variant:"outlined"},{default:e(()=>[t(F,{class:"mt-2 mb-0"},{default:e(()=>[de,i(" Sugerencias")]),_:1}),s.loadingSuggestions?(a(),r(H,{key:1,type:"paragraph"})):(a(),r(x,{key:0,class:"py-1 card-suggestions overflow-y-auto"},{default:e(()=>[(a(!0),m(w,null,E(s.suggestions,(o,V)=>(a(),r(k,{variant:"tonal",class:"my-1",key:V,onClick:u=>_.setComment(s,o)},{default:e(()=>[c("div",{class:"m-1",innerHTML:o},null,8,ue)]),_:2},1032,["onClick"]))),128))]),_:2},1024)),s.suggestions?v("",!0):(a(),r(x,{key:2,class:"pt-0 card-suggestions overflow-y-auto"},{default:e(()=>[i("No hay sugerencias")]),_:1}))]),_:2},1024)]),_:2},1024)]),_:2},1024),t(y,null,{default:e(()=>[t(M,{inspection_uuid:p.inspection_uuid,inspection_form_id:s.content.inspection_form_id},null,8,["inspection_uuid","inspection_form_id"])]),_:2},1024),t(Q,{onClick:o=>_.saveField(s),class:"mt-2",disabled:s.loading},{default:e(()=>[i("Guardar ")]),_:2},1032,["onClick","disabled"])]),_:2},1024)]),_:2},1032,["loading"]))),128))])):v("",!0),C.sub_sections?(a(),m("div",me,[t(O,{multiple:""},{default:e(()=>[(a(!0),m(w,null,E(C.sub_sections,(s,T)=>(a(),r(j,{key:T,class:"my-5 border"},{default:e(()=>[t(D,{class:"text-h6"},{default:e(()=>[t(U,{color:"primary",variant:"elevated"},{default:e(()=>[i(h(s.ct_inspection_section),1)]),_:2},1024),t(F,{class:"ml-2 mt-0 pt-0"},{default:e(()=>[i(" Sub-sección ")]),_:1})]),_:2},1024),t(G,null,{default:e(()=>[s.fields?(a(),m("div",pe,[(a(!0),m(w,null,E(s.fields,(o,V)=>(a(),r(k,{key:V,class:"my-5 border",loading:o.loading},{default:e(()=>[i(h(_.complementData(o))+" ",1),t(P,{class:"d-lg-flex justify-between"},{default:e(()=>[c("div",ge,[t(U,{color:"primary"},{default:e(()=>[i(h(o.ct_inspection_form),1)]),_:2},1024),t(F,null,{default:e(()=>[i("Campo")]),_:1})]),c("div",ve,[_.isEmptyField(o.content.inspection_form_value)?v("",!0):(a(),r(L,{key:0,color:"success"},{default:e(()=>[i("mdi-check")]),_:1})),_.isEmptyField(o.content.inspection_form_value)&&o.required?(a(),r(L,{key:1,color:"red"},{default:e(()=>[i("mdi-alert-circle-outline")]),_:1})):v("",!0)])]),_:2},1024),t(x,{class:"pt-0"},{default:e(()=>[t(y,null,{default:e(()=>[t(g,{cols:"12",lg:"6"},{default:e(()=>[c("p",fe,"Código de falla ("+h(o.required?"*Requerido":"Opcional")+"):",1),t(B,{modelValue:o.content.inspection_form_value,"onUpdate:modelValue":u=>o.content.inspection_form_value=u,items:f.failures,"item-title":"failure","item-value":"failure",variant:"outlined","hide-details":"",class:"rounded",density:"compact",clearable:""},null,8,["modelValue","onUpdate:modelValue","items"])]),_:2},1024),t(g,{cols:"12",lg:"6"},{default:e(()=>[he,t(B,{modelValue:o.content.ct_risk_id,"onUpdate:modelValue":u=>o.content.ct_risk_id=u,items:f.ct_risks,"item-title":"ct_risk","item-value":"ct_risk_id",variant:"outlined","hide-details":"",class:"rounded",density:"compact",style:z({"background-color":_.getBgColor(o.content.ct_risk_id)}),clearable:""},{item:e(({props:u,item:q})=>[t(R,A(u,{title:q.raw.ct_risk,style:{"background-color":q.raw.ct_color},value:"ct_risk"}),null,16,["title","style"])]),_:2},1032,["modelValue","onUpdate:modelValue","items","style"])]),_:2},1024)]),_:2},1024),ye,t(y,null,{default:e(()=>[t(g,{cols:"12",lg:"8"},{default:e(()=>[t(N,{content:o.content.inspection_form_comments,"onUpdate:content":u=>o.content.inspection_form_comments=u,theme:"snow",toolbar:"essential",heigth:"100%",contentType:"html",onClick:u=>_.getSuggestions(o)},null,8,["content","onUpdate:content","onClick"])]),_:2},1024),t(g,{cols:"12",lg:"4"},{default:e(()=>[t(k,{class:"mx-auto border",color:"primary",variant:"outlined"},{default:e(()=>[t(F,{class:"mt-2 mb-0"},{default:e(()=>[ke,i(" Sugerencias")]),_:1}),o.loadingSuggestions?(a(),r(H,{key:1,type:"paragraph"})):(a(),r(x,{key:0,class:"py-1 card-suggestions overflow-y-auto"},{default:e(()=>[(a(!0),m(w,null,E(o.suggestions,(u,q)=>(a(),r(k,{variant:"tonal",class:"my-1",key:q,onClick:Ve=>_.setComment(o,u)},{default:e(()=>[c("div",{class:"m-1",innerHTML:u},null,8,xe)]),_:2},1032,["onClick"]))),128))]),_:2},1024)),o.suggestions?v("",!0):(a(),r(x,{key:2,class:"pt-0 card-suggestions overflow-y-auto"},{default:e(()=>[i("No hay sugerencias")]),_:1}))]),_:2},1024)]),_:2},1024)]),_:2},1024),t(y,null,{default:e(()=>[t(M,{inspection_uuid:p.inspection_uuid,inspection_form_id:o.content.inspection_form_id},null,8,["inspection_uuid","inspection_form_id"])]),_:2},1024),t(Q,{onClick:u=>_.saveField(o),class:"mt-2",disabled:o.loading},{default:e(()=>[i(" Guardar")]),_:2},1032,["onClick","disabled"])]),_:2},1024)]),_:2},1032,["loading"]))),128))])):v("",!0)]),_:2},1024)]),_:2},1024))),128))]),_:2},1024)])):v("",!0)]),_:2},1024)]),_:2},1024))),128))]),_:1},8,["modelValue"])]),_:1})]),_:1})]),_:1})]),_:1})]),_:1},8,["loading"])])])}const Re=$(ee,[["render",Ce]]);export{Re as default};
