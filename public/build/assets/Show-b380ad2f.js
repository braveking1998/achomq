import{_ as D}from"./AuthWithoutSidebarLayout-3b9d1bd0.js";import{_ as N}from"./Breadcrumbs-c157ac91.js";import{B as $}from"./Box-53e3f365.js";import{o as r,c as i,a,u as c,w as o,F as m,Z as k,f as e,k as h,b as s,t as n,j as B,l as w}from"./app-dd8571fb.js";import{u as S,a as V}from"./date-c7da505b.js";import"./AuthenticatedLayout-49277159.js";import"./DropdownLink-4735ad2e.js";import"./_plugin-vue_export-helper-c27b6911.js";const F={class:"flex gap-4"},j={class:"text-gray-500"},v=e("span",null,"متن سوال: ",-1),C={class:"text-gray-500"},M=e("span",null,"دسته بندی: ",-1),E={class:"text-gray-500"},L=e("span",null,"سطح: ",-1),O=e("span",null,"تاریخ ایجاد: ",-1),T={class:"flex flex-col gap-4"},Y={key:0,class:"pr-4"},R={__name:"Show",props:{question:Object},setup(t){const _=[{label:"داشبورد",url:route("dashboard")},{label:"سوالات",url:route("questions.index")}],u=t,{shamsiYear:f,shamsiMonthNumber:Z,shamsiMonth:p,shamsiDay:g}=S(new Date(u.question.created_at)),{shamsiDayNames:x}=V(),y=new Date(u.question.created_at).getDay(),b=`${x[y]} ${g} ${p} ماه ${f}`;return(d,z)=>(r(),i(m,null,[a(c(k),{title:"مشاهده سوال"}),a(D,null,{header:o(()=>[a(N,{breadcrumbs:_},{"right-side":o(()=>[e("div",F,[a(c(h),{href:d.route("questions.edit",t.question.id),class:"btn-primary bg-green-500"},{default:o(()=>[s("ویرایش سوال")]),_:1},8,["href"]),a(c(h),{href:d.route("questions.destroy",t.question.id),class:"btn-primary bg-red-500",method:"delete",as:"button"},{default:o(()=>[s("حذف سوال")]),_:1},8,["href"])])]),_:1})]),content:o(()=>[a($,{class:"flex flex-col gap-4 p-6"},{default:o(()=>[e("p",j,[v,s(n(t.question.text),1)]),e("p",C,[M,s(n(t.question.category.name),1)]),e("p",E,[L,s(n(t.question.level.name),1)]),e("p",{class:"text-gray-500"},[O,s(n(b))]),e("ul",T,[(r(!0),i(m,null,B(t.question.answers,(l,q)=>(r(),i("li",{key:l.id,class:"text-gray-500"},[e("span",null,"پاسخ "+n(q+1)+": ",1),s(n(l.text)+" ",1),l.is_correct?(r(),i("span",Y,"✔️")):w("",!0)]))),128))])]),_:1})]),_:1})],64))}};export{R as default};