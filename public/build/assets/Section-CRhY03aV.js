import{Q as X}from"./vue-quill.esm-bundler-DV-dmqqO.js";import{_ as Y}from"./PrimaryButton-BNFgF17f.js";import Z from"./Evidence-DwInluaw.js";import{L as S,H as U,q as $,r as i,o as a,e as m,a as c,b as t,w as e,F as w,z as b,c as r,d as l,t as f,g,G as A,x as I}from"./app-DDJMr7vS.js";import{_ as ee}from"./_plugin-vue_export-helper-DlAUqK2U.js";import"./EvidenceForm-CVRrTBGy.js";import"./sweetalert2.all-CLT0pA3l.js";import"./filepond-plugin-image-transform.esm-F5eUMeDu.js";import"./ImageEditor-DJKZW7Gv.js";import"./api-BCRwBhBs.js";const te={components:{QuillEditor:X,PrimaryButton:Y,Toaster:S,Evidence:Z},props:{dialogForm:{type:Boolean,required:!0},ct_inspection_uuid:{type:String,required:!0},inspection_uuid:{type:String,required:!0}},data(){return{dialogFormLoading:!1,sectionsForm:[],expandedPanel:[0,1,2,3,4,5,6],ct_risks:[],suggestions:[],failures:[]}},methods:{getForm(){this.dialogFormLoading=!0,U.get("api/inspection/forms/get-form-inspection/"+this.inspection_uuid).then(n=>{this.dialogFormLoading=!1,this.sectionsForm=n.data.data.sections}).catch(n=>{this.dialogFormLoading=!1,this.handleErrors(n)})},closeSectionDialog(){this.$emit("closeSectionDialog")},async saveField(n){n.loading=!0;let d={inspection_uuid:this.inspection_uuid,form:[{inspection_form_value:n.content.inspection_form_value??" ",inspection_form_comments:n.content.inspection_form_comments,ct_inspection_form_uuid:n.ct_inspection_form_uuid,ct_risk_id:n.content.ct_risk_id}]};await U.post("api/inspection/forms/set-form-inspection",d).then(E=>{n.loading=!1,$.success("Campo guardado correctamente"),E.data.data.length>0?(n.content=E.data.data[0],this.getSuggestions(n)):this.getForm()}).catch(E=>{n.loading=!1,this.handleErrors(E)});let h=document.querySelector("#btn_upload_evidence_"+n.content.inspection_form_id+" .filepond--action-process-item");h&&h.click()},complementData(n){n.content==null&&(n.content={inspection_form_value:"",inspection_form_comments:"",ct_risk_id:null,inspection_form_id:null})},isEmptyField(n){return n==null||n==""||n=="<p><br></p>"},getRisks(){U.get("api/risks").then(n=>{this.ct_risks=n.data.data}).catch(n=>{this.handleErrors(n)})},getFailures(){U.get("api/failures").then(n=>{this.failures=n.data.data}).catch(n=>{this.handleErrors(n)})},getBgColor(n){let d=this.ct_risks.filter(h=>n===h.ct_risk_id);return d.length>0?d[0].ct_color:""},async getSuggestions(n){n.loadingSuggestions=!0,await U.get("api/inspection/forms/get-field-suggestions/"+n.ct_inspection_form_uuid).then(d=>{n.loadingSuggestions=!1,n.suggestions=d.data.data}).catch(d=>{n.loadingSuggestions=!1,this.handleErrors(d)})},setComment(n,d){n.content.inspection_form_comments=d}},mounted(){this.getForm(),this.getRisks(),this.getFailures()}},ne={class:"max-w-7xl mx-auto sm:px-4 lg:px-6 mb-5 pb-5"},oe={class:"overflow-hidden shadow-sm sm:rounded-lg"},se=c("p",{class:"text-grey mb-2 text-h5 font-weight-bold"}," Carga de evidencias ",-1),ae=c("p",{class:"text-primary"},"Rellena la información relacionada con las evidencias de la inspección.",-1),ie={key:0},le={class:"d-flex align-center"},ce={class:"d-flex align-center gap-3"},re={class:"text-grey"},_e=c("p",{class:"text-grey"}," Riesgo:",-1),de=c("p",{class:"mt-3 text-grey"}," Comentarios:",-1),ue=c("span",{class:"mdi mdi-lightbulb-on-outline"},null,-1),me=["innerHTML"],pe={key:1},ge={key:0},ve={class:"d-flex align-center"},fe={class:"d-lg-flex align-center gap-3"},he={class:"text-grey"},ye=c("p",{class:"text-grey"}," Riesgo:",-1),ke=c("p",{class:"mt-3 text-grey"}," Comentarios: ",-1),xe=c("span",{class:"mdi mdi-lightbulb-on-outline"},null,-1),Ce=["innerHTML"];function Fe(n,d,h,E,v,_){const J=i("v-divider"),L=i("v-chip"),F=i("v-card-subtitle"),P=i("v-expansion-panel-title"),q=i("v-icon"),R=i("v-card-title"),B=i("v-autocomplete"),p=i("v-col"),N=i("v-list-item"),y=i("v-row"),H=i("QuillEditor"),k=i("v-card"),x=i("v-card-text"),M=i("v-skeleton-loader"),Q=i("Evidence"),G=i("PrimaryButton"),j=i("v-expansion-panel-text"),z=i("v-expansion-panel"),O=i("v-expansion-panels"),K=i("v-container");return a(),m("div",ne,[c("div",oe,[t(k,{loading:v.dialogFormLoading},{default:e(()=>[t(x,{class:""},{default:e(()=>[se,ae,t(J),t(K,null,{default:e(()=>[t(y,null,{default:e(()=>[t(p,{cols:"12",class:"padding-0"},{default:e(()=>[t(O,{multiple:"",modelValue:v.expandedPanel,"onUpdate:modelValue":d[0]||(d[0]=C=>v.expandedPanel=C)},{default:e(()=>[(a(!0),m(w,null,b(v.sectionsForm,(C,W)=>(a(),r(z,{key:W,class:"my-5 border",expanded:!0},{default:e(()=>[t(P,{class:"text-h6"},{default:e(()=>[t(L,{color:"primary",variant:"elevated"},{default:e(()=>[l(f(C.section_details.ct_inspection_section),1)]),_:2},1024),t(F,{class:"ml-2 mt-0 pt-0"},{default:e(()=>[l(" Sección ")]),_:1})]),_:2},1024),t(j,null,{default:e(()=>[C.fields?(a(),m("div",ie,[(a(!0),m(w,null,b(C.fields,(s,D)=>(a(),r(k,{key:D,class:"my-5 border",loading:s.loading},{default:e(()=>[l(f(_.complementData(s))+" ",1),t(R,{class:"d-lg-flex justify-between"},{default:e(()=>[c("div",le,[t(L,{color:"primary"},{default:e(()=>[l(f(s.ct_inspection_form),1)]),_:2},1024),t(F,null,{default:e(()=>[l("Campo")]),_:1})]),c("div",ce,[_.isEmptyField(s.content.inspection_form_value)?g("",!0):(a(),r(q,{key:0,color:"success"},{default:e(()=>[l("mdi-check")]),_:1})),_.isEmptyField(s.content.inspection_form_value)&&s.required?(a(),r(q,{key:1,color:"red"},{default:e(()=>[l("mdi-alert-circle-outline")]),_:1})):g("",!0)])]),_:2},1024),t(x,{class:"pt-0"},{default:e(()=>[t(y,null,{default:e(()=>[t(p,{cols:"12",lg:"6"},{default:e(()=>[c("p",re,"Código de falla ("+f(s.required?"*Requerido":"Opcional")+"):",1),t(B,{modelValue:s.content.inspection_form_value,"onUpdate:modelValue":o=>s.content.inspection_form_value=o,items:v.failures,"item-title":"failure","item-value":"failure",variant:"outlined","hide-details":"",class:"rounded",density:"compact",clearable:""},null,8,["modelValue","onUpdate:modelValue","items"])]),_:2},1024),t(p,{cols:"12",lg:"6"},{default:e(()=>[_e,t(B,{modelValue:s.content.ct_risk_id,"onUpdate:modelValue":o=>s.content.ct_risk_id=o,items:v.ct_risks,"item-title":"ct_risk","item-value":"ct_risk_id",variant:"outlined","hide-details":"",class:"rounded",density:"compact",style:A({"background-color":_.getBgColor(s.content.ct_risk_id)}),clearable:""},{item:e(({props:o,item:V})=>[t(N,I(o,{title:V.raw.ct_risk,style:{"background-color":V.raw.ct_color},value:"ct_risk"}),null,16,["title","style"])]),_:2},1032,["modelValue","onUpdate:modelValue","items","style"])]),_:2},1024)]),_:2},1024),de,t(y,null,{default:e(()=>[t(p,{cols:"12",lg:"8"},{default:e(()=>[t(H,{content:s.content.inspection_form_comments,"onUpdate:content":o=>s.content.inspection_form_comments=o,theme:"snow",toolbar:"essential",contentType:"html",onClick:o=>_.getSuggestions(s)},null,8,["content","onUpdate:content","onClick"])]),_:2},1024),t(p,{cols:"12",lg:"4"},{default:e(()=>[t(k,{class:"mx-auto border",color:"primary",variant:"outlined"},{default:e(()=>[t(F,{class:"mt-2 mb-0"},{default:e(()=>[ue,l(" Sugerencias")]),_:1}),s.loadingSuggestions?(a(),r(M,{key:1,type:"paragraph"})):(a(),r(x,{key:0,class:"py-1 card-suggestions overflow-y-auto"},{default:e(()=>[(a(!0),m(w,null,b(s.suggestions,(o,V)=>(a(),r(k,{variant:"tonal",class:"my-1",key:V,onClick:u=>_.setComment(s,o)},{default:e(()=>[c("div",{class:"m-1",innerHTML:o},null,8,me)]),_:2},1032,["onClick"]))),128))]),_:2},1024)),s.suggestions?g("",!0):(a(),r(x,{key:2,class:"pt-0 card-suggestions overflow-y-auto"},{default:e(()=>[l("No hay sugerencias")]),_:1}))]),_:2},1024)]),_:2},1024)]),_:2},1024),t(y,null,{default:e(()=>[t(Q,{inspection_uuid:h.inspection_uuid,inspection_form_id:s.content.inspection_form_id},null,8,["inspection_uuid","inspection_form_id"])]),_:2},1024),t(G,{onClick:o=>_.saveField(s),class:"mt-2",disabled:s.loading},{default:e(()=>[l("Guardar ")]),_:2},1032,["onClick","disabled"])]),_:2},1024)]),_:2},1032,["loading"]))),128))])):g("",!0),C.sub_sections?(a(),m("div",pe,[t(O,{multiple:""},{default:e(()=>[(a(!0),m(w,null,b(C.sub_sections,(s,D)=>(a(),r(z,{key:D,class:"my-5 border"},{default:e(()=>[t(P,{class:"text-h6"},{default:e(()=>[t(L,{color:"primary",variant:"elevated"},{default:e(()=>[l(f(s.ct_inspection_section),1)]),_:2},1024),t(F,{class:"ml-2 mt-0 pt-0"},{default:e(()=>[l(" Sub-sección ")]),_:1})]),_:2},1024),t(j,null,{default:e(()=>[s.fields?(a(),m("div",ge,[(a(!0),m(w,null,b(s.fields,(o,V)=>(a(),r(k,{key:V,class:"my-5 border",loading:o.loading},{default:e(()=>[l(f(_.complementData(o))+" ",1),t(R,{class:"d-lg-flex justify-between"},{default:e(()=>[c("div",ve,[t(L,{color:"primary"},{default:e(()=>[l(f(o.ct_inspection_form),1)]),_:2},1024),t(F,null,{default:e(()=>[l("Campo")]),_:1})]),c("div",fe,[_.isEmptyField(o.content.inspection_form_value)?g("",!0):(a(),r(q,{key:0,color:"success"},{default:e(()=>[l("mdi-check")]),_:1})),_.isEmptyField(o.content.inspection_form_value)&&o.required?(a(),r(q,{key:1,color:"red"},{default:e(()=>[l("mdi-alert-circle-outline")]),_:1})):g("",!0)])]),_:2},1024),t(x,{class:"pt-0"},{default:e(()=>[t(y,null,{default:e(()=>[t(p,{cols:"12",lg:"6"},{default:e(()=>[c("p",he,"Código de falla ("+f(o.required?"*Requerido":"Opcional")+"):",1),t(B,{modelValue:o.content.inspection_form_value,"onUpdate:modelValue":u=>o.content.inspection_form_value=u,items:v.failures,"item-title":"failure","item-value":"failure",variant:"outlined","hide-details":"",class:"rounded",density:"compact",clearable:""},null,8,["modelValue","onUpdate:modelValue","items"])]),_:2},1024),t(p,{cols:"12",lg:"6"},{default:e(()=>[ye,t(B,{modelValue:o.content.ct_risk_id,"onUpdate:modelValue":u=>o.content.ct_risk_id=u,items:v.ct_risks,"item-title":"ct_risk","item-value":"ct_risk_id",variant:"outlined","hide-details":"",class:"rounded",density:"compact",style:A({"background-color":_.getBgColor(o.content.ct_risk_id)}),clearable:""},{item:e(({props:u,item:T})=>[t(N,I(u,{title:T.raw.ct_risk,style:{"background-color":T.raw.ct_color},value:"ct_risk"}),null,16,["title","style"])]),_:2},1032,["modelValue","onUpdate:modelValue","items","style"])]),_:2},1024)]),_:2},1024),ke,t(y,null,{default:e(()=>[t(p,{cols:"12",lg:"8"},{default:e(()=>[t(H,{content:o.content.inspection_form_comments,"onUpdate:content":u=>o.content.inspection_form_comments=u,theme:"snow",toolbar:"essential",heigth:"100%",contentType:"html",onClick:u=>_.getSuggestions(o)},null,8,["content","onUpdate:content","onClick"])]),_:2},1024),t(p,{cols:"12",lg:"4"},{default:e(()=>[t(k,{class:"mx-auto border",color:"primary",variant:"outlined"},{default:e(()=>[t(F,{class:"mt-2 mb-0"},{default:e(()=>[xe,l(" Sugerencias")]),_:1}),o.loadingSuggestions?(a(),r(M,{key:1,type:"paragraph"})):(a(),r(x,{key:0,class:"py-1 card-suggestions overflow-y-auto"},{default:e(()=>[(a(!0),m(w,null,b(o.suggestions,(u,T)=>(a(),r(k,{variant:"tonal",class:"my-1",key:T,onClick:Ve=>_.setComment(o,u)},{default:e(()=>[c("div",{class:"m-1",innerHTML:u},null,8,Ce)]),_:2},1032,["onClick"]))),128))]),_:2},1024)),o.suggestions?g("",!0):(a(),r(x,{key:2,class:"pt-0 card-suggestions overflow-y-auto"},{default:e(()=>[l("No hay sugerencias")]),_:1}))]),_:2},1024)]),_:2},1024)]),_:2},1024),t(y,null,{default:e(()=>[t(Q,{inspection_uuid:h.inspection_uuid,inspection_form_id:o.content.inspection_form_id},null,8,["inspection_uuid","inspection_form_id"])]),_:2},1024),t(G,{onClick:u=>_.saveField(o),class:"mt-2",disabled:o.loading},{default:e(()=>[l(" Guardar")]),_:2},1032,["onClick","disabled"])]),_:2},1024)]),_:2},1032,["loading"]))),128))])):g("",!0)]),_:2},1024)]),_:2},1024))),128))]),_:2},1024)])):g("",!0)]),_:2},1024)]),_:2},1024))),128))]),_:1},8,["modelValue"])]),_:1})]),_:1})]),_:1})]),_:1})]),_:1},8,["loading"])])])}const Re=ee(te,[["render",Fe]]);export{Re as default};