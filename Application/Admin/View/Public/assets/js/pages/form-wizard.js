function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

$(document).ready(function(){
	
	$('#ccnumber-w1').mask("9999 9999 9999 9999");
	
	/* ---------- Wizard ---------- */
	$('#email-w1').keyup(function(){
		
		if(isEmail($(this).val())) {
			$(this).parent().parent().removeClass('has-error');
		}
		
	});
	
	$('#password-w1, #name-w1').keyup(function(){
		
		if($(this).val()) {
			$(this).parent().parent().removeClass('has-error');
		}
		
	});
	
	$('#ccnumber-w1').keyup(function(){
		
		var getCCNumber = $(this).val();
		getCCNumber = getCCNumber.replace(/ /g,'').replace(/_/g,'');
		
		if(getCCNumber.length == 16) {
			$(this).parent().parent().removeClass('has-error');
		}
		
	});
	
	$('#cvv-w1').keyup(function(){
		
		if($(this).val().length == 3) {
			$(this).parent().parent().removeClass('has-error');
		} else {
			$(this).parent().parent().addClass('has-error');
		}
		
	});



	$('#wizard1').bootstrapWizard({
		'nextSelector': '.button-next',
		'previousSelector': '.button-previous', 
		onNext: function(tab, navigation, index) {
		
		if(index==1) {
			
			var bugs = 0;
			
			if(!isEmail($('#email-w1').val())) {				
				$('#email-w1').parent().parent().addClass('has-error')
				bugs = 1;
			}
			
			if(!$('#password-w1').val()) {
				$('#password-w1').parent().parent().addClass('has-error');
				bugs = 1;
			}
			
			
			if( bugs == 1) {
				return false;
			}
			
		}

		if(index==2) {
			
			var bugs = 0;
			
			if(!$('#name-w1').val()) {				
				$('#name-w1').parent().parent().addClass('has-error')
				bugs = 1;
			}
			
			if(!$('#ccnumber-w1').val()) {
				$('#ccnumber-w1').parent().parent().addClass('has-error');
				bugs = 1;
			}
			
			if(!$('#cvv-w1').val()) {
				$('#cvv-w1').parent().parent().addClass('has-error');
				bugs = 1;
			}
			
			if( bugs == 1) {
				return false;
			}
			
		}

	}, onTabShow: function(tab, navigation, index) {
		var $total = navigation.find('li').length;
		var $current = index+1;
		var $percent = ($current/$total) * 100;

		
		$('#wizard1').find('.progress-bar').css({width:$percent+'%'});
		
		$('#wizard1 > .steps li').each( function (index) {
			$(this).removeClass('complete');
		  	index += 1;
		  	if(index < $current) {
		    	$(this).addClass('complete');
		  	}
		 });
		
		if($current >= $total) {
			$('#wizard1').find('.button-next').hide();
			$('#wizard1').find('.button-finish').show();
		} else {
			$('#wizard1').find('.button-next').show();
			$('#wizard1').find('.button-finish').hide();
		}	
	}});
	
	$('#wizard2').bootstrapWizard({
		'nextSelector': '.button-next',
		'previousSelector': '.button-previous', 
		'lastSelector': '.button-deploy',
		'firstSelector': '.button-finish',
		onFirst: function(tab, navigation, index) {
			$('#tab7').html('');
		},
		onLast: function(tab, navigation, index) {
			if(index == 6){
				
				
				if(!$('#accept').attr("checked")) {
					alert('确认需要部署的内容未勾选！');
					return false;
				}
			}
		},
		onNext: function(tab, navigation, index) {
		if(index==1) {
			var bugs = 1;
			checkboxs = $('#tab1').find('input');
			for(i=0;i<checkboxs.length;i++) {
				if(checkboxs[i].checked) {
					bugs =0;
					break;
				}
			}
			if(bugs == 1) {
				$('#tab1').append('<font color="red">未选择任何项目！请选择要发布的项目！</font>');
				return false;
			}

		}

		if(index==2) {
			var bugs = 1;
			checkboxs = $('#tab2').find('input');
			for(i=0;i<checkboxs.length;i++) {
				if(checkboxs[i].checked) {
					bugs =0;
					break;
				}
			}
			if(bugs == 1) {
				$('#tab2').append('<font color="red">未选择任何系统及服务器！请选择要发布的项目及服务器！</font>');
				return false;
			}
		}

		if(index==3) {
			var bugs = 0;
			var p = $('p.success');
			for(i=0;i<p.length;i++){
				//console.log($(p[i]).find('i'));
				if($(p[i]).find('i').size() == 0) {
					$(p[i]).html('<font color="red">有发布物未上传或未打包</font>');
					bugs = 1;
				}
			}
			if(bugs == 1) {
				return false;
			}
		}

		if(index==5) {
			var bugs = 0;
			var inputs = $('#tab5').find('input');
			var v = new Array();
			for(i=0;i<inputs.length;i++) {
				//console.log($(inputs[i]).val());
				if(isNaN($(inputs[i]).val())) {
					bugs = 1;
					$(inputs[i]).nextUntil('p').html('<font color="red">发布顺序设置不正确，必须为数字</font>');
				}
				v.push($(inputs[i]).val());
			}

			if(isRepeat(v)) {
				bugs = 1;
				$('#tab5').append('<font color="red">发布顺序设置不正确，不能有重复的顺序</font>');
			}

			if(bugs == 1) {
				return false;
			}

			
		}

	}, onTabShow: function(tab, navigation, index) {
		var $total = navigation.find('li').length;
		var $current = index+1;
		var $percent = ($current/$total) * 100;
		
		
		$('#wizard2').find('.progress-bar').css({width:$percent+'%'});
		
		$('#wizard2 > .steps li').each( function (index) {
			$(this).removeClass('complete');
		  	index += 1;
		  	if(index < $current) {
		    	$(this).addClass('complete');
		  	}
		 });
		
		if($current >= $total) {
			$('#wizard2').find('.button-next').hide();
			$('#wizard2').find('.button-deploy').hide();
			$('#wizard2').find('.button-finish').show();
		} else if($current == 6){
			$('#wizard2').find('.button-deploy').show();
			$('#wizard2').find('.button-next').hide();
			$('#wizard2').find('.button-finish').hide();
		}else{
			$('#wizard2').find('.button-deploy').hide();
			$('#wizard2').find('.button-next').show();
			$('#wizard2').find('.button-finish').hide();
		}

		var tab = '#tab' + ($current -1) ;
		var inputs = $(tab).find('input');
		
		switch($current) {
			case 2:
				tab2(inputs);
				break;
			case 3:
				tab3(inputs);
				break;
			case 4:
				tab4();
				break;
			case 5:
				tab5();
				break;
			case 6:
				tab6(inputs);
				break;
			case 7:
			 	// document.getElementById('form1').submit();
			 	
			 		tab7();
			 		break;
			 	
			 	

		} 	
	}});


	
	/* ---------- Datapicker ---------- */
	$('.datepicker').datepicker();

	/* ---------- Choosen ---------- */
	$('[data-rel="chosen"],[rel="chosen"]').chosen();

	/* ---------- Placeholder Fix for IE ---------- */
	$('input, textarea').placeholder();

	/* ---------- Auto Height texarea ---------- */
	$('textarea').autosize();   
});
