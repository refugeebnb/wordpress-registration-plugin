jQuery(document).ready(function($){
	/**
	 * Add Translation Code
	 */
	
	var $langSlug = 'english';
	var $parseText = LangDefaults;
	var $langSelector = $("#top-selector");
	var $langUl = $("#top-selector ul");
	var $langs = $langUl.find("a");
	
	var _lang = $.cookie("lang-selected");
	if(typeof _lang !== "undefined" && _lang !='english')
	{
		if(LangOptions.hasOwnProperty(_lang))
		{
			var lang = LangOptions[_lang];
			$parseText = lang.translations;
			$langSelector.find("button").html(lang.display+' <span class="caret"></span>')
		}
	}
	$langs.on("click",function(){
		var $slug = $(this).attr("data-target");
		if($slug=='english')
		{
			$langSelector.find("button").html('English <span class="caret"></span>');
			$parseText = LangDefaults;
			$.cookie("lang-selected",$slug,{path: '/' , expires: 365*10, });
		}
		else if(LangOptions.hasOwnProperty($slug))
		{
			var lang = LangOptions[$slug];
			$parseText = lang.translations;
			$langSelector.find("button").html(lang.display+' <span class="caret"></span>');
			$.cookie("lang-selected",$slug,{path: '/' , expires: 365*10, });
		}
		parseLangHTML();
	});
	parseLangHTML();
	
	function parseLangHTML()
	{
		var $fragments = $("[data-fragment]");
		for(var y=0;y<$fragments.length;y++)
		{
			var $fragment = $($fragments[y]);
			var x = parseInt($fragment.attr("data-fragment"));
			var tag = $fragment.prop("tagName").toLowerCase();
			var $text = $parseText.length < x || $.trim($parseText[x]) == ""? LangDefaults[x]:$parseText[x];
			if(tag != "input" && tag !="textarea")
			{
				$fragment.html($text);
			}
			else
			{
				$fragment.attr("placeholder",$text);
			}
		}
	}
	
	/**
	 * Add Other Interests Code
	 */
	var $expressForm = $("#other-providers");
	$expressForm.on("submit",function(){
		var data = {action : "RefugeeBnb",type:"express-interest"};
		data = $.extend(data, $expressForm.serializeObject());
		$expressForm.find(".console").html("<div class='alert alert-warning text-center'><span class='icon-clock'></span></div>");
		$.ajax({
			url : RefugeeBnb.ajaxurl,
			data : data,
			type : 'post',
			dataType : 'json',
			success : function(data)
			{
				$expressForm.find(".console").empty();
				if(!data.success)
					renderErrors($expressForm,data.errors,"RefugeeBnb[Others]");
				else
				{
					$expressForm.find(".hint").removeClass("has-error").removeClass("has-success").empty();
					$expressForm.clearForm();
					$expressForm.find(".console").html("<div class='alert alert-success'>"+data.message+"</div>");
				}
				parseLangHTML();
			},
			complete : function(status){}
		});
		return false;
	});
	//
	/**
	 * Add Shelter Code
	 */
	var $shelterInit = $("#shelter-providers-signup");
	$shelterInit.on("submit",function(){
		var data = {action : "RefugeeBnb",type:"shelter-signup"};
		data = $.extend(data, $shelterInit.serializeObject());
		$shelterInit.find(".console").html("<div class='alert alert-warning text-center'><span class='icon-clock'></span></div>");
		$.ajax({
			url : RefugeeBnb.ajaxurl,
			data : data,
			type : 'post',
			dataType : 'json',
			success : function(data)
			{
				$shelterInit.find(".console").empty();
				console.log(data);
				if(!data.success)
					renderErrors($shelterInit,data.errors,"RefugeeBnb[Shelter]");
				else
				{
					$("#logged-in").show();
					$("#public").hide();
					$shelterInit.find(".hint").removeClass("has-error").removeClass("has-success").empty();
					$shelterInit.clearForm();
				}
				parseLangHTML();
			},
			complete : function(status){}
		});
		return false;
	});
	
	/**
	 * Add Shelter Detail Code
	 */
	var $rooms = $("[name='RefugeeBnb[Shelter][rooms]']");
	var $details = $("#room-details");
	$rooms.on("change",function(){
		$details.empty();
		var $template = $("#room-template").clone().removeClass("template");
		var rooms = parseInt($(this).val());
		for(var x=0;x<rooms;x++)
		{
			var $room = $template.clone();
			$room.find(".num").text((x+1));
			var $inputs = $room.find("input");
			$inputs.each(function(){
				var name = $(this).attr("name").replace("[:x]","["+x+"]");
				$(this).attr("name",name);
			});
			$details.append($room);
		}
	});
	
	var $shelterDetails = $("#shelter-providers-details");
	$shelterDetails.on("submit",function(){
		var data = {action : "RefugeeBnb",type:"shelter-detail"};
		data = $.extend(data, $shelterDetails.serializeObject());
		$shelterDetails.find(".console").html("<div class='alert alert-warning text-center'><span class='icon-clock'></span></div>");
		$.ajax({
			url : RefugeeBnb.ajaxurl,
			data : data,
			type : 'post',
			dataType : 'json',
			success : function(data)
			{
				$shelterDetails.find(".console").empty();
				if(!data.success)
				{
					renderErrors($shelterDetails,data.errors,"RefugeeBnb[Shelter]");
					$shelterDetails.find(".console").html("<div class='alert alert-danger'>"+data.message+"</div>");
				}	
				else
				{
					$details.empty();
					$shelterDetails.find(".hint").removeClass("has-error").removeClass("has-success").empty();
					$shelterDetails.clearForm();
					$shelterDetails.find(".console").html("<div class='alert alert-success'>"+data.message+"</div>");
				}
				parseLangHTML();
			},
			complete : function(status){}
		});
		return false;
	});
});