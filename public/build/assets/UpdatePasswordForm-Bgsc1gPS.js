import{z as p,T as _,o as i,e as m,a as r,b as e,u as a,w,A as g,i as v,d as y,g as V}from"./app-DHtr17ZB.js";import{a as l,b as n,_ as u}from"./TextInput-BLYI4ecG.js";import{_ as x}from"./PrimaryButton-B3XcTgJg.js";const b=r("header",null,[r("h2",{class:"text-lg font-medium text-gray-900"},"Actualizar contraseña"),r("p",{class:"mt-1 text-sm text-gray-600"}," Asegúrese de que su cuenta utilice una contraseña larga y aleatoria para mantenerse segura. ")],-1),k={class:"flex items-center gap-4"},N={key:0,class:"text-sm text-gray-600"},$={__name:"UpdatePasswordForm",setup(C){const d=p(null),c=p(null),s=_({current_password:"",password:"",password_confirmation:""}),f=()=>{s.put(route("password.update"),{preserveScroll:!0,onSuccess:()=>s.reset(),onError:()=>{s.errors.password&&(s.reset("password","password_confirmation"),d.value.focus()),s.errors.current_password&&(s.reset("current_password"),c.value.focus())}})};return(I,o)=>(i(),m("section",null,[b,r("form",{onSubmit:v(f,["prevent"]),class:"mt-6 space-y-6"},[r("div",null,[e(u,{for:"current_password",value:"Contraseña actual"}),e(l,{id:"current_password",ref_key:"currentPasswordInput",ref:c,modelValue:a(s).current_password,"onUpdate:modelValue":o[0]||(o[0]=t=>a(s).current_password=t),type:"password",class:"mt-1 block w-full",autocomplete:"current-password"},null,8,["modelValue"]),e(n,{message:a(s).errors.current_password,class:"mt-2"},null,8,["message"])]),r("div",null,[e(u,{for:"password",value:"Nueva contraseña"}),e(l,{id:"password",ref_key:"passwordInput",ref:d,modelValue:a(s).password,"onUpdate:modelValue":o[1]||(o[1]=t=>a(s).password=t),type:"password",class:"mt-1 block w-full",autocomplete:"new-password"},null,8,["modelValue"]),e(n,{message:a(s).errors.password,class:"mt-2"},null,8,["message"])]),r("div",null,[e(u,{for:"password_confirmation",value:"Confirmar contraseña"}),e(l,{id:"password_confirmation",modelValue:a(s).password_confirmation,"onUpdate:modelValue":o[2]||(o[2]=t=>a(s).password_confirmation=t),type:"password",class:"mt-1 block w-full",autocomplete:"new-password"},null,8,["modelValue"]),e(n,{message:a(s).errors.password_confirmation,class:"mt-2"},null,8,["message"])]),r("div",k,[e(x,{disabled:a(s).processing},{default:w(()=>[y("Guardar")]),_:1},8,["disabled"]),e(g,{"enter-active-class":"transition ease-in-out","enter-from-class":"opacity-0","leave-active-class":"transition ease-in-out","leave-to-class":"opacity-0"},{default:w(()=>[a(s).recentlySuccessful?(i(),m("p",N,"Guardado.")):V("",!0)]),_:1})])],32)]))}};export{$ as default};
