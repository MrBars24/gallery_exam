(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([[3],{"379b":function(t,a,e){"use strict";e.r(a);var i=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",[e("q-btn",{staticClass:"q-mt-md q-ml-md q-mb-md",attrs:{label:"Back",color:"blue"},on:{click:function(a){return t.$router.go(-1)}}}),e("q-list",{attrs:{bordered:""}},t._l(t.albums,(function(a){return e("q-item",{directives:[{name:"ripple",rawName:"v-ripple"}],key:a.id,staticClass:"q-my-sm",attrs:{to:{name:"photo",params:{album_id:a.id}},clickable:""}},[e("q-item-section",{attrs:{avatar:""}},[e("q-avatar",{attrs:{color:"primary","text-color":"white"}},[t._v("\n          "+t._s(a.photo_count)+"\n        ")])],1),e("q-item-section",[e("q-item-label",[t._v(t._s(a.title))])],1)],1)})),1)],1)},o=[],r=e("758b");const s=[];var n={name:"PageAlbum",data(){return{albums:s}},created(){this.loadData()},methods:{loadData(){const t=this.$route.params.person_id;r["a"].get(`/api/user/${t}/albums`).then((t=>{this.albums=t.data})).catch((()=>{this.$q.notify({color:"negative",position:"top",message:"Loading failed",icon:"report_problem"})}))}}},l=n,c=e("2877"),m=e("9c40"),u=e("1c1c"),p=e("66e5"),d=e("4074"),b=e("cb32"),v=e("0170"),h=e("714f"),q=e("eebe"),_=e.n(q),f=Object(c["a"])(l,i,o,!1,null,null,null);a["default"]=f.exports;_()(f,"components",{QBtn:m["a"],QList:u["a"],QItem:p["a"],QItemSection:d["a"],QAvatar:b["a"],QItemLabel:v["a"]}),_()(f,"directives",{Ripple:h["a"]})}}]);