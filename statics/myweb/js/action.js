jQuery.extend({
	//选项卡
	tab:function(id){
		var O_tab = $("#" + id);
		var O_holder = O_tab.find(".tab-holder");
		var O_panel = O_tab.find(".tab-panel");
		O_holder.find("li").each(function(index){
			$(this).mouseover(function(){
				$(this)
					.addClass("current")
					.siblings().removeClass("current");
				O_panel.children("div").eq(index).siblings().hide();
				O_panel.children("div").eq(index).show();
			});
		});
	},
	scroll_left:function(srcoll_id,scroll_begin_id,scroll_end_id){
		var speed = 10;
		var O_scroll_begin = document.getElementById(scroll_begin_id);
		var O_scroll_end = document.getElementById(scroll_end_id);
		var O_scroll_div = document.getElementById(srcoll_id);
		O_scroll_end.innerHTML = O_scroll_begin.innerHTML;
			function Marquee(){
				if(O_scroll_end.offsetWidth - O_scroll_div.scrollLeft <= 0){
					O_scroll_div.scrollLeft -= O_scroll_begin.offsetWidth;
				}
				else{
					O_scroll_div.scrollLeft++
				}
			}
		var MyMar = setInterval(Marquee,speed);
		O_scroll_div.onmouseover = function(){clearInterval(MyMar);}
		O_scroll_div.onmouseout = function(){MyMar = setInterval(Marquee,speed);}
	},
	//带按钮的翻动
	u_btn_roll:function(id,t,sec,s){
		var scroll_section = $("#" + sec);
		var scroll_obj = $("#" + id);
		var btn_prev = scroll_section.find(".prev");
		var btn_next = scroll_section.find(".next");
		var num_this = scroll_section.find(".num-this");
		var num_total = scroll_section.find(".num-total");
		var i = 1;
		var scroll_width = scroll_obj.find("li").outerWidth(true);
		var n = scroll_obj.find("li").length;
		num_total.html(n);
		num_this.html(i);
		scroll_obj.width(scroll_width * n);
		btn_next.click(function(){
			scroll_obj.stop(true,true);
			marquee();
		});

		btn_prev.click(function(){
			i--;
			if(i < 1){i = n;}
			num_this.html(i);
			scroll_obj.stop(true,true);
			scroll_obj.find("li:last").prependTo(scroll_obj);
			scroll_obj.css({marginLeft: -scroll_width});
			scroll_obj.animate({marginLeft: 0},1000);
		});
		function marquee(){
			i++;
			if(i > n){i = 1;}
			num_this.html(i);
			scroll_obj.animate({
				marginLeft: -scroll_width},1000,function(){
				$(this).css({marginLeft:"0px"}).find("li:first").appendTo(this);
			});
		}
		if(!s){
			var mar = setInterval(marquee, t);
		}
		scroll_section.hover(function(){
			if(mar){clearInterval(mar);}},
			function(){
				if(!s){
					clearInterval(mar);
					mar = setInterval(marquee, t);
				}
		});

	},
	//不带按钮的翻动
	u_roll:function(id,t){
		var O_obj = $("#" + id);
		function marquee(){
			var linehieght = O_obj.find("li").outerHeight(true);
			O_obj.animate({
				marginTop: -linehieght},1000,function(){
				$(this).css({marginTop:"0px"}).find("li:first").appendTo(this);
			});
		}
		if(O_obj.find("li").length > 1){
			var mar = setInterval(marquee, t);
		}
		O_obj.hover(function(){
			if(mar){
				clearInterval(mar);
			}},
			function(){
				clearInterval(mar);
				mar = setInterval(marquee, t);
		});
	},
	//不带按钮的翻动
	l_roll:function(id,time){
		var O_obj = $("#" + id);
		var linewidth = O_obj.find("li").outerWidth(true);
		var speed = time *1000;
		var l = O_obj.find("li").length;
		O_obj.width(linewidth * l);
		function marquee(){
			O_obj.animate({
				marginLeft: -linewidth},1000,function(){
				$(this).css({marginLeft:"0px"}).find("li:first").appendTo(this);
			});
		}
		if(l > 3){
			var mar = setInterval(marquee, speed);
		}
		O_obj.hover(function(){
			if(mar){
				clearInterval(mar);
			}},
			function(){
				clearInterval(mar);
				mar = setInterval(marquee, speed);
		});
	},
	//幻灯
	slide_player:function(slide_id,t){
		var n = 0;
		var O_slide = $("#" + slide_id);
		var O_list = O_slide.find(".slide-photo");
		var O_title = O_slide.find(".slide-info");
		var O_trigger = O_slide.find(".slide-triggers");
		var btn_p = O_slide.find(".prev");
		var btn_n = O_slide.find(".next");
		var l = O_list.find("img").length;
		var html = '';
		for(var i = 1; i <= l; i++){
			if(i == 1){
				html += '<i class="current"></i>';
			}
			else{
				html += '<i></i>';
			}
		}
		O_trigger.html(html);	//渲染数字触发器
		
		O_slide.hover(function(){
			btn_p.show();
			btn_n.show();
			clearInterval(loopTime);
			},
			function(){
				btn_p.hide();
				btn_n.hide();
				loopTime = setInterval(function(){
					slidePlayer(n);
					n++;
					if(n == l){
						n = 0;
					}},t);
		});
		btn_p.click(function(){
			n--;
			if(n < 0){n = l - 1;}
			slidePlayer(n);
		});
		btn_n.click(function(){
			n++;
			if(n == l){n = 0;}		
			slidePlayer(n);
		});
		var loopTime = setInterval(function(){	//循环切换
			slidePlayer(n);
			n++;
			if(n == l){
				n = 0;
			}
		},t);

		O_trigger.find("i").click(function(){	//鼠标事件
			index = O_trigger.find("i").index(this);
			slidePlayer(n);
		});
		function slidePlayer(n){	//定义幻灯播放效果
			O_list.find("li")
			.eq(n).show()
			.siblings().hide();
			O_title.find("li")
			.eq(n).show()
			.siblings().hide();
			O_trigger.find("i")
			.eq(n).addClass("current")
			.siblings().removeClass("current");
		}
	},
	trigger_tab:function(obj){
		var obj = $("#" + obj);
		var panel = obj.find(".trigger-panel");
		var trigger = obj.find(".wt");
		var prev = obj.find(".prev");
		var next = obj.find(".next");
		var i = 0;
		var index = 1;
		var n = panel.children("div").length;
		/*var columnar = obj.find(".vote-columnar");
		columnar.each(function(t){
			var p = $(this).siblings(".vote-columnar").find("span").html();
			$(this).find("i").css("height",p);
		})*/
		var trigger_html = "";
		for (s = 1; s <= n; s++){
			if(s == 1){
				trigger_html += "<i class='current'></i>";
			}
			else{
				trigger_html += "<i></i>";
			}
		}
		trigger.html(trigger_html);
		obj.find(".trigger").width(trigger.outerWidth(true) + prev.outerWidth(true) + next.outerWidth(true));
		var looptrigger = setInterval(player,6000);
		obj.hover(function(){
			if(looptrigger){
				clearInterval(loopTime);
			}},
			function(){
				looptrigger = setInterval(player,6000);
		});

		next.click(function(){
			player();
		})
		prev.click(function(){
			i--;
			if(i < 0){i = n-1;}
			player_right(i);

		})
		function player(){
			i++;
			if(i == n){i = 0;}
			player_left(i);
		}
		function player_left(i){
			panel.children("div").eq(i).show()
			.siblings("div").hide();
			trigger.find("i").eq(i).addClass("current")
			.siblings("i").removeClass("current");
		}
		function player_right(i){
			panel.children("div").eq(i).show()
			.siblings("div").hide();
			trigger.find("i").eq(i).addClass("current")
			.siblings("i").removeClass("current");
		}
	}