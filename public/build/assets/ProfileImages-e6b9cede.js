import{B as k}from"./BoxWithTitle-a3c9f2bc.js";import{Q as x,d as u,o as t,i as d,w as a,b as p,f as o,c as l,F as h,j as f,t as w,l as g,u as C,k as B,p as F,O as v}from"./app-dd8571fb.js";import"./_plugin-vue_export-helper-c27b6911.js";const V={class:"flex flex-col gap-4"},I={key:0},N={class:"flex gap-12 flex-wrap"},O=["src","alt","onClick"],S={__name:"ProfileImages",props:{images:Object},setup(m){const i=x(),y=u(()=>i.props.auth.selectedImage),c=u(()=>Object.values(i.props.errors)),b=r=>{let s=r.target.files[0];console.log(s),v.post(route("profile.images.store"),{image:s,type:"private"},{onSuccess:()=>{flashMessageVisible.value=!0,flashMessageVisibleChange(2e3)}})},_=r=>{v.put(route("profile.update.image",{image_id:r}))};return(r,s)=>(t(),d(k,null,{title:a(()=>[p("انتخاب عکس پروفایل")]),default:a(()=>[o("div",V,[c.value.length?(t(),l("div",I,[(t(!0),l(h,null,f(c.value,(e,n)=>(t(),l("div",{key:n,class:"input-error"},w(e),1))),128))])):g("",!0),o("div",N,[(t(!0),l(h,null,f(m.images,e=>(t(),l("div",{class:"w-24 h-24 relative",key:e.id},[e.type==="private"?(t(),d(C(B),{key:0,href:r.route("profile.images.destroy",e.id),as:"button",method:"delete",class:"bg-red-500 text-white px-3 py-1 rounded-full absolute -right-2 -top-2 hover:opacity-80"},{default:a(()=>[p(" x ")]),_:2},1032,["href"])):g("",!0),o("img",{src:e.src,alt:e.type,class:F(["w-full h-full hover:opacity-60 hover:cursor-pointer hover:border-green-500 hover:border-4",{"opacity-60 border-4 border-green-500":e.id===y.value.id}]),onClick:n=>_(e.id)},null,10,O)]))),128)),o("div",{class:"w-24 h-24 bg-gray-200 text-gray-700 hover:cursor-pointer hover:bg-gray-400 text-center leading-[6rem]",onClick:s[0]||(s[0]=e=>r.$refs.chooseFile.click())}," آپلود عکس "),o("input",{type:"file",ref:"chooseFile",onChange:b,class:"hidden"},null,544)])])]),_:1}))}};export{S as default};