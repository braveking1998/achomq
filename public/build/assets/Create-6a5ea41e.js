import{Q as F,d as x,r as T,T as O,o as a,c as l,a as d,u as t,w as c,F as w,Z as E,f as e,t as n,e as i,v as L,s as y,j as g,g as p,l as _,h as k}from"./app-dd8571fb.js";import{_ as Q}from"./AuthWithSidebarLayout-53551b2d.js";import{B as V}from"./Box-53e3f365.js";import{u as Y,a as Z}from"./date-c7da505b.js";import{_ as z}from"./Breadcrumbs-c157ac91.js";import"./AuthenticatedLayout-49277159.js";import"./DropdownLink-4735ad2e.js";import"./_plugin-vue_export-helper-c27b6911.js";const A=e("h1",{class:"text-gray-500 text-center font-bold"},"مشخصات سوال",-1),G={class:"text-gray-800 text-sm flex flex-col gap-2"},H={class:"flex flex-col gap-4 md:px-16"},I={class:"flex justify-between"},J={class:"w-2/5"},K=e("label",{for:"level"},"سطح سوال:",-1),P=["value"],R={class:"w-2/5"},W=e("label",{for:"category"},"دسته بندی سوال:",-1),X=["value"],ee={class:"mt-4"},se=e("label",{class:"block",for:"question"},"متن سوال:",-1),te={key:0,class:"input-error"},re=e("label",{for:"correct"},"پاسخ صحیح",-1),oe={key:0,class:"input-error"},ae=e("label",{for:"answer-one"},"پاسخ اول",-1),le={key:0,class:"input-error"},ne=e("label",{for:"answer-two"},"پاسخ دوم",-1),ie={key:0,class:"input-error"},ue=e("label",{for:"answer-three"},"پاسخ سوم",-1),de={key:0,class:"input-error"},ce={class:"flex flex-col md:flex-row gap-4 mt-4"},pe=e("button",{type:"submit",class:"btn-primary"},"ثبت سوال",-1),ye={__name:"Create",props:{levels:Object,categories:Object},setup(m){const v=m,f=F(),q=x(()=>f.props.auth.user),h=x(()=>f.props.flash.success),u=T(!0),$=b=>{setTimeout(()=>{u.value=!1},b)},D=[{label:"داشبورد",url:route("dashboard")},{label:"سوالات",url:route("questions.index")},{label:"افزودن سوال",url:route("questions.create")}],{shamsiYear:M,shamsiMonth:S,shamsiDay:U}=Y(),{shamsiDayNames:C}=Z(),B=new Date().getDay(),N=`${C[B]} ${U} ${S} ماه ${M}`,s=O({level_id:v.levels[0].id??!1,category_id:v.categories[0].id??!1,question:null,answers:{correct:null,answer_one:null,answer_two:null,answer_three:null}}),j=()=>s.post(route("questions.store"),{onSuccess:()=>{s.reset("question","answers"),u.value=!0,$(2e3)}});return(b,o)=>(a(),l(w,null,[d(t(E),{title:"افزودن سوال"}),d(Q,null,{header:c(()=>[d(z,{breadcrumbs:D})]),aside:c(()=>[d(V,{class:"flex flex-col gap-4 w-full p-6"},{default:c(()=>[A,e("div",G,[e("div",null,"نام طراح: "+n(q.value.name),1),e("div",null,"تاریخ امروز: "+n(N))])]),_:1})]),content:c(()=>[i(e("div",{onClick:o[0]||(o[0]=r=>u.value=!u.value),class:"flash-message"},n(h.value),513),[[L,h.value&&u.value]]),d(V,{class:"p-6"},{default:c(()=>[e("form",{onSubmit:k(j,["prevent"])},[e("div",H,[e("div",I,[e("div",J,[K,i(e("select",{id:"level",class:"input","onUpdate:modelValue":o[1]||(o[1]=r=>t(s).level_id=r)},[(a(!0),l(w,null,g(m.levels,r=>(a(),l("option",{key:r.id,value:r.id},n(r.name),9,P))),128))],512),[[y,t(s).level_id,void 0,{number:!0}]])]),e("div",R,[W,i(e("select",{id:"category",class:"input","onUpdate:modelValue":o[2]||(o[2]=r=>t(s).category_id=r)},[(a(!0),l(w,null,g(m.categories,r=>(a(),l("option",{key:r.id,value:r.id},n(r.name),9,X))),128))],512),[[y,t(s).category_id,void 0,{number:!0}]])])]),e("div",ee,[se,i(e("textarea",{id:"question",placeholder:"متن سوال",class:"input","onUpdate:modelValue":o[3]||(o[3]=r=>t(s).question=r)},null,512),[[p,t(s).question]]),t(s).errors.question?(a(),l("div",te,n(t(s).errors.question),1)):_("",!0)]),e("div",null,[re,i(e("input",{type:"text",id:"correct",placeholder:"پاسخ صحیح",class:"input","onUpdate:modelValue":o[4]||(o[4]=r=>t(s).answers.correct=r)},null,512),[[p,t(s).answers.correct]]),t(s).errors["answers.correct"]?(a(),l("div",oe,n(t(s).errors["answers.correct"]),1)):_("",!0)]),e("div",null,[ae,i(e("input",{type:"text",id:"answer-one",placeholder:"پاسخ اول",class:"input","onUpdate:modelValue":o[5]||(o[5]=r=>t(s).answers.answer_one=r)},null,512),[[p,t(s).answers.answer_one]]),t(s).errors["answers.answer_one"]?(a(),l("div",le,n(t(s).errors["answers.answer_one"]),1)):_("",!0)]),e("div",null,[ne,i(e("input",{type:"text",id:"answer-two",placeholder:"پاسخ دوم",class:"input","onUpdate:modelValue":o[6]||(o[6]=r=>t(s).answers.answer_two=r)},null,512),[[p,t(s).answers.answer_two]]),t(s).errors["answers.answer_two"]?(a(),l("div",ie,n(t(s).errors["answers.answer_two"]),1)):_("",!0)]),e("div",null,[ue,i(e("input",{type:"text",id:"answer-three",placeholder:"پاسخ سوم",class:"input","onUpdate:modelValue":o[7]||(o[7]=r=>t(s).answers.answer_three=r)},null,512),[[p,t(s).answers.answer_three]]),t(s).errors["answers.answer_three"]?(a(),l("div",de,n(t(s).errors["answers.answer_three"]),1)):_("",!0)]),e("div",ce,[pe,e("button",{type:"rest",class:"btn-bordered",onClick:o[8]||(o[8]=k(r=>t(s).reset(),["prevent"]))}," از نو سازی ")])])],32)]),_:1})]),_:1})],64))}};export{ye as default};
