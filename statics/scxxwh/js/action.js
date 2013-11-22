function nav_side(obj){
	var obj = $("#" + obj);
	var li = obj.find("li");
	li.each(function(){
		$(this).find("span").click(function(){
			if($(this).parent().attr("class") == "expand"){
				$(this).parent().attr({"class":"shrink"});
				$(this).parent().siblings().attr({"class":"shrink"});
			}
			else{
				$(this).parent().attr({"class":"expand"});
				$(this).parent().siblings().attr({"class":"shrink"});
			}
		})
	});
}
	function slide_player(id){
		var index = 1;
		var O_slide = $("#" + id);
		var O_list = O_slide.find(".slide-photo");
		var O_trigger = O_slide.find(".slide-triggers");
		var len = O_list.find("img").length;
		var html = '';
		for(var i = 1; i <= len; i++){
			if(i == 1){
				html += '<li class="current"></li>';
			}
			else{
				html += '<li></li>';
			}
		}
		O_trigger.html(html);
		var loopTime = setInterval(function(){	//循环切换
				slidePlayer(index);
				index++;
				if(index == len){
					index = 0;
				}
			},4000);
			
		O_trigger.find("li").mouseover(function(){	//鼠标事件
			index = O_trigger.find("li").index(this);
			slidePlayer(index);
		});
		O_trigger.hover(function(){
			if(loopTime){
				clearInterval(loopTime);
			}},
			function(){
				loopTime = setInterval(function(){
					slidePlayer(index);
					index++;
					if(index == len){
						index = 0;
					}},4000);
		});
			
		function slidePlayer(index){	//定义幻灯播放效果
			O_list.find("li")
			.eq(index).fadeIn(300)
			.siblings().fadeOut(300);
			O_trigger.find("li")
			.eq(index).addClass("current")
			.siblings().removeClass("current");
		}
	}