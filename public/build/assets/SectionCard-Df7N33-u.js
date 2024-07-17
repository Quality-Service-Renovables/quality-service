import{L as B,q as f,r as c,o as d,e as u,b as t,w as n,a as m,t as v,c as x,g as p,F as w,y as b,d as h}from"./app-D4wGiOJT.js";import L from"./FieldCard-B8tQkT8Q.js";import{_ as j}from"./_plugin-vue_export-helper-DlAUqK2U.js";const A={components:{Toaster:B,FieldCard:L},props:{section:{type:Object,required:!0},title:{type:String,required:!0},type:{type:String,required:!0},inspection:{type:Object,required:!0}},data(){return{dialogSection:!1,dialogField:!1,types:[{id:"field",name:"Campo"},{id:"section",name:"Sección"}],sectionForm:{ct_inspection_section_uuid:"",name:""},fieldForm:{ct_inspection_form_uuid:"",name:"",required:!0},editingSection:!1,dialogDeleteField:!1,fieldToDeleteUuid:null,editingField:!1}},methods:{async saveSectionForm(){let i=this.type=="section"?this.section.section_details.ct_inspection_section_uuid:this.section.ct_inspection_section_uuid,e=this.editingSection?"update":"create";await this.saveSection(e,this.inspection.ct_inspection_uuid,this.sectionForm.name,i),this.resetFormSection()},async saveFieldForm(){let i=this.type=="section"?this.section.section_details.ct_inspection_section_uuid:this.section.ct_inspection_section_uuid,e=this.editingField?"update":"create";await this.saveField(e,i),await this.updateSections(),this.resetFormField()},test(){console.log("test")},async saveSection(i,e,l,_=null){console.log("llego a saveSection");try{i=="create"?(console.log("llego a create"),await this.postSection(e,l,_)):i=="update"&&(console.log("llego a update"),await this.updateSection(e,l,_)),this.resetFormSection(),await this.updateSections()}catch(s){this.handleErrors(s)}},async postSection(i,e,l=null){const _=()=>axios.post("api/inspection/sections",{ct_inspection_uuid:i,ct_inspection_section:e,ct_inspection_relation_uuid:l});await f.promise(_(),{loading:"Creando sección...",success:s=>"Sección creada correctamente",error:s=>{this.handleErrors(s)}})},async updateSection(i,e,l=null){const _=()=>axios.put("api/inspection/sections/"+l,{ct_inspection_uuid:i,ct_inspection_section:e});await f.promise(_(),{loading:"Actualizando sección...",success:s=>"Sección actualizada correctamente",error:s=>{this.handleErrors(s)}})},updateSections(){console.log("Llego a updateSections en SectionCard"),this.$emit("update-sections")},resetFormSection(){this.dialogSection=!1,this.sectionForm.name="",this.sectionForm.ct_inspection_section_uuid="",this.editingSection=!1},resetFormField(){this.dialogField=!1,this.fieldForm.ct_inspection_form_uuid="",this.fieldForm.name="",this.fieldForm.required=!0},async saveField(i,e){i=="create"?(console.log("llego a create"),await this.postField(e)):i=="update"&&(console.log("llego a update"),await this.updateField(e))},async postField(i){const e=()=>axios.post("api/inspection/forms/set-form-fields",{ct_inspection_section_uuid:i,fields:[{ct_inspection_form:this.fieldForm.name,required:this.fieldForm.required}]});await f.promise(e(),{loading:"Creando campo...",success:l=>"Campo creado correctamente",error:l=>{this.handleErrors(l)}})},async updateField(i){const e=()=>axios.put("api/inspection/forms/update-form-field/"+this.fieldForm.ct_inspection_form_uuid,{ct_inspection_section_uuid:i,ct_inspection_form:this.fieldForm.name,required:this.fieldForm.required});await f.promise(e(),{loading:"Actualizando campo...",success:l=>"Campo actualizado correctamente",error:l=>{this.handleErrors(l)}})},deleteSection(i){let e=i.section_details?i.section_details.ct_inspection_section_uuid:i.ct_inspection_section_uuid;this.$emit("delete-section",e)},editSection(){this.editingSection=!0,this.dialogSection=!0;let i=this.type=="section"?this.section.section_details.ct_inspection_section_uuid:this.section.ct_inspection_section_uuid,e=this.type=="section"?this.section.section_details.ct_inspection_section:this.section.ct_inspection_section;this.sectionForm.name=e,this.sectionForm.ct_inspection_section_uuid=i},editField(i){this.editingField=!0,this.dialogField=!0,this.fieldForm.ct_inspection_form_uuid=i.ct_inspection_form_uuid,this.fieldForm.name=i.ct_inspection_form,this.fieldForm.required=i.required==1},closeDeleteField(){this.dialogDeleteField=!1,this.fieldToDeleteUuid=null},deleteField(i){this.dialogDeleteField=!0,this.fieldToDeleteUuid=i},async deleteFieldConfirm(){const i=()=>axios.delete("api/inspection/forms/delete-form-field/"+this.fieldToDeleteUuid);await f.promise(i(),{loading:"Eliminando...",success:e=>(this.closeDeleteField(),"Campo eliminado correctamente"),error:e=>{this.handleErrors(e)}}),await this.updateSections()}}},G={class:"d-flex"},O={class:"d-flex justify-between"},H={class:"text-h6 mr-2"},I={class:"bg-white rounded-xl border-0 px-2"},J={key:0},K={class:"text-h6 font-weight-black my-2"},M={key:1},P={class:"text-h6 font-weight-black my-2"},Q={key:0},W={class:"text-h6 font-weight-black my-2"},X={key:0},Y={key:1},Z=m("p",null,"Nuevo campo",-1);function $(i,e,l,_,s,a){const U=c("v-icon"),r=c("v-btn"),F=c("v-card-title"),q=c("FieldCard"),N=c("SectionCard",!0),S=c("v-card-text"),g=c("v-card"),V=c("v-text-field"),y=c("v-col"),D=c("v-row"),C=c("v-dialog"),R=c("v-checkbox"),E=c("v-spacer"),T=c("v-card-actions");return d(),u("div",G,[t(U,{class:"mdi mdi-subdirectory-arrow-right mt-4"}),t(g,{class:"w-100 mb-5",rounded:"lg",border:"dashed thin dark md"},{default:n(()=>[t(F,{class:"bg-blue-grey"},{default:n(()=>[m("div",O,[m("p",H,v(l.title),1),m("div",I,[l.type=="section"?(d(),x(r,{key:0,density:"compact",icon:"mdi-plus",variant:"plain",class:"me-1",color:"primary",onClick:e[0]||(e[0]=o=>s.dialogSection=!0)})):p("",!0),t(r,{density:"compact",icon:"mdi-focus-field-horizontal",variant:"plain",class:"me-1",color:"primary",onClick:e[1]||(e[1]=o=>s.dialogField=!0)}),t(r,{density:"compact",icon:"mdi-pencil",variant:"plain",class:"me-1",onClick:a.editSection},null,8,["onClick"]),t(r,{density:"compact",icon:"mdi-trash-can",variant:"plain",class:"me-1",color:"red",onClick:e[2]||(e[2]=o=>a.deleteSection(l.section))})])])]),_:1}),t(S,null,{default:n(()=>[l.section.fields?(d(),u("div",J,[m("p",K,"Campos ("+v(l.section.fields.length)+")",1),(d(!0),u(w,null,b(l.section.fields,o=>(d(),x(q,{key:o.id,field:o,onDeleteField:a.deleteField,onEditField:a.editField},null,8,["field","onDeleteField","onEditField"]))),128))])):p("",!0),l.section.sub_sections&&l.section.sub_sections.length>0?(d(),u("div",M,[m("p",P,"Sub-secciones ("+v(l.section.sub_sections.length)+")",1),(d(!0),u(w,null,b(l.section.sub_sections,(o,z)=>(d(),u("div",{key:z},[t(N,{section:o,title:o.ct_inspection_section,type:"sub_section",inspection:l.inspection,onUpdateSections:a.updateSections,onDeleteSection:k=>a.deleteSection(o)},{default:n(()=>[o.fields?(d(),u("div",Q,[m("p",W,"Campos ("+v(o.fields.length)+")",1),(d(!0),u(w,null,b(o.fields,k=>(d(),x(q,{key:k.id,field:k,onDeleteField:a.deleteField,onEditField:a.editField},null,8,["field","onDeleteField","onEditField"]))),128))])):p("",!0)]),_:2},1032,["section","title","inspection","onUpdateSections","onDeleteSection"])]))),128))])):p("",!0)]),_:1})]),_:1}),t(C,{modelValue:s.dialogSection,"onUpdate:modelValue":e[5]||(e[5]=o=>s.dialogSection=o),width:"auto"},{default:n(()=>[t(g,{"min-width":"500"},{actions:n(()=>[t(r,{class:"ms-auto",text:"Cancelar",onClick:e[4]||(e[4]=o=>s.dialogSection=!1)}),t(r,{color:"primary",text:"",onClick:a.saveSectionForm},{default:n(()=>[h("Guardar")]),_:1},8,["onClick"])]),default:n(()=>[t(F,null,{default:n(()=>[s.editingSection?p("",!0):(d(),u("p",X,"Nueva sub-sección")),s.editingSection?(d(),u("p",Y,"Editar sub-sección")):p("",!0)]),_:1}),t(S,null,{default:n(()=>[t(D,{dense:""},{default:n(()=>[t(y,{cols:"12"},{default:n(()=>[t(V,{label:"Nombre*",variant:"outlined",required:"","hide-details":"",modelValue:s.sectionForm.name,"onUpdate:modelValue":e[3]||(e[3]=o=>s.sectionForm.name=o)},null,8,["modelValue"])]),_:1})]),_:1})]),_:1})]),_:1})]),_:1},8,["modelValue"]),t(C,{modelValue:s.dialogField,"onUpdate:modelValue":e[9]||(e[9]=o=>s.dialogField=o),width:"auto"},{default:n(()=>[t(g,{"min-width":"500"},{actions:n(()=>[t(r,{class:"ms-auto",text:"Cancelar",onClick:e[8]||(e[8]=o=>s.dialogField=!1)}),t(r,{color:"primary",text:"",onClick:a.saveFieldForm},{default:n(()=>[h("Guardar")]),_:1},8,["onClick"])]),default:n(()=>[t(F,null,{default:n(()=>[Z]),_:1}),t(S,null,{default:n(()=>[t(D,{dense:""},{default:n(()=>[t(y,{cols:"12"},{default:n(()=>[t(V,{label:"Nombre*",variant:"outlined",required:"","hide-details":"",modelValue:s.fieldForm.name,"onUpdate:modelValue":e[6]||(e[6]=o=>s.fieldForm.name=o)},null,8,["modelValue"])]),_:1}),t(y,{cols:"12"},{default:n(()=>[t(R,{label:"Requerido",modelValue:s.fieldForm.required,"onUpdate:modelValue":e[7]||(e[7]=o=>s.fieldForm.required=o),"hide-details":""},null,8,["modelValue"])]),_:1})]),_:1})]),_:1})]),_:1})]),_:1},8,["modelValue"]),t(C,{modelValue:s.dialogDeleteField,"onUpdate:modelValue":e[11]||(e[11]=o=>s.dialogDeleteField=o),"max-width":"500px"},{default:n(()=>[t(g,null,{default:n(()=>[t(F,{class:"text-h5 text-center"},{default:n(()=>[h("¿Estás seguro de eliminar este campo?")]),_:1}),t(T,null,{default:n(()=>[t(E),t(r,{color:"blue-darken-1",variant:"text",onClick:a.closeDeleteField},{default:n(()=>[h("Cancel")]),_:1},8,["onClick"]),t(r,{color:"blue-darken-1",variant:"text",onClick:e[10]||(e[10]=o=>a.deleteFieldConfirm())},{default:n(()=>[h("Si, eliminar")]),_:1}),t(E)]),_:1})]),_:1})]),_:1},8,["modelValue"])])}const oe=j(A,[["render",$]]);export{oe as default};
