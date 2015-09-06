jQuery(document).ready(function($){
	$('body').tooltip({
	    selector: "[data-tip='true'],.tip",
	    placement : !$(this).attr('data-placement')?'auto bottom':$(this).attr('data-placement'),
	    delay: { "show": 0, "hide": 0 },
	    html : true
	});
	
	var $form = $("#app-language-crud");
	var $crud = $("#crud-area");
	var $table = $("#app-language-table");
	var $tbody = $("#app-language-table tbody");
	var $lookup = $("#add-lookup-row");
	var $lookupTable = $("#lookup-table tbody");
	var $translateForm = $("#app-language-translate");
	var $translate = $("#translation-area");
	var $translationLang = $("#translation-lang");
	
	function formClear()
	{
		$form.clearForm();
		$translateForm.clearForm();
		$form.find(".hint").removeClass("has-error").removeClass("has-success").empty();
		var $row = $lookupTable.find("tr").first().clone();
		$lookupTable.empty();
		$row.find("[name='RefugeeBnb[Lang][start][]']").val("");
		$row.find("[name='RefugeeBnb[Lang][end][]']").val("");
		$lookupTable.append($row);
	}
	
	$lookup.on("click",function(){
		var $lastRow = $($lookupTable.find("tr").last().clone());
		$lastRow.find("input").val("");
		$lookupTable.append($lastRow);
	});
	
	if($tbody.find("tr").length == 0)
		$table.hide();
	$form.on("submit",function(){
		var data = {action : "RefugeeBnb",type:"cu-lang"};
		data = $.extend(data, $form.serializeObject());
		$.ajax({
			url : ajaxurl,
			data : data,
			type : 'post',
			dataType : 'json',
			success : function(data)
			{
				if(!data.success)
					renderErrors($form,data.errors,"RefugeeBnb[Lang]");
				else
				{
					$form.find(".hint").removeClass("has-error").removeClass("has-success").empty();
					RefugeeBnb = data.data;
					var content = data.content;
					var context = data.context;
					var $row = $("tr[data-context="+context+"]");
					if($row.length>0)
						$row.replaceWith(content);
					else
						$tbody.append(content);
					$table.slideDown();
					formClear();
				}
			},
			complete : function(status){}
		});
		return false;
	});
	
	$("body").on("click",".edit-lang",function(){
		$form.clearForm();
		var lang = $(this).attr("data-context");
		if(!lang || !RefugeeBnb.hasOwnProperty(lang))
			return false;
		var settings = RefugeeBnb[lang];
		$form.find("[name='RefugeeBnb[Lang][name]']").val(settings.name);
		$form.find("[name='RefugeeBnb[Lang][display]']").val(settings.display);
		var $row = $lookupTable.find("tr").first().clone();
		$lookupTable.empty();
		for(var x=0;x<settings.lookup.length;x++)
		{
			var $newRow = $row.clone();
			var range = settings.lookup[x];
			$newRow.find("[name='RefugeeBnb[Lang][start][]']").val(range[0]);
			$newRow.find("[name='RefugeeBnb[Lang][end][]']").val(range[1]);
			$lookupTable.append($newRow);
		}
	});
	
	$("body").on("click",".delete-lang",function(){
		$form.clearForm();
		var context = $(this).attr("data-context");
		if(!context  || !RefugeeBnb.hasOwnProperty(context))
			return false;
		var data = {
			action : "RefugeeBnb",type:"del-lang",context:context
		};
		$.ajax({
			url : ajaxurl,
			data : data,
			type : 'post',
			dataType : 'json',
			success : function(data)
			{
				if(data.success)
				{
					$form.clearForm();
					SzPostRating = data.data;
					$("tr[data-context="+context+"]").remove();
					if($tbody.find("tr").length == 0)
						$table.slideUp();
				}
			}
		})
	});
	
	$(".clear-lang-form").on("click",formClear);
	
	$("body").on("click",".translate-lang",function(){
		var lang = $(this).attr("data-context");
		if(!lang || !RefugeeBnb.hasOwnProperty(lang))
			return false;
		$translationLang.val(lang);
		lang = RefugeeBnb[lang];
		$(".lang-name").text(lang.name);
		var translations = lang.translations;
		if(lang.translations.length > 0)
		{
			var $fields = $("[name='RefugeeBnb[Lang][Translation][fragment][]']");
			for(var x=0;x<$fields.length;x++)
			{
				var $field = $($fields[x]);
				$field.val(translations.length >x?translations[x]:"");
				if(translations.length <=x)
					break;
			}
		}
		console.log($translate);
		$crud.hide();
		$translate.slideDown();
	});
	
	$translateForm.on("submit",function(){
		var data = {action : "RefugeeBnb",type:"translate-lang"};
		data = $.extend(data, $translateForm.serializeObject());
		$.ajax({
			url : ajaxurl,
			data : data,
			type : 'post',
			dataType : 'json',
			success : function(data)
			{
				if(!data.success)
					renderErrors($translateForm,data.errors,"RefugeeBnb[Lang][Translation]");
				else
				{
					$translateForm.find(".hint").removeClass("has-error").removeClass("has-success").empty();
					RefugeeBnb = data.data;
					formClear();
					$translate.hide();
					$crud.slideDown()
				}
			},
			complete : function(status){}
		});
		return false;
	});
	
	$(".clear-translation").on("click",function(){
		$translate.hide();
		$crud.slideDown();
	});
});