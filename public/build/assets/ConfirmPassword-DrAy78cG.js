import{T as m,o as l,c as d,w as t,b as o,u as a,Z as c,a as e,d as p,n as f,i as u}from"./app-le8NcQIE.js";import{_}from"./GuestLayout-_VpCAqLS.js";import{_ as w,a as b,b as x}from"./TextInput-DvT8vF5A.js";import{_ as g}from"./PrimaryButton-DsIr2Rkd.js";import"./ApplicationLogo-2yOatRJv.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const h=e("div",{class:"mb-4 text-sm text-gray-600"}," This is a secure area of the application. Please confirm your password before continuing. ",-1),V={class:"flex justify-end mt-4"},T={__name:"ConfirmPassword",setup(v){const s=m({password:""}),i=()=>{s.post(route("password.confirm"),{onFinish:()=>s.reset()})};return(y,r)=>(l(),d(_,null,{default:t(()=>[o(a(c),{title:"Confirm Password"}),h,e("form",{onSubmit:u(i,["prevent"])},[e("div",null,[o(w,{for:"password",value:"Password"}),o(b,{id:"password",type:"password",class:"mt-1 block w-full",modelValue:a(s).password,"onUpdate:modelValue":r[0]||(r[0]=n=>a(s).password=n),required:"",autocomplete:"current-password",autofocus:""},null,8,["modelValue"]),o(x,{class:"mt-2",message:a(s).errors.password},null,8,["message"])]),e("div",V,[o(g,{class:f(["ms-4",{"opacity-25":a(s).processing}]),disabled:a(s).processing},{default:t(()=>[p(" Confirm ")]),_:1},8,["class","disabled"])])],32)]),_:1}))}};export{T as default};