const y=()=>({shamsiMonthNames:["فروردین","اردیبهشت","خرداد","تیر","مرداد","شهریور","مهر","آبان","آذر","دی","بهمن","اسفند"],shamsiDayNames:["یکشنبه","دوشنبه","سه شنبه","چهارشنبه","پنج شنبه","جمعه","شنبه"]}),p=()=>({shamsiMonthDays:[31,31,31,31,31,31,30,30,30,30,30,{leap:30,notLeap:29}],miladiMonthDays:[31,{leap:29,notLeap:28},31,30,31,30,31,31,30,31,30,31]}),N=(a,e,i,o,s)=>{let n=e,t=i;return o&&(n==1?t!=s[1].leap?t++:(n++,t=1):n==11?t!=s[11]?t++:(n=0,t=1):t!=s[n]?t++:(n++,t=1)),t>=22&&n==2||n>2?a-621:a-622},Y=(a,e)=>{const{shamsiMonthNames:i}=y();let o=a%365,s=0;for(let h=0;o>e[h];h++)o-=e[h],s++;const n=i[s],t=++s;return{shamsiYearRemainer:o,shamsiMonth:n,shamsiMonthNumber:t}},S=(a,e,i)=>{let o=0;if(a)for(let s=0;s<=a-1;s++){if(s===1){e?o+=i[s].leap:o+=i[s].notLeap;continue}o+=i[s]}return o},g=(a=new Date)=>{const e=a.getFullYear(),i=a.getMonth(),o=a.getDate(),s=e%4===0?1:0,{shamsiMonthDays:n,miladiMonthDays:t}=p(),h=(e-1)*365,l=S(i,s,t),m=N(e,i,o,s,t),r=Math.floor((e-1)/4),c=Math.floor((m-1)/4),D=h+l+o+r-226899-c,{shamsiMonth:u,shamsiYearRemainer:M,shamsiMonthNumber:f}=Y(D,n);return{shamsiYear:m,shamsiMonth:u,shamsiMonthNumber:f,shamsiDay:M}};export{y as a,g as u};