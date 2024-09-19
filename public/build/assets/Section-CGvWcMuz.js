import{Q as X}from"./vue-quill.esm-bundler-Df9Kzb0R.js";import{_ as Y}from"./PrimaryButton-D0cKB190.js";import Z from"./Evidence-S3HJwoOT.js";import{L as S,a2 as L,q as $,r as i,o as s,e as m,a as r,b as t,w as e,c,F as b,z as E,d as l,t as h,g as p,x as P,a1 as I}from"./app-DC8I-GIF.js";import{_ as ee}from"./_plugin-vue_export-helper-DlAUqK2U.js";import"./EvidenceForm-lKGdyyg1.js";import"./sweetalert2.all-BPh6nqTW.js";import"./filepond-plugin-image-transform.esm-Bby1FqvR.js";import"./ImageEditor-BcqHP6id.js";import"./api-l11sRj_d.js";const te={components:{QuillEditor:X,PrimaryButton:Y,Toaster:S,Evidence:Z},props:{dialogForm:{type:Boolean,required:!0},ct_inspection_uuid:{type:String,required:!0},inspection_uuid:{type:String,required:!0}},data(){return{dialogFormLoading:!1,sectionsForm:[],expandedPanel:[0,1,2,3,4,5,6],ct_risks:[],suggestions:[],failures:[]}},methods:{getForm(){this.dialogFormLoading=!0,L.get("api/inspection/forms/get-form-inspection/"+this.inspection_uuid).then(n=>{this.dialogFormLoading=!1,this.sectionsForm=n.data.data.sections}).catch(n=>{this.dialogFormLoading=!1,this.handleErrors(n)})},closeSectionDialog(){this.$emit("closeSectionDialog")},async saveField(n){n.loading=!0;let u={inspection_uuid:this.inspection_uuid,form:[{inspection_form_value:n.content.inspection_form_value??" ",inspection_form_comments:n.content.inspection_form_comments,ct_inspection_form_uuid:n.ct_inspection_form_uuid,ct_risk_id:n.content.ct_risk_id}]};await L.post("api/inspection/forms/set-form-inspection",u).then(U=>{n.loading=!1,$.success("Campo guardado correctamente"),U.data.data.length>0?(n.content=U.data.data[0],this.getSuggestions(n)):this.getForm()}).catch(U=>{n.loading=!1,this.handleErrors(U)});let y=document.querySelector("#btn_upload_evidence_"+n.content.inspection_form_id+" .filepond--action-process-item");y&&y.click()},complementData(n){n.content==null&&(n.content={inspection_form_value:"",inspection_form_comments:"",ct_risk_id:null,inspection_form_id:null})},isEmptyField(n){return n==null||n==""||n=="<p><br></p>"},getRisks(){L.get("api/risks").then(n=>{this.ct_risks=n.data.data}).catch(n=>{this.handleErrors(n)})},getFailures(){L.get("api/failures").then(n=>{this.failures=n.data.data}).catch(n=>{this.handleErrors(n)})},getBgColor(n){let u=this.ct_risks.filter(y=>n===y.ct_risk_id);return u.length>0?u[0].ct_color:""},async getSuggestions(n){n.loadingSuggestions=!0,await L.get("api/inspection/forms/get-field-suggestions/"+n.ct_inspection_form_uuid).then(u=>{n.loadingSuggestions=!1,n.suggestions=u.data.data}).catch(u=>{n.loadingSuggestions=!1,this.handleErrors(u)})},setComment(n,u){n.content.inspection_form_comments=u}},created(){this.getForm(),this.getRisks(),this.getFailures()}},ne={class:"max-w-7xl mx-auto sm:px-4 lg:px-6 mb-5 pb-5"},oe={class:"overflow-hidden shadow-sm sm:rounded-lg"},se=r("p",{class:"text-grey mb-2 text-h5 font-weight-bold"}," Carga de evidencias ",-1),ae=r("p",{class:"text-primary"},"Rellena la información relacionada con las evidencias de la inspección.",-1),ie={key:0},le={class:"d-flex align-center"},ce={class:"d-flex align-center gap-3"},re={class:"text-grey"},_e=r("p",{class:"text-grey"}," Riesgo:",-1),de=r("p",{class:"mt-3 text-grey"}," Comentarios:",-1),ue=r("span",{class:"mdi mdi-lightbulb-on-outline"},null,-1),me=["innerHTML"],pe={key:1},ge={key:0},fe={class:"d-flex align-center"},ve={class:"d-lg-flex align-center gap-3"},he={class:"text-grey"},ye=r("p",{class:"text-grey"}," Riesgo:",-1),ke=r("p",{class:"mt-3 text-grey"}," Comentarios: ",-1),xe=r("span",{class:"mdi mdi-lightbulb-on-outline"},null,-1),Ce=["innerHTML"];function we(n,u,y,U,g,d){const J=i("v-divider"),q=i("v-chip"),V=i("v-card-subtitle"),N=i("v-expansion-panel-title"),B=i("v-icon"),H=i("v-card-title"),T=i("v-list-item"),D=i("v-autocomplete"),f=i("v-col"),k=i("v-row"),M=i("QuillEditor"),x=i("v-card"),C=i("v-card-text"),Q=i("v-skeleton-loader"),j=i("Evidence"),z=i("PrimaryButton"),G=i("v-expansion-panel-text"),O=i("v-expansion-panel"),A=i("v-expansion-panels"),K=i("v-container");return s(),m("div",ne,[r("div",oe,[t(x,{loading:g.dialogFormLoading},{default:e(()=>[t(C,{class:""},{default:e(()=>[se,ae,t(J),t(K,null,{default:e(()=>[t(k,null,{default:e(()=>[g.sectionsForm?(s(),c(f,{key:0,cols:"12",class:"padding-0"},{default:e(()=>[t(A,{multiple:"",modelValue:g.expandedPanel,"onUpdate:modelValue":u[0]||(u[0]=w=>g.expandedPanel=w)},{default:e(()=>[(s(!0),m(b,null,E(g.sectionsForm,(w,W)=>(s(),c(O,{key:W,class:"my-5 border",expanded:!0},{default:e(()=>[t(N,{class:"text-h6"},{default:e(()=>[t(q,{color:"primary",variant:"elevated"},{default:e(()=>[l(h(w.section_details.ct_inspection_section),1)]),_:2},1024),t(V,{class:"ml-2 mt-0 pt-0"},{default:e(()=>[l(" Sección ")]),_:1})]),_:2},1024),t(G,null,{default:e(()=>[w.fields?(s(),m("div",ie,[(s(!0),m(b,null,E(w.fields,(a,R)=>(s(),c(x,{key:R,class:"my-5 border",loading:a.loading},{default:e(()=>[l(h(d.complementData(a))+" ",1),t(H,{class:"d-lg-flex justify-between"},{default:e(()=>[r("div",le,[t(q,{color:"primary"},{default:e(()=>[l(h(a.ct_inspection_form),1)]),_:2},1024),t(V,null,{default:e(()=>[l("Campo")]),_:1})]),r("div",ce,[d.isEmptyField(a.content.inspection_form_value)?p("",!0):(s(),c(B,{key:0,color:"success"},{default:e(()=>[l("mdi-check")]),_:1})),d.isEmptyField(a.content.inspection_form_value)&&a.required?(s(),c(B,{key:1,color:"red"},{default:e(()=>[l("mdi-alert-circle-outline")]),_:1})):p("",!0)])]),_:2},1024),t(C,{class:"pt-0"},{default:e(()=>[t(k,null,{default:e(()=>[t(f,{cols:"12",lg:"6"},{default:e(()=>[r("p",re,"Código de falla ("+h(a.required?"*Requerido":"Opcional")+"):",1),t(D,{modelValue:a.content.inspection_form_value,"onUpdate:modelValue":o=>a.content.inspection_form_value=o,items:g.failures,"item-title":"failure","item-value":"failure",variant:"outlined","hide-details":"",class:"rounded",density:"compact",clearable:""},{item:e(({props:o,item:v})=>[t(T,P(o,{subtitle:v.raw.category.ct_failure,title:v.raw.failure}),null,16,["subtitle","title"])]),_:2},1032,["modelValue","onUpdate:modelValue","items"])]),_:2},1024),t(f,{cols:"12",lg:"6"},{default:e(()=>[_e,t(D,{modelValue:a.content.ct_risk_id,"onUpdate:modelValue":o=>a.content.ct_risk_id=o,items:g.ct_risks,"item-title":"ct_risk","item-value":"ct_risk_id",variant:"outlined","hide-details":"",class:"rounded",density:"compact",style:I({"background-color":d.getBgColor(a.content.ct_risk_id)}),clearable:""},{item:e(({props:o,item:v})=>[t(T,P(o,{title:v.raw.ct_risk,style:{"background-color":v.raw.ct_color},value:"ct_risk"}),null,16,["title","style"])]),_:2},1032,["modelValue","onUpdate:modelValue","items","style"])]),_:2},1024)]),_:2},1024),de,t(k,null,{default:e(()=>[t(f,{cols:"12",lg:"8"},{default:e(()=>[t(M,{content:a.content.inspection_form_comments,"onUpdate:content":o=>a.content.inspection_form_comments=o,theme:"snow",toolbar:"essential",contentType:"html",onClick:o=>d.getSuggestions(a)},null,8,["content","onUpdate:content","onClick"])]),_:2},1024),t(f,{cols:"12",lg:"4"},{default:e(()=>[t(x,{class:"mx-auto border",color:"primary",variant:"outlined"},{default:e(()=>[t(V,{class:"mt-2 mb-0"},{default:e(()=>[ue,l(" Sugerencias")]),_:1}),a.loadingSuggestions?(s(),c(Q,{key:1,type:"paragraph"})):(s(),c(C,{key:0,class:"py-1 card-suggestions overflow-y-auto"},{default:e(()=>[(s(!0),m(b,null,E(a.suggestions,(o,v)=>(s(),c(x,{variant:"tonal",class:"my-1",key:v,onClick:_=>d.setComment(a,o)},{default:e(()=>[r("div",{class:"m-1",innerHTML:o},null,8,me)]),_:2},1032,["onClick"]))),128))]),_:2},1024)),a.suggestions?p("",!0):(s(),c(C,{key:2,class:"pt-0 card-suggestions overflow-y-auto"},{default:e(()=>[l("No hay sugerencias")]),_:1}))]),_:2},1024)]),_:2},1024)]),_:2},1024),t(k,null,{default:e(()=>[t(j,{inspection_uuid:y.inspection_uuid,inspection_form_id:a.content.inspection_form_id},null,8,["inspection_uuid","inspection_form_id"])]),_:2},1024),t(z,{onClick:o=>d.saveField(a),class:"mt-2",disabled:a.loading},{default:e(()=>[l("Guardar ")]),_:2},1032,["onClick","disabled"])]),_:2},1024)]),_:2},1032,["loading"]))),128))])):p("",!0),w.sub_sections?(s(),m("div",pe,[t(A,{multiple:""},{default:e(()=>[(s(!0),m(b,null,E(w.sub_sections,(a,R)=>(s(),c(O,{key:R,class:"my-5 border"},{default:e(()=>[t(N,{class:"text-h6"},{default:e(()=>[t(q,{color:"primary",variant:"elevated"},{default:e(()=>[l(h(a.ct_inspection_section),1)]),_:2},1024),t(V,{class:"ml-2 mt-0 pt-0"},{default:e(()=>[l(" Sub-sección ")]),_:1})]),_:2},1024),t(G,null,{default:e(()=>[a.fields?(s(),m("div",ge,[(s(!0),m(b,null,E(a.fields,(o,v)=>(s(),c(x,{key:v,class:"my-5 border",loading:o.loading},{default:e(()=>[l(h(d.complementData(o))+" ",1),t(H,{class:"d-lg-flex justify-between"},{default:e(()=>[r("div",fe,[t(q,{color:"primary"},{default:e(()=>[l(h(o.ct_inspection_form),1)]),_:2},1024),t(V,null,{default:e(()=>[l("Campo")]),_:1})]),r("div",ve,[d.isEmptyField(o.content.inspection_form_value)?p("",!0):(s(),c(B,{key:0,color:"success"},{default:e(()=>[l("mdi-check")]),_:1})),d.isEmptyField(o.content.inspection_form_value)&&o.required?(s(),c(B,{key:1,color:"red"},{default:e(()=>[l("mdi-alert-circle-outline")]),_:1})):p("",!0)])]),_:2},1024),t(C,{class:"pt-0"},{default:e(()=>[t(k,null,{default:e(()=>[t(f,{cols:"12",lg:"6"},{default:e(()=>[r("p",he,"Código de falla ("+h(o.required?"*Requerido":"Opcional")+"):",1),t(D,{modelValue:o.content.inspection_form_value,"onUpdate:modelValue":_=>o.content.inspection_form_value=_,items:g.failures,"item-title":"failure","item-value":"failure",variant:"outlined","hide-details":"",class:"rounded",density:"compact",clearable:""},{item:e(({props:_,item:F})=>[t(T,P(_,{subtitle:F.raw.category.ct_failure,title:F.raw.failure}),null,16,["subtitle","title"])]),_:2},1032,["modelValue","onUpdate:modelValue","items"])]),_:2},1024),t(f,{cols:"12",lg:"6"},{default:e(()=>[ye,t(D,{modelValue:o.content.ct_risk_id,"onUpdate:modelValue":_=>o.content.ct_risk_id=_,items:g.ct_risks,"item-title":"ct_risk","item-value":"ct_risk_id",variant:"outlined","hide-details":"",class:"rounded",density:"compact",style:I({"background-color":d.getBgColor(o.content.ct_risk_id)}),clearable:""},{item:e(({props:_,item:F})=>[t(T,P(_,{title:F.raw.ct_risk,style:{"background-color":F.raw.ct_color},value:"ct_risk"}),null,16,["title","style"])]),_:2},1032,["modelValue","onUpdate:modelValue","items","style"])]),_:2},1024)]),_:2},1024),ke,t(k,null,{default:e(()=>[t(f,{cols:"12",lg:"8"},{default:e(()=>[t(M,{content:o.content.inspection_form_comments,"onUpdate:content":_=>o.content.inspection_form_comments=_,theme:"snow",toolbar:"essential",heigth:"100%",contentType:"html",onClick:_=>d.getSuggestions(o)},null,8,["content","onUpdate:content","onClick"])]),_:2},1024),t(f,{cols:"12",lg:"4"},{default:e(()=>[t(x,{class:"mx-auto border",color:"primary",variant:"outlined"},{default:e(()=>[t(V,{class:"mt-2 mb-0"},{default:e(()=>[xe,l(" Sugerencias")]),_:1}),o.loadingSuggestions?(s(),c(Q,{key:1,type:"paragraph"})):(s(),c(C,{key:0,class:"py-1 card-suggestions overflow-y-auto"},{default:e(()=>[(s(!0),m(b,null,E(o.suggestions,(_,F)=>(s(),c(x,{variant:"tonal",class:"my-1",key:F,onClick:Fe=>d.setComment(o,_)},{default:e(()=>[r("div",{class:"m-1",innerHTML:_},null,8,Ce)]),_:2},1032,["onClick"]))),128))]),_:2},1024)),o.suggestions?p("",!0):(s(),c(C,{key:2,class:"pt-0 card-suggestions overflow-y-auto"},{default:e(()=>[l("No hay sugerencias")]),_:1}))]),_:2},1024)]),_:2},1024)]),_:2},1024),t(k,null,{default:e(()=>[t(j,{inspection_uuid:y.inspection_uuid,inspection_form_id:o.content.inspection_form_id},null,8,["inspection_uuid","inspection_form_id"])]),_:2},1024),t(z,{onClick:_=>d.saveField(o),class:"mt-2",disabled:o.loading},{default:e(()=>[l(" Guardar")]),_:2},1032,["onClick","disabled"])]),_:2},1024)]),_:2},1032,["loading"]))),128))])):p("",!0)]),_:2},1024)]),_:2},1024))),128))]),_:2},1024)])):p("",!0)]),_:2},1024)]),_:2},1024))),128))]),_:1},8,["modelValue"])]),_:1})):p("",!0)]),_:1})]),_:1})]),_:1})]),_:1},8,["loading"])])])}const Re=ee(te,[["render",we]]);export{Re as default};