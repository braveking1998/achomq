import{Q as C,d as O,r as T,T as F,o as n,c as a,a as p,u as s,w as c,F as h,Z as E,f as e,t as l,e as d,v as L,s as b,j as x,g as v,l as m,k as y,b as g,i as Q,h as q}from"./app-dd8571fb.js";import{_ as Y}from"./AuthWithSidebarLayout-53551b2d.js";import{B as k}from"./Box-53e3f365.js";import{u as Z,a as z}from"./date-c7da505b.js";import"./AuthenticatedLayout-49277159.js";import"./DropdownLink-4735ad2e.js";import"./_plugin-vue_export-helper-c27b6911.js";const A=e("h1",{class:"text-gray-500 text-center font-bold"},"مشخصات سوال",-1),G={class:"text-gray-800 text-sm flex flex-col gap-2"},H={class:"flex flex-col gap-4 md:px-16"},I={class:"flex justify-between"},J={class:"w-2/5"},K=e("label",{for:"level"},"سطح سوال:",-1),P=["value"],R={class:"w-2/5"},W=e("label",{for:"category"},"دسته بندی سوال:",-1),X=["value"],ee={class:"mt-4"},se=e("label",{class:"block",for:"question"},"متن سوال:",-1),te={key:0,class:"input-error"},re=e("label",{for:"correct"},"پاسخ صحیح",-1),oe={key:0,class:"input-error"},ne=e("label",{for:"answer-one"},"پاسخ اول",-1),ae={key:0,class:"input-error"},le=e("label",{for:"answer-two"},"پاسخ دوم",-1),ie={key:0,class:"input-error"},de=e("label",{for:"answer-three"},"پاسخ سوم",-1),ue={key:0,class:"input-error"},ce={class:"flex flex-col md:flex-row gap-4 mt-4"},me=e("button",{type:"submit",class:"btn-primary bg-green-500 hover:border-green-500 hover:text-green-500"}," تایید سوال ",-1),ye={__name:"Submit",props:{question:Object,next:Object,levels:Object,categories:Object},setup(u){const i=u,V=C(),f=O(()=>V.props.flash.success),w=T(!0),M=_=>{setTimeout(()=>{w.value=!1},_)},{shamsiYear:S,shamsiMonthNumber:we,shamsiMonth:D,shamsiDay:N}=Z(),{shamsiDayNames:U}=z(),$=new Date().getDay(),j=`${U[$]} ${N} ${D} ماه ${S}`,t=F({level_id:i.question.level.id,category_id:i.question.category.id,question:i.question.text,answers:{correct:i.question.answers[0].text,answer_one:i.question.answers[1].text,answer_two:i.question.answers[2].text,answer_three:i.question.answers[3].text}}),B=()=>t.put(route("admin.submit.update",i.question.id),{onSuccess:()=>{w.value=!0,M(2e3)}});return(_,o)=>(n(),a(h,null,[p(s(E),{title:"تایید سوال"}),p(Y,null,{aside:c(()=>[p(k,{class:"flex flex-col gap-4 w-full p-6"},{default:c(()=>[A,e("div",G,[e("div",null,"نام طراح: "+l(u.question.user.name),1),e("div",null,"تاریخ امروز: "+l(j))])]),_:1})]),content:c(()=>[d(e("div",{onClick:o[0]||(o[0]=r=>w.value=!w.value),class:"flash-message"},l(f.value),513),[[L,f.value&&w.value]]),p(k,{class:"p-6"},{default:c(()=>[e("form",{onSubmit:q(B,["prevent"])},[e("div",H,[e("div",I,[e("div",J,[K,d(e("select",{id:"level",class:"input","onUpdate:modelValue":o[1]||(o[1]=r=>s(t).level_id=r)},[(n(!0),a(h,null,x(u.levels,r=>(n(),a("option",{key:r.id,value:r.id},l(r.name),9,P))),128))],512),[[b,s(t).level_id,void 0,{number:!0}]])]),e("div",R,[W,d(e("select",{id:"category",class:"input","onUpdate:modelValue":o[2]||(o[2]=r=>s(t).category_id=r)},[(n(!0),a(h,null,x(u.categories,r=>(n(),a("option",{key:r.id,value:r.id},l(r.name),9,X))),128))],512),[[b,s(t).category_id,void 0,{number:!0}]])])]),e("div",ee,[se,d(e("textarea",{id:"question",placeholder:"متن سوال",class:"input","onUpdate:modelValue":o[3]||(o[3]=r=>s(t).question=r)},null,512),[[v,s(t).question]]),s(t).errors.question?(n(),a("div",te,l(s(t).errors.question),1)):m("",!0)]),e("div",null,[re,d(e("input",{type:"text",id:"correct",placeholder:"پاسخ صحیح",class:"input","onUpdate:modelValue":o[4]||(o[4]=r=>s(t).answers.correct=r)},null,512),[[v,s(t).answers.correct]]),s(t).errors["answers.correct"]?(n(),a("div",oe,l(s(t).errors["answers.correct"]),1)):m("",!0)]),e("div",null,[ne,d(e("input",{type:"text",id:"answer-one",placeholder:"پاسخ اول",class:"input","onUpdate:modelValue":o[5]||(o[5]=r=>s(t).answers.answer_one=r)},null,512),[[v,s(t).answers.answer_one]]),s(t).errors["answers.answer_one"]?(n(),a("div",ae,l(s(t).errors["answers.answer_one"]),1)):m("",!0)]),e("div",null,[le,d(e("input",{type:"text",id:"answer-two",placeholder:"پاسخ دوم",class:"input","onUpdate:modelValue":o[6]||(o[6]=r=>s(t).answers.answer_two=r)},null,512),[[v,s(t).answers.answer_two]]),s(t).errors["answers.answer_two"]?(n(),a("div",ie,l(s(t).errors["answers.answer_two"]),1)):m("",!0)]),e("div",null,[de,d(e("input",{type:"text",id:"answer-three",placeholder:"پاسخ سوم",class:"input","onUpdate:modelValue":o[7]||(o[7]=r=>s(t).answers.answer_three=r)},null,512),[[v,s(t).answers.answer_three]]),s(t).errors["answers.answer_three"]?(n(),a("div",ue,l(s(t).errors["answers.answer_three"]),1)):m("",!0)]),e("div",ce,[me,p(s(y),{href:_.route("admin.submit.destroy",u.question.id),as:"button",method:"delete",class:"btn-primary bg-red-500 hover:border-red-500 hover:text-red-500"},{default:c(()=>[g(" لغو سوال ")]),_:1},8,["href"]),u.next?(n(),Q(s(y),{key:0,href:_.route("admin.submit.edit",u.next.id),class:"btn-primary"},{default:c(()=>[g(" سوال بعدی ")]),_:1},8,["href"])):m("",!0),e("button",{type:"rest",class:"btn-bordered",onClick:o[8]||(o[8]=q(r=>s(t).reset(),["prevent"]))}," از نو سازی ")])])],32)]),_:1})]),_:1})],64))}};export{ye as default};
