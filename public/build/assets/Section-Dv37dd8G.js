import{Q as M}from"./vue-quill.esm-bundler-BZJk8zQx.js";import{_ as W}from"./PrimaryButton-Dhr6-raH.js";import{L as X,H as D,q as H,r as l,o as c,e as d,a as u,b as n,w as t,F as w,y as V,c as i,d as r,t as g,g as a,J,x as A}from"./app-D4wGiOJT.js";import{_ as Y}from"./_plugin-vue_export-helper-DlAUqK2U.js";const Z={components:{QuillEditor:M,PrimaryButton:W,Toaster:X},props:{dialogForm:{type:Boolean,required:!0},ct_inspection_uuid:{type:String,required:!0},inspection_uuid:{type:String,required:!0}},data(){return{dialogFormLoading:!1,sectionsForm:[],expandedPanel:[0,1,2,3,4,5,6],ct_risks:[],suggestions:[{id:1,text:"Funciona normalmente."},{id:4,text:"No se realiza."},{id:5,text:"No se detecta."}]}},methods:{getForm(){this.dialogFormLoading=!0,D.get("api/inspection/forms/get-form-inspection/"+this.inspection_uuid).then(e=>{this.dialogFormLoading=!1,this.sectionsForm=e.data.data.sections}).catch(e=>{this.dialogFormLoading=!1,this.handleErrors(e)})},closeSectionDialog(){this.$emit("closeSectionDialog")},saveField(e){e.loading=!0;let p={inspection_uuid:this.inspection_uuid,form:[{inspection_form_value:e.content.inspection_form_value,inspection_form_comments:e.content.inspection_form_comments,ct_inspection_form_uuid:e.ct_inspection_form_uuid,ct_risk_id:e.content.ct_risk_id}]};if(this.isEmptyField(p.form[0].inspection_form_value)){H.error("El contenido no puede estar vacío"),e.loading=!1;return}else D.post("api/inspection/forms/set-form-inspection",p).then(k=>{e.loading=!1,H.success("Campo guardado correctamente"),k.data.data.length>0?e.content=k.data.data[0]:this.getForm()}).catch(k=>{e.loading=!1,this.handleErrors(k)})},complementData(e){e.content==null?(e.content={inspection_form_value:"",inspection_form_comments:"",ct_risk_id:null},e.switch_comment=!1,e.switch_ct_risk=!1):(e.switch_comment=e.content.inspection_form_comments!==""&&e.content.inspection_form_comments!==null&&e.content.inspection_form_comments!=="<p><br></p>",e.switch_ct_risk=!!(e.content.ct_risk_id&&e.content.ct_risk_id!==null))},isEmptyField(e){return e==null||e==""||e=="<p><br></p>"},getRisks(){D.get("api/risks").then(e=>{this.ct_risks=e.data.data}).catch(e=>{this.handleErrors(e)})},getBgColor(e){let p=this.ct_risks.filter(k=>e===k.ct_risk_id);return p.length>0?p[0].ct_color:""},setRiesgo(e){e.switch_ct_risk==!0?(e.switch_ct_risk=!1,e.content.ct_risk_id=null):e.switch_ct_risk==!1&&(e.switch_ct_risk=!0)},getSuggestions(e){return this.suggestions},setComment(e,p){e.content.inspection_form_comments=e.content.inspection_form_comments+p}},mounted(){this.getForm(),this.getRisks()}},$={class:"max-w-7xl mx-auto sm:px-4 lg:px-6 mb-5 pb-5"},S={class:"overflow-hidden shadow-sm sm:rounded-lg"},tt={key:0},et={class:"d-flex align-center"},ot={class:"d-flex align-center gap-3"},nt={class:"text-grey"},st={key:0,class:"mt-3 text-grey"},ct=u("span",{class:"mdi mdi-lightbulb-on-outline"},null,-1),at={class:"m-1"},lt={key:2,class:"mt-3 text-grey"},it={key:1},rt={key:0},_t={class:"d-flex align-center"},mt={class:"d-lg-flex align-center gap-3"},dt={class:"text-grey"},ut={key:0,class:"mt-3 text-grey"},pt=u("span",{class:"mdi mdi-lightbulb-on-outline"},null,-1),gt={class:"m-1"},ht={key:2,class:"mt-3 text-grey"};function kt(e,p,k,vt,h,m){const U=l("v-chip"),x=l("v-card-subtitle"),P=l("v-expansion-panel-title"),b=l("v-switch"),E=l("v-icon"),N=l("v-card-title"),B=l("QuillEditor"),C=l("v-col"),v=l("v-card"),F=l("v-card-text"),q=l("v-row"),T=l("v-list-item"),Q=l("v-select"),j=l("PrimaryButton"),z=l("v-expansion-panel-text"),G=l("v-expansion-panel"),O=l("v-expansion-panels"),I=l("v-container");return c(),d("div",$,[u("div",S,[n(v,{loading:h.dialogFormLoading},{default:t(()=>[n(F,{class:"padding-0"},{default:t(()=>[n(I,null,{default:t(()=>[n(q,null,{default:t(()=>[n(C,{cols:"12",class:"padding-0"},{default:t(()=>[n(O,{multiple:"",modelValue:h.expandedPanel,"onUpdate:modelValue":p[0]||(p[0]=y=>h.expandedPanel=y)},{default:t(()=>[(c(!0),d(w,null,V(h.sectionsForm,(y,K)=>(c(),i(G,{key:K,class:"my-5 border",expanded:!0},{default:t(()=>[n(P,{class:"text-h6"},{default:t(()=>[n(U,{color:"primary",variant:"elevated"},{default:t(()=>[r(g(y.section_details.ct_inspection_section),1)]),_:2},1024),n(x,{class:"ml-2 mt-0 pt-0"},{default:t(()=>[r(" Sección ")]),_:1})]),_:2},1024),n(z,null,{default:t(()=>[y.fields?(c(),d("div",tt,[(c(!0),d(w,null,V(y.fields,(s,L)=>(c(),i(v,{key:L,class:"my-5 border",loading:s.loading},{default:t(()=>[r(g(m.complementData(s))+" ",1),n(N,{class:"d-lg-flex justify-between"},{default:t(()=>[u("div",et,[n(U,{color:"primary"},{default:t(()=>[r(g(s.ct_inspection_form),1)]),_:2},1024),n(x,null,{default:t(()=>[r("Campo")]),_:1})]),u("div",ot,[n(b,{modelValue:s.switch_comment,"onUpdate:modelValue":o=>s.switch_comment=o,color:"blue",label:"Comentario","hide-details":""},null,8,["modelValue","onUpdate:modelValue"]),n(b,{modelValue:s.switch_ct_risk,"onUpdate:modelValue":o=>s.switch_ct_risk=o,color:"blue",label:"Riesgo","hide-details":"",onClick:o=>m.setRiesgo(s)},null,8,["modelValue","onUpdate:modelValue","onClick"]),m.isEmptyField(s.content.inspection_form_value)?a("",!0):(c(),i(E,{key:0,color:"success"},{default:t(()=>[r("mdi-check")]),_:1})),m.isEmptyField(s.content.inspection_form_value)&&s.required?(c(),i(E,{key:1,color:"red"},{default:t(()=>[r("mdi-alert-circle-outline")]),_:1})):a("",!0)])]),_:2},1024),n(F,{class:"pt-0"},{default:t(()=>[u("p",nt,"Contenido ("+g(s.required?"*Requerido":"Opcional")+"):",1),n(B,{content:s.content.inspection_form_value,"onUpdate:content":o=>s.content.inspection_form_value=o,theme:"snow",toolbar:"essential",heigth:"100%",contentType:"html"},null,8,["content","onUpdate:content"]),s.switch_comment?(c(),d("p",st," Comentarios:")):a("",!0),s.switch_comment?(c(),i(q,{key:1},{default:t(()=>[n(C,{cols:"12",lg:"8"},{default:t(()=>[s.switch_comment?(c(),i(B,{key:0,content:s.content.inspection_form_comments,"onUpdate:content":o=>s.content.inspection_form_comments=o,theme:"snow",toolbar:"essential",contentType:"html"},null,8,["content","onUpdate:content"])):a("",!0)]),_:2},1024),h.suggestions.length?(c(),i(C,{key:0,cols:"12",lg:"4"},{default:t(()=>[n(v,{class:"mx-auto border",color:"primary",variant:"outlined"},{default:t(()=>[n(x,{class:"mt-2 mb-0"},{default:t(()=>[ct,r(" Sugerencias")]),_:1}),n(F,{class:"pt-1 card-suggestions overflow-y-auto"},{default:t(()=>[(c(!0),d(w,null,V(m.getSuggestions(s),(o,f)=>(c(),i(v,{variant:"tonal",class:"my-1",key:f,onClick:_=>m.setComment(s,o.text)},{default:t(()=>[u("p",at,g(o.text),1)]),_:2},1032,["onClick"]))),128))]),_:2},1024)]),_:2},1024)]),_:2},1024)):a("",!0)]),_:2},1024)):a("",!0),s.switch_ct_risk?(c(),d("p",lt," Riesgo:")):a("",!0),s.switch_ct_risk?(c(),i(Q,{key:3,modelValue:s.content.ct_risk_id,"onUpdate:modelValue":o=>s.content.ct_risk_id=o,items:h.ct_risks,"item-title":"ct_risk","item-value":"ct_risk_id",variant:"outlined","hide-details":"",class:"w-50 rounded",density:"compact",style:J({"background-color":m.getBgColor(s.content.ct_risk_id)})},{item:t(({props:o,item:f})=>[n(T,A(o,{title:f.raw.ct_risk,style:{"background-color":f.raw.ct_color},value:"ct_risk"}),null,16,["title","style"])]),_:2},1032,["modelValue","onUpdate:modelValue","items","style"])):a("",!0),n(j,{onClick:o=>m.saveField(s),class:"mt-2",disabled:s.loading},{default:t(()=>[r("Guardar ")]),_:2},1032,["onClick","disabled"])]),_:2},1024)]),_:2},1032,["loading"]))),128))])):a("",!0),y.sub_sections?(c(),d("div",it,[n(O,{multiple:""},{default:t(()=>[(c(!0),d(w,null,V(y.sub_sections,(s,L)=>(c(),i(G,{key:L,class:"my-5 border"},{default:t(()=>[n(P,{class:"text-h6"},{default:t(()=>[n(U,{color:"primary",variant:"elevated"},{default:t(()=>[r(g(s.ct_inspection_section),1)]),_:2},1024),n(x,{class:"ml-2 mt-0 pt-0"},{default:t(()=>[r(" Sub-sección ")]),_:1})]),_:2},1024),n(z,null,{default:t(()=>[s.fields?(c(),d("div",rt,[(c(!0),d(w,null,V(s.fields,(o,f)=>(c(),i(v,{key:f,class:"my-5 border",loading:o.loading},{default:t(()=>[r(g(m.complementData(o))+" ",1),n(N,{class:"d-lg-flex justify-between"},{default:t(()=>[u("div",_t,[n(U,{color:"primary"},{default:t(()=>[r(g(o.ct_inspection_form),1)]),_:2},1024),n(x,null,{default:t(()=>[r("Campo")]),_:1})]),u("div",mt,[n(b,{modelValue:o.switch_comment,"onUpdate:modelValue":_=>o.switch_comment=_,color:"blue",label:"Comentario","hide-details":""},null,8,["modelValue","onUpdate:modelValue"]),n(b,{modelValue:o.switch_ct_risk,"onUpdate:modelValue":_=>o.switch_ct_risk=_,color:"blue",label:"Riesgo","hide-details":"",onClick:_=>m.setRiesgo(o)},null,8,["modelValue","onUpdate:modelValue","onClick"]),m.isEmptyField(o.content.inspection_form_value)?a("",!0):(c(),i(E,{key:0,color:"success"},{default:t(()=>[r("mdi-check")]),_:1})),m.isEmptyField(o.content.inspection_form_value)&&o.required?(c(),i(E,{key:1,color:"red"},{default:t(()=>[r("mdi-alert-circle-outline")]),_:1})):a("",!0)])]),_:2},1024),n(F,{class:"pt-0"},{default:t(()=>[u("p",dt," Contenido ("+g(o.required?"*Requerido":"Opcional")+"):",1),n(B,{content:o.content.inspection_form_value,"onUpdate:content":_=>o.content.inspection_form_value=_,theme:"snow",toolbar:"essential",heigth:"100%",contentType:"html"},null,8,["content","onUpdate:content"]),o.switch_comment?(c(),d("p",ut," Comentarios: ")):a("",!0),o.switch_comment?(c(),i(q,{key:1},{default:t(()=>[n(C,{cols:"12",lg:"8"},{default:t(()=>[o.switch_comment?(c(),i(B,{key:0,content:o.content.inspection_form_comments,"onUpdate:content":_=>o.content.inspection_form_comments=_,theme:"snow",toolbar:"essential",heigth:"100%",contentType:"html"},null,8,["content","onUpdate:content"])):a("",!0)]),_:2},1024),h.suggestions.length?(c(),i(C,{key:0,cols:"12",lg:"4"},{default:t(()=>[n(v,{class:"mx-auto border",color:"primary",variant:"outlined"},{default:t(()=>[n(x,{class:"mt-2 mb-0"},{default:t(()=>[pt,r(" Sugerencias")]),_:1}),n(F,{class:"pt-1 card-suggestions overflow-y-auto"},{default:t(()=>[(c(!0),d(w,null,V(m.getSuggestions(o),(_,R)=>(c(),i(v,{variant:"tonal",class:"my-1",key:R,onClick:yt=>m.setComment(o,_.text)},{default:t(()=>[u("p",gt,g(_.text),1)]),_:2},1032,["onClick"]))),128))]),_:2},1024)]),_:2},1024)]),_:2},1024)):a("",!0)]),_:2},1024)):a("",!0),o.switch_ct_risk?(c(),d("p",ht," Riesgo:")):a("",!0),o.switch_ct_risk?(c(),i(Q,{key:3,modelValue:o.content.ct_risk_id,"onUpdate:modelValue":_=>o.content.ct_risk_id=_,items:h.ct_risks,"item-title":"ct_risk","item-value":"ct_risk_id",variant:"outlined","hide-details":"",class:"w-50 rounded",density:"compact",style:J({"background-color":m.getBgColor(o.content.ct_risk_id)})},{item:t(({props:_,item:R})=>[n(T,A(_,{title:R.raw.ct_risk,style:{"background-color":R.raw.ct_color},value:"ct_risk"}),null,16,["title","style"])]),_:2},1032,["modelValue","onUpdate:modelValue","items","style"])):a("",!0),n(j,{onClick:_=>m.saveField(o),class:"mt-2",disabled:o.loading},{default:t(()=>[r(" Guardar")]),_:2},1032,["onClick","disabled"])]),_:2},1024)]),_:2},1032,["loading"]))),128))])):a("",!0)]),_:2},1024)]),_:2},1024))),128))]),_:2},1024)])):a("",!0)]),_:2},1024)]),_:2},1024))),128))]),_:1},8,["modelValue"])]),_:1})]),_:1})]),_:1})]),_:1})]),_:1},8,["loading"])])])}const Ct=Y(Z,[["render",kt]]);export{Ct as default};