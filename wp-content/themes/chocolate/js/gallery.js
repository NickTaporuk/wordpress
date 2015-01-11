(function(d){function k(a){var b=["Moz","Webkit","O","ms"],c=a.charAt(0).toUpperCase()+a.substr(1);if(a in i.style)return a;for(a=0;a<b.length;++a){var d=b[a]+c;if(d in i.style)return d}}function j(a){"string"===typeof a&&this.parse(a);return this}function p(a,b,c){!0===b?a.queue(c):b?a.queue(b,c):c()}function m(a){var b=[];d.each(a,function(a){a=d.camelCase(a);a=d.transit.propertyMap[a]||a;a=r(a);-1===d.inArray(a,b)&&b.push(a)});return b}function q(a,b,c,e){a=m(a);d.cssEase[c]&&(c=d.cssEase[c]);
var h=""+n(b)+" "+c;0<parseInt(e,10)&&(h+=" "+n(e));var f=[];d.each(a,function(a,b){f.push(b+" "+h)});return f.join(", ")}function f(a,b){b||(d.cssNumber[a]=!0);d.transit.propertyMap[a]=e.transform;d.cssHooks[a]={get:function(b){return(d(b).css("transform")||new j).get(a)},set:function(b,e){var h=d(b).css("transform")||new j;h.setFromString(a,e);d(b).css({transform:h})}}}function r(a){return a.replace(/([A-Z])/g,function(a){return"-"+a.toLowerCase()})}function g(a,b){return"string"===typeof a&&!a.match(/^[\-0-9\.]+$/)?
a:""+a+b}function n(a){d.fx.speeds[a]&&(a=d.fx.speeds[a]);return g(a,"ms")}d.transit={version:"0.1.3",propertyMap:{marginLeft:"margin",marginRight:"margin",marginBottom:"margin",marginTop:"margin",paddingLeft:"padding",paddingRight:"padding",paddingBottom:"padding",paddingTop:"padding"},enabled:!0,useTransitionEnd:!1};var i=document.createElement("div"),e={},s=-1<navigator.userAgent.toLowerCase().indexOf("chrome");e.transition=k("transition");e.transitionDelay=k("transitionDelay");e.transform=k("transform");
e.transformOrigin=k("transformOrigin");i.style[e.transform]="";i.style[e.transform]="rotateY(90deg)";e.transform3d=""!==i.style[e.transform];d.extend(d.support,e);var o=e.transitionEnd={MozTransition:"transitionend",OTransition:"oTransitionEnd",WebkitTransition:"webkitTransitionEnd",msTransition:"MSTransitionEnd"}[e.transition]||null,i=null;d.cssEase={_default:"ease","in":"ease-in",out:"ease-out","in-out":"ease-in-out",snap:"cubic-bezier(0,1,.5,1)"};d.cssHooks.transform={get:function(a){return d(a).data("transform")},
set:function(a,b){var c=b;c instanceof j||(c=new j(c));a.style[e.transform]="WebkitTransform"===e.transform&&!s?c.toString(!0):c.toString();d(a).data("transform",c)}};d.cssHooks.transformOrigin={get:function(a){return a.style[e.transformOrigin]},set:function(a,b){a.style[e.transformOrigin]=b}};f("scale");f("translate");f("rotate");f("rotateX");f("rotateY");f("rotate3d");f("perspective");f("skewX");f("skewY");f("x",!0);f("y",!0);j.prototype={setFromString:function(a,b){var c="string"===typeof b?b.split(","):
b.constructor===Array?b:[b];c.unshift(a);j.prototype.set.apply(this,c)},set:function(a){var b=Array.prototype.slice.apply(arguments,[1]);this.setter[a]?this.setter[a].apply(this,b):this[a]=b.join(",")},get:function(a){return this.getter[a]?this.getter[a].apply(this):this[a]||0},setter:{rotate:function(a){this.rotate=g(a,"deg")},rotateX:function(a){this.rotateX=g(a,"deg")},rotateY:function(a){this.rotateY=g(a,"deg")},scale:function(a,b){void 0===b&&(b=a);this.scale=a+","+b},skewX:function(a){this.skewX=
g(a,"deg")},skewY:function(a){this.skewY=g(a,"deg")},perspective:function(a){this.perspective=g(a,"px")},x:function(a){this.set("translate",a,null)},y:function(a){this.set("translate",null,a)},translate:function(a,b){void 0===this._translateX&&(this._translateX=0);void 0===this._translateY&&(this._translateY=0);null!==a&&(this._translateX=g(a,"px"));null!==b&&(this._translateY=g(b,"px"));this.translate=this._translateX+","+this._translateY}},getter:{x:function(){return this._translateX||0},y:function(){return this._translateY||
0},scale:function(){var a=(this.scale||"1,1").split(",");a[0]&&(a[0]=parseFloat(a[0]));a[1]&&(a[1]=parseFloat(a[1]));return a[0]===a[1]?a[0]:a},rotate3d:function(){for(var a=(this.rotate3d||"0,0,0,0deg").split(","),b=0;3>=b;++b)a[b]&&(a[b]=parseFloat(a[b]));a[3]&&(a[3]=g(a[3],"deg"));return a}},parse:function(a){var b=this;a.replace(/([a-zA-Z0-9]+)\((.*?)\)/g,function(a,d,e){b.setFromString(d,e)})},toString:function(a){var b=[],c;for(c in this)if(this.hasOwnProperty(c)&&(e.transform3d||!("rotateX"===
c||"rotateY"===c||"perspective"===c||"transformOrigin"===c)))"_"!==c[0]&&(a&&"scale"===c?b.push(c+"3d("+this[c]+",1)"):a&&"translate"===c?b.push(c+"3d("+this[c]+",0)"):b.push(c+"("+this[c]+")"));return b.join(" ")}};d.fn.transition=d.fn.transit=function(a,b,c,f){var h=this,g=0,i=!0;"function"===typeof b&&(f=b,b=void 0);"function"===typeof c&&(f=c,c=void 0);"undefined"!==typeof a.easing&&(c=a.easing,delete a.easing);"undefined"!==typeof a.duration&&(b=a.duration,delete a.duration);"undefined"!==typeof a.complete&&
(f=a.complete,delete a.complete);"undefined"!==typeof a.queue&&(i=a.queue,delete a.queue);"undefined"!==typeof a.delay&&(g=a.delay,delete a.delay);"undefined"===typeof b&&(b=d.fx.speeds._default);"undefined"===typeof c&&(c=d.cssEase._default);var b=n(b),j=q(a,b,c,g),l=d.transit.enabled&&e.transition?parseInt(b,10)+parseInt(g,10):0;if(0===l)return p(h,i,function(b){h.css(a);f&&f();b()}),h;var k={},m=function(b){var c=!1,g=function(){c&&h.unbind(o,g);0<l&&h.each(function(){this.style[e.transition]=
k[this]||null});"function"===typeof f&&f.apply(h);"function"===typeof b&&b()};0<l&&o&&d.transit.useTransitionEnd?(c=!0,h.bind(o,g)):window.setTimeout(g,l);h.each(function(){0<l&&(this.style[e.transition]=j);d(this).css(a)})};p(h,i,function(a){var b=0;"MozTransition"===e.transition&&25>b&&(b=25);window.setTimeout(function(){m(a)},b)});return this};d.transit.getTransitionValue=q;if(!jQuery.support.transition) jQuery.fn.transition = jQuery.fn.animate;})(jQuery);


var slideshow_timeout_sec = 5000;

var slider_sequential = false;

var current_big_image = 0;

jQuery(function($){
	
window.images_loaded = function() {
   
	   $("#big-image li img").each(function () {
		  var img = $(this);
		  
		  img.css({
			 width: 'auto',
			 'min-height': '0px',
			 visibility: 'visible'
		  });
		  
		  img.removeAttr("width").removeAttr("height");
		  
		  var img_w = parseInt( img.attr("w") );
		  var img_h = parseInt( img.attr("h") );
		  var current_img_prop = img_w/img_h;
		  
		  $(window).resize(function () {
			 if ( img.parent().index() != current_big_image )
				return;
			 
			 var window_h = $(window).height();
			 var window_w = $(window).width();
			 var h = window_h;
			 var w = window_w;
			 var w_margin = 0;
			 var h_margin = 0;
			 
			 var current_prop = window_w/window_h;
			 
			 
			 if (current_prop > current_img_prop)
			 {
				w = window_w;
				h = w / current_img_prop;  
			 }
			 else
			 {
				h = window_h;
				w = h * current_img_prop;  
			 }
			 w_margin = (window_w - w) / 2;
			 h_margin = (window_h - h) / 2;
			 
			 img.css({
				height: h+"px",
				width:  w+"px",
				marginLeft: w_margin+"px",
				marginTop: h_margin+"px"
			 });
		  });
	   });
	   $(window).trigger('resize');
	}
});

jQuery(function ($) {
   if ( !$("#slider li").length ) return;
   
   var els = $("#big-image li img");
   current_big_image = $("#big-image li").length - 1;
   var current_loaded = 0;
   
   els.each(function () {
      $(this).bind('load', function () {
         //alert("loaded");
         current_loaded++;
         if (current_loaded == els.length)
         {
            $("#loading").hide();
            $("#big-image").css('visibility', 'visible');
            images_loaded();
         }
      });
      $(this).attr("src", $(this).attr("src"));
      if ( $(this)[0].complete )
         $(this).trigger("load");
   });
   
   if ($.browser.msie)
      $("#slider i").remove();
});

jQuery(function ($) {   
   if ( !$("#slider li").length )
   {
      $("#loading").html("Please add some albums and photos to use this functionality.");
      $("#loading").css({
         'text-align': 'center',
         'background': 'none'
      });
      return;
   }
   
   var speed_anim = 1000;
   var slider = $("#slider ul");
   var previous_elements = slider.children();
   var len   = previous_elements.length;
   var one_w = 100;
   var pad   = 10;

   var now_cols = 1;
   var ww = 0;

   do {

      now_cols+=2;

      ww = (one_w*len*now_cols + pad*len*now_cols + 10*len*now_cols);

      $("#slider").css({
         width: ww+"px"
      });
      
      slider.prepend( previous_elements.clone() ).append( previous_elements.clone() );
   
   } while ( ww < $(window).width()*3 );
   
   var nn = 0;
   slider.children().each(function () {
      $(this).attr("n", nn);
      //$(this).append(nn);
      nn++;
   });
   
   //$("#slider_controls ul").append( slider.children().clone() );
   
   var middle_col = (now_cols-1)/2;
   
   var current_n = len*middle_col;
   function get_left(n, check) {
      if (!check)
      {
         /*
         if (n >= len*2)
         {
            set_slider_to(len - (current_n - n));
            n -= len;
         }
         if (n <= len-1)
         {
            set_slider_to(len*2);
            n += len;
         }
         */
         if (n >= len*(middle_col+1))
         {
            set_slider_to(current_n-len);
            n -= len;
         }
         if (n <= (len-1)*(middle_col))
         {
            set_slider_to(current_n+len);
            n += len;
         }
      }
      var v = one_w*n + pad*n + 10 + (n-1)*10;
      v *= -1;
      current_n = n;
      return v;
   }
   
   function set_slider_to(n) {
      var l = get_left(n, true);
      slider.css({
         left: l+"px"
      });
      return l;
   }
   
   set_slider_to(current_n);
   
   var allow_animation = true;
   
   $("#big-image li").css('zIndex', 1);
   $("#big-image li:eq("+(current_big_image)+")").css('zIndex', 10);
   
   slider.children().click(function () {
      var this_n = parseInt( $(this).attr("n") );
      if (!allow_animation)
         return false;
      allow_animation = false;
      
      var new_index_big_image = this_n;
      while (new_index_big_image >= len)
         new_index_big_image -= len;
      new_index_big_image = len - new_index_big_image - 1;
         
      var buf = current_big_image;
      current_big_image = new_index_big_image;
      $(window).trigger("resize");
      current_big_image = buf;
      
      var new_slide = $(this).clone();
      $("#slider_controls ul").prepend(new_slide);   

      $("#big-image li:eq("+(current_big_image)+")").css('zIndex', 10);
      $("#big-image li:eq("+(new_index_big_image)+")").css('zIndex', 5);
      
      var sequential = slider_sequential;
      
      slider.animate({
         left: get_left(this_n)+"px"
      }, {
         duration: speed_anim,
         queue: false,
         step: function (now, fx) {
            if (!sequential)
               return;
            if (fx.prop == "left") {
               var howmuch = fx.start - now;
               var all = fx.start - fx.end;
               var proc = Math.abs(howmuch/all);
               
               howmuch*=1*(102/Math.abs(all));
               
               /*
               $("#slider_controls ul li:eq(1)").css('left', (-1*howmuch)+"px");
               $("#slider_controls ul li:eq(0)").css('left', (all/Math.abs(all)*102-howmuch)+"px");
               */
               
               $("#big-image li:eq("+(current_big_image)+")").css('opacity', 1-proc);
               //$("#big-image li:eq("+(new_index_big_image)+")").css('opacity', proc);
               
               $("#slider_controls ul li:eq(1)").css('opacity', 1-proc);
               //$("#slider_controls ul li:eq(0)").css('opacity', proc);
            }
         },
         complete: function () {
            if (!sequential)
            {
               $("#big-image li:eq("+(current_big_image)+")").animate({
                  opacity: 0
               }, {
                  duration: speed_anim,
                  complete: function () {
                     allow_animation = true;
                     $("#slider_controls ul li:eq(1)").remove();
                     $("#big-image li:eq("+(current_big_image)+")").css('zIndex', 1).css('opacity', 1);
                     $("#big-image li:eq("+(new_index_big_image)+")").css('zIndex', 10);
                     current_big_image = new_index_big_image; 
                     if ($("#control_pause").is(":visible"))
                        restart_slideshow();  
                  }
               });
               $("#slider_controls ul li:eq(1)").animate({
                  opacity: 0
               }, {
                  duration: speed_anim,
                  complete: function () {
                  }
               });
               return;
            }
            allow_animation = true;
            $("#slider_controls ul li:eq(1)").remove();
            $("#big-image li:eq("+(current_big_image)+")").css('zIndex', 1).css('opacity', 1);
            $("#big-image li:eq("+(new_index_big_image)+")").css('zIndex', 10);
            current_big_image = new_index_big_image; 
            if ($("#control_pause").is(":visible"))
               restart_slideshow();  
         }
      });
      
      return false;
   });
   
   $("#control_b, #control_f").click(function () {
      if (slideshow_timeout)
         clearTimeout(slideshow_timeout);
      var p = ( $(this).attr("id") == "control_b" ? -1 : 1 );
      slider.find("li[n="+(current_n+p)+"]").trigger("click");
      if ($("#control_pause").is(":visible"))
         restart_slideshow();  
      return false;
   });
   
   var slideshow_timeout = false;
   function restart_slideshow() {
      if (slideshow_timeout)
         clearTimeout(slideshow_timeout);
      slideshow_timeout = setTimeout(function () {
         $("#control_f").trigger("click");
         restart_slideshow();  
      }, slideshow_timeout_sec);
   }
   
   $("#control_play").click(function () {
      restart_slideshow();   
      $(this).hide();
      $("#control_pause").show();
      return false;
   });

   $("#control_pause").click(function () {
      if (slideshow_timeout)
         clearTimeout(slideshow_timeout);
      $(this).hide();
      $("#control_play").show();
      return false;
   });   
   
   $("#control_play").trigger("click");
   

			/* Mobile Navigation
			----------------------------*/
		if(ResizeTurnOff){
		
		}else{
			function hideHeader() {
				if ($(window).width() < 740) {
					$("#big-image").addClass("no-controls");
					$("#header-mobile").stop().transition({
						"y" : -$("#header-mobile").outerHeight()
					}, 700);
				}
			}
			
			function showHeader() {
				if ($(window).width() < 740) {
					$("#big-image").removeClass("no-controls");
					$("#header-mobile").stop().transition({
						"y" : 0
					}, 700);
				}
			}
			
			$(document).on('touchmove', function(e) { if ($(window).width() < 1000) e.preventDefault(); });
			
			
/*			jQuery.extend(jQuery.browser,
				{SafariMobile : navigator.userAgent.toLowerCase().match(/iP(hone|od)/i) }
			);
			
			if ($.browser.SafariMobile){
			
				$(window).on("orientationchange",  function() {
				
					if(window.orientation == 90 || window.orientation == -90) {
						$("html, body, #big-image").css({
							"min-height" : "280px"
						});
					} else {
						$("html, body, #big-image").css({
							"min-height" : "440px"
						});
					}
					
					if ($("#big-image").hasClass("no-controls")){
						$("#header-mobile").stop().transition({
							"y" : -$("#header-mobile").outerHeight()
						}, 0);
					}
				
					setTimeout(scrollTo, 0, 0, 1);
					$(window).trigger("resize");
				
				}).trigger("orientationchange");
	
				setInterval( function() {$(window).trigger("orientationchange");}, 3000);

			}
*/
			
		
			$(document).wipetouch({
				preventDefault: false,
				wipeLeft: function(result) {
					$("#control_f").trigger("click");
					hideHeader();
				},
				wipeRight: function(result) { 
					$("#control_b").trigger("click");
					hideHeader();
				},
				wipeUp: function(result) {
					hideHeader();
				},
				wipeDown: function(result) { 
					showHeader();
				}
			});
		
			
			$("#big-image").on("click", function(){
				if ($(this).hasClass("no-controls")){
					showHeader();
				} else {
					hideHeader();					
				}
			});
		}
   
});
