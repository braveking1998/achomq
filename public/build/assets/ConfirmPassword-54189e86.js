import{T as n,o as l,i as d,w as t,a,u as o,Z as c,f as e,b as p,p as u,h as f}from"./app-dd8571fb.js";import{_}from"./GuestLayout-43855e95.js";import{_ as w,a as b,b as h}from"./TextInput-b12da949.js";import{P as x}from"./PrimaryButton-35509d27.js";import"./Search-7974246e.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./DropdownLink-4735ad2e.js";const g=e("div",{class:"mb-4 text-sm text-gray-600"}," This is a secure area of the application. Please confirm your password before continuing. ",-1),y={class:"flex justify-end mt-4"},j={__name:"ConfirmPassword",setup(P){const s=n({password:""}),i=()=>{s.post(route("password.confirm"),{onFinish:()=>s.reset()})};return(V,r)=>(l(),d(_,null,{default:t(()=>[a(o(c),{title:"Confirm Password"}),g,e("form",{onSubmit:f(i,["prevent"])},[e("div",null,[a(w,{for:"password",value:"Password"}),a(b,{id:"password",type:"password",class:"mt-1 block w-full",modelValue:o(s).password,"onUpdate:modelValue":r[0]||(r[0]=m=>o(s).password=m),required:"",autocomplete:"current-password",autofocus:""},null,8,["modelValue"]),a(h,{class:"mt-2",message:o(s).errors.password},null,8,["message"])]),e("div",y,[a(x,{class:u(["ms-4",{"opacity-25":o(s).processing}]),disabled:o(s).processing},{default:t(()=>[p(" Confirm ")]),_:1},8,["class","disabled"])])],32)]),_:1}))}};export{j as default};
