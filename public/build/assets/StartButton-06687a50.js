import{d as l,o as u,c as i,f as p,t as m,u as d,p as x,O as s}from"./app-dd8571fb.js";const g={class:"flex flex-col items-center justify-center px-2 md:px-0 py-2"},h={__name:"StartButton",props:{text:String,game:Object},setup(r){const e=r,a=e.text=="user"?"نوبت شما":"نوبت حریف",n=l(()=>{const t=["green-500","red-500","blue-light"];return t[Math.floor(Math.random()*t.length)]}),c=t=>{if(t=="user")return e.game.category_id==6?s.post(route("multi-player.category",e.game.id)):s.put(route("multi-player.quiz",e.game.id),{color:n.value})};return(t,o)=>(u(),i("div",g,[p("div",{class:x(["bg-blue-light px-2 md:px-4 py-2 rounded-md text-center text-white",{"hover:cursor-pointer":r.text=="user"}]),onClick:o[0]||(o[0]=f=>c(r.text))},m(d(a)),3)]))}};export{h as default};
