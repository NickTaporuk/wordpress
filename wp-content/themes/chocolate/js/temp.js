// JavaScript Document

// menu


$(function () {
	$('.nav li ul').wrap('<div />');
	$('.nav li div').append('<i />');
	$('.nav li ul').css({
		'display': 'block'
	});
});

$(function () {

   var menu_speed_show = 300;
   var menu_show_timeout = 300;

   var menu_timeout_open = false;
   var menu_timeout_close = false;

   $(".nav ul li").each(function () {
      var sub_ul = $(this).children("div");
      
      if (!sub_ul.length)
      {
         $(this).hover(function () {
            if (menu_timeout_open)
               clearTimeout(menu_timeout_open);
         },
         function () {
         });
         return;
      }

     
      var new_left = parseInt( sub_ul.css('left') );
      var init_left = new_left+20;



      if ($.browser.msie)
      {
         sub_ul.css({
            display: 'none'
         });
      }
      else
      {
         sub_ul.css({
            display: 'block',
            opacity: 0,
         });
      }
      
      $(this).hover(function () {
         if (menu_timeout_open)
            clearTimeout(menu_timeout_open);
         
         menu_timeout_open = setTimeout(function () {
            sub_ul.find("div").hide();
            if ($.browser.msie)
            {
               sub_ul.show();
            }
            else
            {
               sub_ul.css({
                  display: 'block',
                  opacity: 0,
                  left: init_left
               }).animate({
                  opacity: 1,
                  left: new_left
               }, {
                  duration: menu_speed_show,
                  queue: false,
                  complete: function () {
                     if ($.browser.msie) this.style.removeAttribute('filter');
                  }
               });
            }
         }, menu_show_timeout);
      },
      function () {
         sub_ul.hide();
      });
   });
   
   $("#nav").mouseout(function () {
      $(".nav div").hide();
   });

});

// end menu