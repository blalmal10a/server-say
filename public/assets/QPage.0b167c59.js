import{c as u,f as s,h as c,C as i,g,d as l,e as r,k as v,E as y}from"./index.45c30311.js";import{u as q,a as C}from"./use-dark.30b26a27.js";var $=u({name:"QCardSection",props:{tag:{type:String,default:"div"},horizontal:Boolean},setup(e,{slots:n}){const t=s(()=>`q-card__section q-card__section--${e.horizontal===!0?"horiz row no-wrap":"vert"}`);return()=>c(e.tag,{class:t.value},i(n.default))}}),b=u({name:"QCard",props:{...q,tag:{type:String,default:"div"},square:Boolean,flat:Boolean,bordered:Boolean},setup(e,{slots:n}){const{proxy:{$q:t}}=g(),a=C(e,t),d=s(()=>"q-card"+(a.value===!0?" q-card--dark q-dark":"")+(e.bordered===!0?" q-card--bordered":"")+(e.square===!0?" q-card--square no-border-radius":"")+(e.flat===!0?" q-card--flat no-shadow":""));return()=>c(e.tag,{class:d.value},i(n.default))}}),k=u({name:"QPage",props:{padding:Boolean,styleFn:Function},setup(e,{slots:n}){const{proxy:{$q:t}}=g(),a=l(v,r);if(a===r)return console.error("QPage needs to be a deep child of QLayout"),r;if(l(y,r)===r)return console.error("QPage needs to be child of QPageContainer"),r;const h=s(()=>{const o=(a.header.space===!0?a.header.size:0)+(a.footer.space===!0?a.footer.size:0);if(typeof e.styleFn=="function"){const p=a.isContainer.value===!0?a.containerHeight.value:t.screen.height;return e.styleFn(o,p)}return{minHeight:a.isContainer.value===!0?a.containerHeight.value-o+"px":t.screen.height===0?o!==0?`calc(100vh - ${o}px)`:"100vh":t.screen.height-o+"px"}}),f=s(()=>`q-page${e.padding===!0?" q-layout-padding":""}`);return()=>c("main",{class:f.value,style:h.value},i(n.default))}});export{k as Q,b as a,$ as b};
