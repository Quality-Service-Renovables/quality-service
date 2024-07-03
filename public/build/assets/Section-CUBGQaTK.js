import{Q as J}from"./vue-quill.esm-bundler-CnR-NQtr.js";import{_ as K}from"./PrimaryButton-BBqn-HS7.js";import{L as M,H as q,q as G,r as a,o as c,e as _,a as B,b as n,w as o,F as V,y as F,c as m,d as i,t as d,g as l,x as O}from"./app-8C46bhNP.js";import{_ as W}from"./_plugin-vue_export-helper-DlAUqK2U.js";const X={components:{QuillEditor:J,PrimaryButton:K,Toaster:M},props:{dialogForm:{type:Boolean,required:!0},ct_inspection_uuid:{type:String,required:!0},inspection_uuid:{type:String,required:!0}},data(){return{dialogFormLoading:!1,sectionsForm:[],expandedPanel:[0,1,2,3,4,5,6],ct_risks:[]}},methods:{getForm(){this.dialogFormLoading=!0,q.get("api/inspection/forms/get-form-inspection/"+this.inspection_uuid).then(e=>{this.dialogFormLoading=!1,this.sectionsForm=e.data.data.sections}).catch(e=>{this.dialogFormLoading=!1,this.handleErrors(e)})},closeSectionDialog(){this.$emit("closeSectionDialog")},saveField(e){e.loading=!0;let u={inspection_uuid:this.inspection_uuid,form:[{inspection_form_value:e.content.inspection_form_value,inspection_form_comments:e.content.inspection_form_comments,ct_inspection_form_uuid:e.ct_inspection_form_uuid,ct_risk_id:e.content.ct_risk_id}]};if(console.log("formData: "),console.log(u),u.form[0].inspection_form_value==null||u.form[0].inspection_form_value==""){G.error("El campo no puede estar vacío"),e.loading=!1;return}else q.post("api/inspection/forms/set-form-inspection",u).then(v=>{e.loading=!1,G.success("Campo guardado correctamente"),v.data.data.length>0?e.content=v.data.data[0]:this.getForm()}).catch(v=>{e.loading=!1,this.handleErrors(v)})},complementData(e){e.content==null?(e.content={inspection_form_value:"",inspection_form_comments:"",ct_risk_id:null},e.switch_comment=!1,e.switch_ct_risk=!1):(e.switch_comment=e.content.inspection_form_comments!==""&&e.content.inspection_form_comments!==null&&e.content.inspection_form_comments!=="<p><br></p>",e.switch_ct_risk=!!(e.content.ct_risk_id&&e.content.ct_risk_id!==null))},isEmptyField(e){return e.content.inspection_form_value==null||e.content.inspection_form_value==""},getRisks(){q.get("api/risks").then(e=>{this.ct_risks=e.data.data}).catch(e=>{this.handleErrors(e)})}},mounted(){this.getForm(),this.getRisks()}},Y={class:"max-w-7xl mx-auto sm:px-4 lg:px-6 mb-5 pb-5"},Z={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},$={key:0},S={class:"d-flex gap-5"},tt={key:0,class:"mt-3 text-grey"},et={key:2,class:"mt-3 text-grey"},ot={key:1},nt={key:0},st={class:"d-flex gap-5"},ct={key:0,class:"mt-3 text-grey"},at={key:2,class:"mt-3 text-grey"};function it(e,u,v,lt,h,g){const k=a("v-card-subtitle"),D=a("v-expansion-panel-title"),y=a("v-icon"),L=a("v-card-title"),w=a("v-switch"),f=a("QuillEditor"),R=a("v-list-item"),P=a("v-select"),T=a("PrimaryButton"),U=a("v-card-text"),C=a("v-card"),b=a("v-expansion-panel-text"),j=a("v-expansion-panel"),N=a("v-expansion-panels"),H=a("v-col"),I=a("v-row"),z=a("v-container");return c(),_("div",Y,[B("div",Z,[n(C,{loading:h.dialogFormLoading},{default:o(()=>[n(U,{class:"padding-0"},{default:o(()=>[n(z,null,{default:o(()=>[n(I,null,{default:o(()=>[n(H,{cols:"12",class:"padding-0"},{default:o(()=>[n(N,{multiple:"",modelValue:h.expandedPanel,"onUpdate:modelValue":u[0]||(u[0]=p=>h.expandedPanel=p)},{default:o(()=>[(c(!0),_(V,null,F(h.sectionsForm,(p,A)=>(c(),m(j,{key:A,class:"my-5",expanded:!0},{default:o(()=>[n(D,{class:"text-h6"},{default:o(()=>[i(d(p.section_details.ct_inspection_section)+" ",1),n(k,{class:"ml-2 mt-0 pt-0"},{default:o(()=>[i(" Sección ")]),_:1})]),_:2},1024),n(b,null,{default:o(()=>[p.fields?(c(),_("div",$,[(c(!0),_(V,null,F(p.fields,(s,E)=>(c(),m(C,{key:E,class:"my-5",loading:s.loading},{default:o(()=>[i(d(g.complementData(s))+" ",1),n(L,{class:"d-flex justify-between"},{default:o(()=>[i(d(s.ct_inspection_form)+" ",1),s.content.inspection_form_value?(c(),m(y,{key:0,color:"success"},{default:o(()=>[i("mdi-check")]),_:1})):l("",!0),g.isEmptyField(s)&&s.required?(c(),m(y,{key:1,color:"red"},{default:o(()=>[i("mdi-alert-circle-outline")]),_:1})):l("",!0)]),_:2},1024),n(k,{class:"d-flex align-center justify-between"},{default:o(()=>[i(" Campo "+d(s.required?"*Requerido":"Opcional")+" ",1),B("div",S,[n(w,{modelValue:s.switch_comment,"onUpdate:modelValue":t=>s.switch_comment=t,color:"secondary",label:"Comentario","hide-details":""},null,8,["modelValue","onUpdate:modelValue"]),n(w,{modelValue:s.switch_ct_risk,"onUpdate:modelValue":t=>s.switch_ct_risk=t,color:"secondary",label:"Riesgo","hide-details":""},null,8,["modelValue","onUpdate:modelValue"])])]),_:2},1024),n(U,{class:"pt-0"},{default:o(()=>[n(f,{content:s.content.inspection_form_value,"onUpdate:content":t=>s.content.inspection_form_value=t,theme:"snow",toolbar:"essential",heigth:"100%",contentType:"html"},null,8,["content","onUpdate:content"]),s.switch_comment?(c(),_("p",tt," Comentarios:")):l("",!0),s.switch_comment?(c(),m(f,{key:1,content:s.content.inspection_form_comments,"onUpdate:content":t=>s.content.inspection_form_comments=t,theme:"snow",toolbar:"essential",heigth:"100%",contentType:"html"},null,8,["content","onUpdate:content"])):l("",!0),s.switch_ct_risk?(c(),_("p",et," Riesgo:")):l("",!0),s.switch_ct_risk?(c(),m(P,{key:3,modelValue:s.content.ct_risk_id,"onUpdate:modelValue":t=>s.content.ct_risk_id=t,items:h.ct_risks,"item-title":"ct_risk","item-value":"ct_risk_id",variant:"outlined","hide-details":"",class:"w-50",density:"compact"},{item:o(({props:t,item:x})=>[n(R,O(t,{title:x.raw.ct_risk,style:{"background-color":x.raw.ct_color},value:"ct_risk"}),null,16,["title","style"])]),_:2},1032,["modelValue","onUpdate:modelValue","items"])):l("",!0),n(T,{onClick:t=>g.saveField(s),class:"mt-2",disabled:s.loading},{default:o(()=>[i("Guardar ")]),_:2},1032,["onClick","disabled"])]),_:2},1024)]),_:2},1032,["loading"]))),128))])):l("",!0),p.sub_sections?(c(),_("div",ot,[n(N,{multiple:""},{default:o(()=>[(c(!0),_(V,null,F(p.sub_sections,(s,E)=>(c(),m(j,{key:E,class:"my-5"},{default:o(()=>[n(D,{class:"text-h6"},{default:o(()=>[i(d(s.ct_inspection_section)+" ",1),n(k,{class:"ml-2 mt-0 pt-0"},{default:o(()=>[i(" Sub-sección ")]),_:1})]),_:2},1024),n(b,null,{default:o(()=>[s.fields?(c(),_("div",nt,[(c(!0),_(V,null,F(s.fields,(t,x)=>(c(),m(C,{key:x,class:"my-5",loading:t.loading},{default:o(()=>[i(d(g.complementData(t))+" ",1),n(L,{class:"d-flex justify-between"},{default:o(()=>[i(d(t.ct_inspection_form)+" ",1),t.content.inspection_form_value?(c(),m(y,{key:0,color:"success"},{default:o(()=>[i("mdi-check")]),_:1})):l("",!0),g.isEmptyField(t)&&t.required?(c(),m(y,{key:1,color:"red"},{default:o(()=>[i("mdi-alert-circle-outline")]),_:1})):l("",!0)]),_:2},1024),n(k,{class:"d-flex align-center justify-between"},{default:o(()=>[i(" Campo "+d(t.required?"*Requerido":"Opcional")+" ",1),B("div",st,[n(w,{modelValue:t.switch_comment,"onUpdate:modelValue":r=>t.switch_comment=r,color:"secondary",label:"Comentario","hide-details":""},null,8,["modelValue","onUpdate:modelValue"]),n(w,{modelValue:t.switch_ct_risk,"onUpdate:modelValue":r=>t.switch_ct_risk=r,color:"secondary",label:"Riesgo","hide-details":""},null,8,["modelValue","onUpdate:modelValue"])])]),_:2},1024),n(U,null,{default:o(()=>[n(f,{content:t.content.inspection_form_value,"onUpdate:content":r=>t.content.inspection_form_value=r,theme:"snow",toolbar:"essential",heigth:"100%",contentType:"html"},null,8,["content","onUpdate:content"]),t.switch_comment?(c(),_("p",ct,"Comentarios: ")):l("",!0),t.switch_comment?(c(),m(f,{key:1,content:t.content.inspection_form_comments,"onUpdate:content":r=>t.content.inspection_form_comments=r,theme:"snow",toolbar:"essential",heigth:"100%",contentType:"html"},null,8,["content","onUpdate:content"])):l("",!0),t.switch_ct_risk?(c(),_("p",at," Riesgo:")):l("",!0),t.switch_ct_risk?(c(),m(P,{key:3,modelValue:t.content.ct_risk_id,"onUpdate:modelValue":r=>t.content.ct_risk_id=r,items:h.ct_risks,"item-title":"ct_risk","item-value":"ct_risk_id",variant:"outlined","hide-details":"",class:"w-50",density:"compact"},{item:o(({props:r,item:Q})=>[n(R,O(r,{title:Q.raw.ct_risk,style:{"background-color":Q.raw.ct_color},value:"ct_risk"}),null,16,["title","style"])]),_:2},1032,["modelValue","onUpdate:modelValue","items"])):l("",!0),n(T,{onClick:r=>g.saveField(t),class:"mt-2",disabled:t.loading},{default:o(()=>[i(" Guardar")]),_:2},1032,["onClick","disabled"])]),_:2},1024)]),_:2},1032,["loading"]))),128))])):l("",!0)]),_:2},1024)]),_:2},1024))),128))]),_:2},1024)])):l("",!0)]),_:2},1024)]),_:2},1024))),128))]),_:1},8,["modelValue"])]),_:1})]),_:1})]),_:1})]),_:1})]),_:1},8,["loading"])])])}const ut=W(X,[["render",it],["__scopeId","data-v-d2b827fc"]]);export{ut as default};
