import{f as r,B as c,o as s,e as t,a as d,t as l,m,C as p,z as _,D as f,v}from"./app-D4wGiOJT.js";const g={class:"text-sm text-red-600"},S={__name:"InputError",props:{message:{type:String}},setup(e){return(a,o)=>r((s(),t("div",null,[d("p",g,l(e.message),1)],512)),[[c,e.message]])}},h={class:"block font-medium text-sm"},x={key:0},b={key:1},V={__name:"InputLabel",props:{value:{type:String}},setup(e){return(a,o)=>(s(),t("label",h,[e.value?(s(),t("span",x,l(e.value),1)):(s(),t("span",b,[m(a.$slots,"default")]))]))}},B={__name:"TextInput",props:{modelValue:{type:String,required:!0},modelModifiers:{}},emits:["update:modelValue"],setup(e,{expose:a}){const o=p(e,"modelValue"),n=_(null);return f(()=>{n.value.hasAttribute("autofocus")&&n.value.focus()}),a({focus:()=>n.value.focus()}),(y,u)=>r((s(),t("input",{class:"border focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm","onUpdate:modelValue":u[0]||(u[0]=i=>o.value=i),ref_key:"input",ref:n},null,512)),[[v,o.value]])}};export{V as _,B as a,S as b};
