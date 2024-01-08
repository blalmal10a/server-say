import{d as c}from"./date.0d465aef.js";import{F as d,ae as l,ah as u}from"./index.e1718286.js";const e=d({selecteDate:void 0,showAddEditForm:!1,loadingTable:!1,loadingSubmitButton:!1,is_executive:!1,selectedTag:"Fellowship",list:[],users:[],selectedList:[],pagination:{descending:!0,rowsPerPage:15,rowsNumber:0,page:0},columns:p(),form_columns:h(),form:b(),create:F,update:w,getList:g,reset:y,save:f});async function f(a,n){var r,m,s,o;let i=a.params.id;(r=a.query.executive)!=null,e.loadingTable=!0,e.loadingSubmitButton=!0;try{const t=await l.request({url:i!="add"?`faith-promises/${i}`:"faith-promises",method:i!="add"?"patch":"post",data:{faith_promise_data:e.users},params:{...e.pagination}});e.list=t.data.data,e.pagination.rowsNumber=t.data.total,e.showAddEditForm=!1,n.push({name:"faith-promises"})}catch(t){console.error(t.message),u.create((o=(s=(m=t.response)==null?void 0:m.data)==null?void 0:s.message)!=null?o:t==null?void 0:t.message)}e.loadingTable=!1,e.loadingSubmitButton=!1}async function g(a){var n,i,r,m,s,o;e.loadingTable=!0;try{a&&(e.pagination=a.pagination);const t=await l.get("faith-promises",{params:e.pagination});e.list=(i=(n=t.data)==null?void 0:n.data)!=null?i:[],e.pagination.rowsNumber=(r=t.data)==null?void 0:r.total}catch(t){console.error(t.message),u.create((o=(s=(m=t.response)==null?void 0:m.data)==null?void 0:s.message)!=null?o:t==null?void 0:t.message)}e.loadingTable=!1}function p(){return[{label:"Month",name:"month",align:"left",field:a=>c.formatDate(a.month,"MMMM, YYYY")},{label:"Amount",name:"amount",align:"left",field:a=>a.amount},{name:"actions",label:""}]}function h(){return[{label:"name",name:"name",align:"left",field:a=>{var n,i;return(i=a.name)!=null?i:(n=a.user)==null?void 0:n.name}},{label:"Amount",name:"amount"}]}function b(){return{id:null,name:"",phone:"",corp:null}}function y(){e.form={id:null,name:"",phone:"",corp:null}}async function F(a){var n,i,r,m,s;try{const o=await l.get(`faith-promises/create?executive=${(n=a.query.executive)!=null?n:0}`);e.users=(i=o.data)!=null?i:[],e.is_executive=!!a.query.executive}catch(o){console.error(o.message),u.create((s=(m=(r=o.response)==null?void 0:r.data)==null?void 0:m.message)!=null?s:o==null?void 0:o.message)}}async function w(a){var n,i,r,m;try{const s=await l.get(`faith-promises/${a}/edit`);e.users=(n=s.data)!=null?n:[]}catch(s){console.error(s.message),u.create((m=(r=(i=s.response)==null?void 0:i.data)==null?void 0:r.message)!=null?m:s==null?void 0:s.message)}}export{e as f};