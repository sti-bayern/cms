﻿(function(f,d){d.dialog.add("media",function(b){var c=b.lang.media;b=b.lang.common;var e=[[b.notSet,""]].concat(d.media.getTypes().map(function(a){return[c[a],a]}).sort(function(a,b){return a[0]<b[0]?-1:a[0]>b[0]?1:0}));return{title:c.title,resizable:d.DIALOG_RESIZE_BOTH,minWidth:250,minHeight:100,contents:[{id:"info",label:c.info,elements:[{id:"src",type:"text",label:b.url,setup:function(a){this.setValue(a.data.src)},commit:function(a){a.setData("src",this.getValue())},validate:d.dialog.validate.notEmpty(c.validateRequired),
onChange:function(){var a=this.getValue()?d.media.getTypeFromUrl(this.getValue()):"";this.getDialog().getContentElement("info","type").setValue(a)}},{id:"browse",type:"button",label:b.browseServer,hidden:!0},{id:"type",type:"select",label:c.type,items:e,setup:function(a){this.setValue(a.data.type)},commit:function(a){a.setData("type",this.getValue())},validate:d.dialog.validate.notEmpty(c.validateRequired)},{id:"alt",type:"text",label:c.alt,setup:function(a){this.setValue(a.data.alt)},commit:function(a){a.setData("alt",
this.getValue())}},{id:"caption",type:"checkbox",label:c.caption,setup:function(a){this.setValue(a.data.caption)},commit:function(a){a.setData("caption",this.getValue())}},{id:"link",type:"text",label:c.link,setup:function(a){this.setValue(a.data.link)},commit:function(a){a.setData("link",this.getValue())}},{type:"hbox",children:[{id:"width",type:"text",label:b.width,setup:function(a){this.setValue(a.data.width)},commit:function(a){a.setData("width",this.getValue())}},{id:"height",type:"text",label:b.height,
setup:function(a){this.setValue(a.data.height)},commit:function(a){a.setData("height",this.getValue())}}]},{id:"align",type:"radio",label:b.align,items:[[b.alignNone,""],[b.left,"left"],[b.right,"right"]],setup:function(a){this.setValue(a.data.align)},commit:function(a){a.setData("align",this.getValue())}}]}]}})})(document,CKEDITOR);