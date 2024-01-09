import{Q as g,b as i,a as v}from"./QPage.0b167c59.js";import{Q as c}from"./QInput.62f11e41.js";import{ac as w,r as p,L as y,M as Q,N as o,af as l,O as a,R as x,ae as m,W as V}from"./index.45c30311.js";import{Q as b,k}from"./QCardActions.dfb9c5e8.js";import{u as q}from"./use-quasar.5a736d3d.js";import"./use-dark.30b26a27.js";const B={style:{"min-width":"min(500px, 100vw)"},class:"q-pa-md"},C=l("h3",{class:"q-ma-none text-center"},"LOGIN",-1),N={class:"row q-col-gutter-md"},P={class:"col-12"},I={class:"col-12"},L={class:"full-width q-px-sm"},F={__name:"LoginPage",setup(S){const f=q(),h=w(),u=p(!1),n=p({phone:"",password:""});async function _(){var r,s,t,d;try{u.value=!0;const e=await m.post("/auth/login",n.value);V.user=e.data.user,localStorage.setItem("token",(r=e.data)==null?void 0:r.token),m.defaults.headers.Authorization=`Bearer ${e.data.token}`,h.push({name:"home"}),u.value=!1}catch(e){u.value=!1,f.notify((d=(t=(s=e.response)==null?void 0:s.data)==null?void 0:t.message)!=null?d:e==null?void 0:e.message),console.log("error: ",e.message)}}return(r,s)=>(y(),Q(g,{class:"row justify-center",style:{"padding-top":"10vh"}},{default:o(()=>[l("div",B,[a(v,{class:"q-pa-lg"},{default:o(()=>[a(b,{onSubmit:_},{default:o(()=>[a(i,null,{default:o(()=>[C]),_:1}),a(i,null,{default:o(()=>[l("div",N,[l("div",P,[a(c,{autofocus:"",outlined:"",modelValue:n.value.phone,"onUpdate:modelValue":s[0]||(s[0]=t=>n.value.phone=t),type:"text",label:"Phone"},null,8,["modelValue"])]),l("div",I,[a(c,{outlined:"",modelValue:n.value.password,"onUpdate:modelValue":s[1]||(s[1]=t=>n.value.password=t),type:"password",label:"Password"},null,8,["modelValue"])])])]),_:1}),a(k,null,{default:o(()=>[l("div",L,[a(x,{loading:u.value,type:"submit",style:{height:"50px"},class:"full-width",color:"primary",label:"login"},null,8,["loading"])])]),_:1})]),_:1})]),_:1})])]),_:1}))}};export{F as default};
