var _typeof="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t};!function(t){"function"==typeof define&&define.amd?define(["jquery"],t):"object"===("undefined"==typeof module?"undefined":_typeof(module))&&module.exports?module.exports=t(require("jquery")):t(jQuery)}(function(t){var e=Array.prototype.slice,r=Array.prototype.splice,n={topSpacing:0,bottomSpacing:0,className:"is-sticky",wrapperClassName:"sticky-wrapper",center:!1,getWidthFrom:"",widthFromWrapper:!0,responsiveWidth:!1,zIndex:"auto"},o=t(window),i=t(document),s=[],c=o.height(),a=function(){for(var e=o.scrollTop(),r=i.height(),n=r-c,a=e>n?n-e:0,p=0,d=s.length;p<d;p++){var u=s[p],l=u.stickyWrapper.offset().top,f=l-u.topSpacing-a;if(u.stickyWrapper.css("height",u.stickyElement.outerHeight()),e<=f)null!==u.currentTop&&(u.stickyElement.css({width:"",position:"",top:"","z-index":""}),u.stickyElement.parent().removeClass(u.className),u.stickyElement.trigger("sticky-end",[u]),u.currentTop=null);else{var h=r-u.stickyElement.outerHeight()-u.topSpacing-u.bottomSpacing-e-a;if(h<0?h+=u.topSpacing:h=u.topSpacing,u.currentTop!==h){var m;u.getWidthFrom?m=t(u.getWidthFrom).width()||null:u.widthFromWrapper&&(m=u.stickyWrapper.width()),null==m&&(m=u.stickyElement.width()),u.stickyElement.css("width",m).css("position","fixed").css("top",h).css("z-index",u.zIndex),u.stickyElement.parent().addClass(u.className),null===u.currentTop?u.stickyElement.trigger("sticky-start",[u]):u.stickyElement.trigger("sticky-update",[u]),u.currentTop===u.topSpacing&&u.currentTop>h||null===u.currentTop&&h<u.topSpacing?u.stickyElement.trigger("sticky-bottom-reached",[u]):null!==u.currentTop&&h===u.topSpacing&&u.currentTop<h&&u.stickyElement.trigger("sticky-bottom-unreached",[u]),u.currentTop=h}var y=u.stickyWrapper.parent();u.stickyElement.offset().top+u.stickyElement.outerHeight()>=y.offset().top+y.outerHeight()&&u.stickyElement.offset().top<=u.topSpacing?u.stickyElement.css("position","absolute").css("top","").css("bottom",0).css("z-index",""):u.stickyElement.css("position","fixed").css("top",h).css("bottom","").css("z-index",u.zIndex)}}},p=function(){c=o.height();for(var e=0,r=s.length;e<r;e++){var n=s[e],i=null;n.getWidthFrom?n.responsiveWidth&&(i=t(n.getWidthFrom).width()):n.widthFromWrapper&&(i=n.stickyWrapper.width()),null!=i&&n.stickyElement.css("width",i)}},d={init:function(e){var r=t.extend({},n,e);return this.each(function(){var e=t(this),o=e.attr("id"),i=o?o+"-"+n.wrapperClassName:n.wrapperClassName,c=t("<div></div>").attr("id",i).addClass(r.wrapperClassName);e.wrapAll(c);var a=e.parent();r.center&&a.css({width:e.outerWidth(),marginLeft:"auto",marginRight:"auto"}),"right"===e.css("float")&&e.css({float:"none"}).parent().css({float:"right"}),r.stickyElement=e,r.stickyWrapper=a,r.currentTop=null,s.push(r),d.setWrapperHeight(this),d.setupChangeListeners(this)})},setWrapperHeight:function(e){var r=t(e),n=r.parent();n&&n.css("height",r.outerHeight())},setupChangeListeners:function(t){if(window.MutationObserver){new window.MutationObserver(function(e){(e[0].addedNodes.length||e[0].removedNodes.length)&&d.setWrapperHeight(t)}).observe(t,{subtree:!0,childList:!0})}else t.addEventListener("DOMNodeInserted",function(){d.setWrapperHeight(t)},!1),t.addEventListener("DOMNodeRemoved",function(){d.setWrapperHeight(t)},!1)},update:a,unstick:function(e){return this.each(function(){for(var e=this,n=t(e),o=-1,i=s.length;i-- >0;)s[i].stickyElement.get(0)===e&&(r.call(s,i,1),o=i);-1!==o&&(n.unwrap(),n.css({width:"",position:"",top:"",float:"","z-index":""}))})}};window.addEventListener?(window.addEventListener("scroll",a,!1),window.addEventListener("resize",p,!1)):window.attachEvent&&(window.attachEvent("onscroll",a),window.attachEvent("onresize",p)),t.fn.sticky=function(r){return d[r]?d[r].apply(this,e.call(arguments,1)):"object"!==(void 0===r?"undefined":_typeof(r))&&r?void t.error("Method "+r+" does not exist on jQuery.sticky"):d.init.apply(this,arguments)},t.fn.unstick=function(r){return d[r]?d[r].apply(this,e.call(arguments,1)):"object"!==(void 0===r?"undefined":_typeof(r))&&r?void t.error("Method "+r+" does not exist on jQuery.sticky"):d.unstick.apply(this,arguments)},t(function(){setTimeout(a,0)})});var UesrCart=function(){function t(t,e,r){var n=new Date;n.setTime(n.getTime()+24*r*60*60*1e3);var o="expires="+n.toUTCString();document.cookie=t+"="+e+";"+o+";path=/"}function e(t){for(var e=t+"=",r=decodeURIComponent(document.cookie),n=r.split(";"),o=0;o<n.length;o++){for(var i=n[o];" "==i.charAt(0);)i=i.substring(1);if(0==i.indexOf(e))return i.substring(e.length,i.length)}return""}function r(){var t=e("cartItems");return t.length>0?JSON.parse(t):[]}function n(e){var n=r(),o=!1;for(var i in n)parseInt(n[i].product_id)===parseInt(e.product_id)&&(o=!0,n[i]=e);o||n.push(e),t("cartItems",JSON.stringify(n),7)}function o(e){var n=r();for(var o in n)if(parseInt(n[o].product_id)===parseInt(e.simpleProductId))!0,n.splice(o,1);else for(var i in n[o].products)parseInt(n[o].products[i])===parseInt(e.simpleProductId)&&(!0,n[o].products.splice(i,1),0===n[o].products.length&&n.splice(o,1));t("cartItems",JSON.stringify(n),7)}return{addToCartInCookie:function(t){n(t)},removeFromCartInCookie:function(t){o(t)}}}();$(document).ready(function(){$("#js-var-userId").val()&&$(".Step-warper").fadeIn(),$(".a--userCartList .m-portlet__head").sticky({topSpacing:$("#m_header").height(),zIndex:99}),$(document).on("click",".btnRemoveOrderproduct",function(){if(mApp.block(".a--userCartList",{overlayColor:"#000000",type:"loader",state:"success",message:"کمی صبر کنید..."}),mApp.block(".CheckoutReviewTotalPriceWarper",{type:"loader",state:"success"}),$("#js-var-userId").val())$.ajax({type:"DELETE",url:$(this).data("action"),statusCode:{200:function(t){location.reload()},403:function(t){window.location.replace("/403")},401:function(t){window.location.replace("/403")},405:function(t){location.reload()},404:function(t){window.location.replace("/404")},422:function(t){},500:function(t){},503:function(t){toastr.error("خطای پایگاه داده!","پیام سیستم")}}});else{var t={simpleProductId:$(this).data("productid")};UesrCart.removeFromCartInCookie(t),location.reload()}})});
