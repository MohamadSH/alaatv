function _typeof(e){return(_typeof="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}function initCertificatesItemsHeight(){var e=$(".certificates-col").height()/2-$(".certificates-items").height()/2;$(".certificates-items").css({position:"absolute",top:e+"px"})}!function(e){e.fn.OwlCarouselType2=function(t){return e.fn.OwlCarouselType2.owlCarouselOptions=e.extend(!0,{},e.fn.OwlCarouselType2.owlCarouseldefaultOptions,t),this.each(function(){var t=e(this);e.fn.OwlCarouselType2.carouselElement=t;var i=t.find(".carousel").length;t.find(".a--owl-carousel-type-2").owlCarousel(e.fn.OwlCarouselType2.owlCarouselOptions.OwlCarousel),e.fn.OwlCarouselType2.showAlaaOwlCarouselItemDetail(),t.find(".carousel").attr("data-owlcarousel-type-2-id",t.attr("id")),t.find(".btn-viewGrid").attr("data-owlcarousel-type-2-id",t.attr("id")),t.find(".btn-viewOwlCarousel").attr("data-owlcarousel-type-2-id",t.attr("id")).fadeOut(0),t.find(".a--owl-carousel-type-2-hide-detailes").attr("data-owlcarousel-type-2-id",t.attr("id")),t.find(".a--owl-carousel-type-2-show-detailes").attr("data-owlcarousel-type-2-id",t.attr("id")),e(t).on("click",".carousel",function(){var t=e("#"+e(this).attr("data-owlcarousel-type-2-id")),i=e(this).data("position");t.find(".a--owl-carousel-type-2").trigger("to.owl.carousel",i)}),e(t).on("click",".btn-viewGrid",function(t){var i=e("#"+e(this).attr("data-owlcarousel-type-2-id"));t.preventDefault(),e.fn.OwlCarouselType2.switchToGridView(i),e([document.documentElement,document.body]).animate({scrollTop:i.offset().top-e("#m_header").height()},300)}),e(t).on("click",".btn-viewOwlCarousel",function(t){var i=e("#"+e(this).attr("data-owlcarousel-type-2-id"));t.preventDefault(),e.fn.OwlCarouselType2.getGridViewWarper(i).html(""),i.find(".btn-viewGrid").fadeIn(0),i.find(".btn-viewOwlCarousel").fadeOut(0),i.find(".m-portlet.a--owl-carousel-type-2-slide-detailes").css({display:"block",position:"relative",width:"auto",top:"0"}),i.find(".subCategoryWarper").fadeOut(0),i.find(".a--owl-carousel-type-2-slide-detailes").slideUp(0),i.find(".detailesWarperPointerStyle").html(""),i.find(".a--owl-carousel-type-2").owlCarousel(e.fn.OwlCarouselType2.owlCarouselOptions.OwlCarousel),e.fn.OwlCarouselType2.getGridViewWarper(i).fadeOut(0),i.find(".a--owl-carousel-type-2").fadeIn(),e.fn.OwlCarouselType2.showAlaaOwlCarouselItemDetail(),e([document.documentElement,document.body]).animate({scrollTop:i.offset().top-e("#m_header").height()},300)}),e(t).on("click",".a--owl-carousel-type-2-hide-detailes",function(){var t=e("#"+e(this).attr("data-owlcarousel-type-2-id"));t.find(".a--owl-carousel-type-2-slide-detailes").slideUp(),t.find(".subCategoryWarper").fadeOut(),e.fn.OwlCarouselType2.getGridViewWarper(t).find(" > div").css({"margin-bottom":"0px"})}),e(t).on("click",".a--owl-carousel-type-2-gridViewWarper .a--owl-carousel-type-2-show-detailes",function(){var t=e("#"+e(this).attr("data-owlcarousel-type-2-id"));e.fn.OwlCarouselType2.getGridViewWarper(t).find(" > div").css({"margin-bottom":"0px"});var i=e(this).parent("#"+t.attr("id")+" .m-widget_head-owlcarousel-item.carousel").data("position"),o="a--owl-carousel-type-2-slide-iteDetail-"+i;e.when(t.find(".subCategoryWarper").fadeOut(0)).done(function(){var a=t.find(".a--owl-carousel-type-2-slide-detailes"),r=t.find("."+o);e.when(a.slideUp(0)).done(function(){r.length>0&&(a.fadeIn(),r.slideDown());var o=t.find(".m-portlet.a--owl-carousel-type-2-slide-detailes"),l=e.fn.OwlCarouselType2.getGridViewWarper(t).find('.carousel[data-position="'+i+'"]').parent();l.css({"margin-bottom":parseInt(o.outerHeight())+"px"});var s=parseInt(l.outerHeight())+parseInt(l.position().top),n=parseInt(l.position().left)+parseInt(l.outerWidth())/2-5;o.css({display:"block",position:"absolute",width:"100%","z-index":"1",top:s+"px"}),0===t.find(".detailesWarperPointerStyle").length&&o.append('<div class="detailesWarperPointerStyle"></div>'),t.find(".detailesWarperPointerStyle").html("<style>.a--owl-carousel-type-2-slide-detailes::before { right: auto; left: "+n+"px; }</style>")})})}),i<e.fn.OwlCarouselType2.owlCarouselOptions.childCountHideOwlCarousel?(e.fn.OwlCarouselType2.switchToGridView(t),t.find(".btn-viewOwlCarousel").fadeOut()):"grid"===e.fn.OwlCarouselType2.owlCarouselOptions.defaultView&&e.fn.OwlCarouselType2.switchToGridView(t)})},e.fn.OwlCarouselType2.switchToGridView=function(t){e.fn.OwlCarouselType2.getGridViewWarper(t).fadeIn(),0===e.fn.OwlCarouselType2.getGridViewWarper(t).length&&t.find(".a--owl-carousel-type-2").after('<div class="m-widget_head-owlcarousel-items a--owl-carousel-type-2 owl-carousel row a--owl-carousel-type-2-gridViewWarper"></div>'),e.fn.OwlCarouselType2.getGridViewWarper(t).fadeOut(0),t.find(".subCategoryWarper").fadeOut(0),t.find(".a--owl-carousel-type-2-slide-detailes").slideUp(0),t.find(".btn-viewGrid").css("cssText","display: none !important;"),t.find(".btn-viewOwlCarousel").fadeIn(0),e.fn.OwlCarouselType2.getGridViewWarper(t).html(""),t.find(".a--owl-carousel-type-2").owlCarousel("destroy"),t.find(".carousel").each(function(){e.fn.OwlCarouselType2.getGridViewWarper(t).append('<div class="'+e.fn.OwlCarouselType2.owlCarouselOptions.grid.columnClass+'">'+e(this)[0].outerHTML+"</div>")}),t.find(".a--owl-carousel-type-2").fadeOut(),e.fn.OwlCarouselType2.getGridViewWarper(t).fadeIn()},e.fn.OwlCarouselType2.getGridViewWarper=function(e){return e.find(".a--owl-carousel-type-2-gridViewWarper")},e.fn.OwlCarouselType2.showAlaaOwlCarouselItemDetail=function(t){var i="";i=void 0!==t?e(t.target).find(".carousel").attr("data-owlcarousel-type-2-id"):this.carouselElement.attr("id");var o=e("#"+i),a="a--owl-carousel-type-2-slide-iteDetail-"+o.find(".a--owl-carousel-type-2 .owl-item.active.center .carousel").data("position");o.find(".subCategoryWarper").fadeOut();var r=o.find(".a--owl-carousel-type-2-slide-detailes"),l=o.find("."+a);r.slideUp(),l.length>0&&(r.fadeIn(),l.slideDown(),e([document.documentElement,document.body]).animate({scrollTop:r.offset().top},300))},e.fn.OwlCarouselType2.owlCarouseldefaultOptions={OwlCarousel:{stagePadding:0,center:!0,rtl:!0,loop:!0,nav:!0,margin:10,responsive:{0:{items:1},400:{items:2},600:{items:3},800:{items:4},1000:{items:5}},onTranslated:e.fn.OwlCarouselType2.showAlaaOwlCarouselItemDetail},grid:{columnClass:"col-12 col-sm-6 col-md-3"},defaultView:"OwlCarousel",childCountHideOwlCarousel:5},e.fn.OwlCarouselType2.owlCarouselOptions=null,e.fn.OwlCarouselType2.carouselElement=null}(jQuery),function(e){"function"==typeof define&&define.amd?define(["jquery"],e):"object"===("undefined"==typeof module?"undefined":_typeof(module))&&module.exports?module.exports=e(require("jquery")):e(jQuery)}(function(e){var t=Array.prototype.slice,i=Array.prototype.splice,o={topSpacing:0,bottomSpacing:0,className:"is-sticky",wrapperClassName:"sticky-wrapper",center:!1,container:"",hidePosition:{element:"",topSpace:0},getWidthFrom:"",widthFromWrapper:!0,responsiveWidth:!1,zIndex:"auto"},a=e(window),r=e(document),l=[],s=a.height(),n=function(){for(var t=a.scrollTop(),i=r.height(),o=i-s,n=t>o?o-t:0,d=0,p=l.length;d<p;d++){var c=l[d],u=c.stickyWrapper.offset().top-c.topSpacing-n,f=!1,w=!1;if(""!==c.container&&e(c.container).length>0)f=e(c.container).offset().top+e(c.container).height()-2*c.stickyWrapper.height();if(c.stickyWrapper.css("height",c.stickyElement.outerHeight()),""!==c.hidePosition.element&&e(c.hidePosition.element).length>0)w=e(c.hidePosition.element).offset().top-c.hidePosition.topSpace;if(t<=u)null!==c.currentTop&&(c.stickyElement.css({width:"",position:"",top:"","z-index":""}),c.stickyElement.parent().removeClass(c.className),c.stickyElement.trigger("sticky-end",[c]),c.currentTop=null);else{var y,h=i-c.stickyElement.outerHeight()-c.topSpacing-c.bottomSpacing-t-n;if(h<0?h+=c.topSpacing:h=c.topSpacing,c.currentTop!==h)c.getWidthFrom?y=e(c.getWidthFrom).width()||null:c.widthFromWrapper&&(y=c.stickyWrapper.width()),null==y&&(y=c.stickyElement.width()),c.stickyElement.css("width",y).css("position","fixed").css("top",h).css("z-index",c.zIndex),c.stickyElement.parent().addClass(c.className),null===c.currentTop?c.stickyElement.trigger("sticky-start",[c]):c.stickyElement.trigger("sticky-update",[c]),c.currentTop===c.topSpacing&&c.currentTop>h||null===c.currentTop&&h<c.topSpacing?c.stickyElement.trigger("sticky-bottom-reached",[c]):null!==c.currentTop&&h===c.topSpacing&&c.currentTop<h&&c.stickyElement.trigger("sticky-bottom-unreached",[c]),c.currentTop=h;var m=c.stickyWrapper.parent();c.stickyElement.offset().top+c.stickyElement.outerHeight()>=m.offset().top+m.outerHeight()&&c.stickyElement.offset().top<=c.topSpacing||!1!==f&&t>f||!1!==w&&t>=w?c.stickyElement.css("position","absolute").css("top","").css("bottom",0).css("z-index",""):c.stickyElement.css("position","fixed").css("top",h).css("bottom","").css("z-index",c.zIndex)}}},d=function(){s=a.height();for(var t=0,i=l.length;t<i;t++){var o=l[t],r=null;o.getWidthFrom?o.responsiveWidth&&(r=e(o.getWidthFrom).width()):o.widthFromWrapper&&(r=o.stickyWrapper.width()),null!=r&&o.stickyElement.css("width",r)}},p={init:function(t){var i=e.extend({},o,t);return i,this.each(function(){var t=e(this),a=t.attr("id"),r=a?a+"-"+o.wrapperClassName:o.wrapperClassName,s=e("<div></div>").attr("id",r).addClass(i.wrapperClassName);t.wrapAll(s);var n=t.parent();i.center&&n.css({width:t.outerWidth(),marginLeft:"auto",marginRight:"auto"}),"right"===t.css("float")&&t.css({float:"none"}).parent().css({float:"right"}),i.stickyElement=t,i.stickyWrapper=n,i.currentTop=null,l.push(i),p.setWrapperHeight(this),p.setupChangeListeners(this)})},setWrapperHeight:function(t){var i=e(t),o=i.parent();o&&o.css("height",i.outerHeight())},setupChangeListeners:function(e){window.MutationObserver?new window.MutationObserver(function(t){(t[0].addedNodes.length||t[0].removedNodes.length)&&p.setWrapperHeight(e)}).observe(e,{subtree:!0,childList:!0}):(e.addEventListener("DOMNodeInserted",function(){p.setWrapperHeight(e)},!1),e.addEventListener("DOMNodeRemoved",function(){p.setWrapperHeight(e)},!1))},update:n,unstick:function(t){return this.each(function(){for(var t=e(this),o=-1,a=l.length;a-- >0;)l[a].stickyElement.get(0)===this&&(i.call(l,a,1),o=a);-1!==o&&(t.unwrap(),t.css({width:"",position:"",top:"",float:"","z-index":""}))})}};window.addEventListener?(window.addEventListener("scroll",n,!1),window.addEventListener("resize",d,!1)):window.attachEvent&&(window.attachEvent("onscroll",n),window.attachEvent("onresize",d)),e.fn.sticky=function(i){return p[i]?p[i].apply(this,t.call(arguments,1)):"object"!==_typeof(i)&&i?void e.error("Method "+i+" does not exist on jQuery.sticky"):p.init.apply(this,arguments)},e.fn.unstick=function(i){return p[i]?p[i].apply(this,t.call(arguments,1)):"object"!==_typeof(i)&&i?void e.error("Method "+i+" does not exist on jQuery.sticky"):p.unstick.apply(this,arguments)},e(function(){setTimeout(n,0)})}),$(".alaaAlert").fadeOut(0),$(".hightschoolAlert").fadeOut(0),$(document).on("click",".certificatesLogo",function(){var e=$(this).data("name");console.log(e),"alaa"===e?($(".hightschoolAlert").fadeOut(0),$(".alaaAlert").slideDown()):"sharif-school"===e?($(".alaaAlert").fadeOut(0),$(".hightschoolAlert").slideDown()):($(".alaaAlert").fadeOut(0),$(".hightschoolAlert").fadeOut(0))}),$(window).resize(function(){initCertificatesItemsHeight()}),$(document).ready(function(){initCertificatesItemsHeight()});
