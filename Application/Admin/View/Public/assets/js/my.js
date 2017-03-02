function check() {
	//alert('111222');
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
	  	//alert('111');
			 // 获取已激活的标签页的名称
			 var activeTab = $(e.target).text().trim(); 
			// alert('111');
			 var tab1 = document.getElementById('tab1');
			 //alert(tab1);
			 var inputs = tab1.getElementsByTagName('input');
			 var svns = new Array();
			 var svrs = new Array();
			 var filepaths = new Array();
			// alert(inputs);
			 for(i=0;i<inputs.length;i++) {
			 	var obj = inputs[i];
			 	var svn = '';
			 	var svr = '';
			 	var filepath = '';
			 	if(obj.type == 'checkbox' && obj.checked) {
			 		if(obj.value.indexOf('-') > 0) {
			 			svn = obj.value.substr(0,(obj.value.indexOf('-'))) + 'svn';
			 			filepath = obj.value.substr(0,(obj.value.indexOf('-'))) + 'path';
			 		}else {
			 			svn = obj.value + 'svn';
			 			filepath = obj.value + 'path';
			 		}

			 		if(svns.indexOf(svn) < 0) {
			 			svns.push(svn);
			 		}

			 		if(filepaths.indexOf(filepath) < 0) {
			 			filepaths.push(filepath);
			 		}

			 		svrs.push(obj.name);
			 		
			 	}
			 }

			 
		switch(activeTab) {
			case '输入要部署系统的svn地址':
				writeTab2(svns);
				break;
			case '上传额外的部署文件':
				writeTab3(filepaths);
				break;
			case '确认需要部署的内容':
				writeTab4(svrs,svns,filepaths);
				break;
			case '完成部署':
				document.getElementById('form1').submit();
				break;

			} 
			});

}


// function writeTab2(svns) {
// 	var p = document.getElementById('tab2');
// 	var html = '<div class="form-group"><div class="col-md-3"></div><div class="col-md-9"><p class="form-control-static">请输入要部署系统的SVN地址</p><br /></div></div>';

// 	for(i=0;i<svns.length;i++) {
// 		html = html + '<div class="form-group"><label class="col-md-3 control-label" for="text-input">' + svns[i].substr(0,svns[i].indexOf('svn')) + ' svn tag</label><div class="col-md-9"><input type="text" id="' + svns[i] + '" name="' + svns[i] + '" class="form-control" placeholder="' + svns[i].substr(0,svns[i].indexOf('svn')) + '  svn tag"><span class="help-block">输入' + svns[i].substr(0,svns[i].indexOf('svn')) + '的svn地址</span></div></div>';
// 	}

// 	p.innerHTML = html;

// }

// function writeTab3(filepaths) {
// 	var p = document.getElementById('tab3');
// 	var html = '<div class="form-group"><div class="col-md-3"></div><div class="col-md-9"><p class="form-control-static">上传额外的部署文件</p><br /></div></div>';

// 	for(i=0;i<filepaths.length;i++) {
// 		html = html + '<div class="form-group"><label class="col-md-3 control-label" for="text-input">' + filepaths[i].substr(0,filepaths[i].indexOf('path')) + '额外文件部署路径</label><div class="col-md-9"><input type="text" id="' + filepaths[i] + '" name="' + filepaths[i] + '" class="form-control" placeholder="' + filepaths[i].substr(0,filepaths[i].indexOf('path')) + '额外文件部署路径"><span class="help-block">输入' + filepaths[i].substr(0,filepaths[i].indexOf('path')) + '额外文件部署路径</span></div></div>';
// 		filename = filepaths[i].replace('path','file');
// 		html = html + '<div class="form-group"><label class="col-md-3 control-label" for="' + filename + '">上传' + filepaths[i].substr(0,filepaths[i].indexOf('path')) + '额外部署文件</label><div class="col-md-9"><input type="file" id="' + filename + '" name="' + filename + '" multiple /><br /></div></div>';
// 	}

// 	p.innerHTML = html;


// }

// function writeTab4(svrs,svns,filepaths) {
// 	var p = document.getElementById('tab4');
// 	var html = '<div class="col-md-3"></div><div class="col-md-9"><h4><strong>1. 要部署系统的服务器如下：</strong></h4>';
	
// 	//var svrs= new Array("webfrontsvr","wechatsvr1","wechatsvr2","nodecoresvr1","nodecoresvr2","pcwebsvr1","pcwebsvr2")
// 	//alert(html);
	
// 	for(i=0;i<svrs.length;i++) {
		

// 		if(document.getElementById(svrs[i]).checked) {
// 			//alert(document.getElementById(svrs[i]).checked);
// 			html = html + '<p><li>' + document.getElementById(svrs[i]).value + '</li></p>';

// 			//alert(html);
// 			//html = html + "<br><p>1111</p>";
// 		}
// 	}

	

// 	//var svns = new Array('webfrontsvn','wechatsvn','nodecoresvn','pcwebsvn');
// 	//alert(svns[3]);
// 	html = html + '</div><div class="col-md-12"><hr /></div><div class="col-md-3"></div><div class="col-md-9"><h4><strong>2. 要部署系统的svn地址如下：</strong></h4>';

// 	for(i=0;i<svns.length;i++) {

// 		if(document.getElementById(svns[i]).value != '') {
// 	    	html = html + '<p><li>' + svns[i].substr(0,svns[i].indexOf('svn')) + "的svn地址：" + document.getElementById(svns[i]).value + "</li></p>";
// 		}
// 	}

// 	//var filepaths = new Array('webfrontpath','wechatpath','nodecorepath','pcwebpath');
// 	html = html + '</div><div class="col-md-12"><hr /></div><div class="col-md-3"></div><div class="col-md-9"><h4><strong>3. 要额外部署的文件路径如下：</strong></h4>';

// 	for(i=0;i<filepaths.length;i++) {

// 		if(document.getElementById(filepaths[i]).value != '') {
// 			html = html + '<p><li>' + filepaths[i].substr(0,filepaths[i].indexOf('path')) + "需要额外部署的路径：" + document.getElementById(filepaths[i]).value + "</li></p>";
// 			filename = filepaths[i].replace('path','file');
// 			html = html + '<p class="col-md3"><li>' + filepaths[i].substr(0,filepaths[i].indexOf('path')) + "需要额外部署的文件：" + document.getElementById(filename).value + "</li></p>";
// 		}
// 	}

	
// 	html = html + 
// 	'</div><div class="col-md-12"><hr /></div><div class="col-md-3"></div><div class="col-md-9"><div class="form-group"><div class="checkbox-custom checkbox-default bk-margin-bottom-10"><input id="accept" name="accept" type="checkbox"/><label for="accept"> 确认需要部署的内容 <a href="form-wizard.html#">Terms of Service</a></label></div></div></div>'

// 	p.innerHTML = html;
// }



	// $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
	// 	var activeTab = $(e.target).text().trim();
	// 	var target = $(e.target).attr('href');
	// 	var a = target.substr(target.indexOf('tab') + 3);
	// 	var tab = '#tab' + (a -1);
	// 	alert(tab);
	// 	var inputs = $(tab).find('input');
		
		



	// 	switch(activeTab) {
	// 		case '选择要发布的系统及服务器':
	// 			tab2(inputs);
	// 			break;
	// 		case '输入要部署系统的svn地址或上传程序包':
	// 			tab3(inputs);
	// 			break;
	// 		case '上传额外的部署文件':
	// 			tab4();
	// 			break;
	// 		case '设置系统发布顺序':
	// 			tab5();
	// 			break;
	// 		case '确认需要部署的内容':
	// 			tab6(inputs);
	// 			break;
	// 		case '完成部署':
	// 		 	// document.getElementById('form1').submit();
	// 		 	tab7();
	// 		 	break;

	// 	} 
			
	// });
	
// function deployclick() {
// 	$('#deploywizard').bootstrapWizard({
// 		'nextSelector': '.button-next',
// 		'previousSelector': '.button-previous', 
// 		onNext: function(tab, navigation, index) {
		

// 	}, onTabShow: function(tab, navigation, index) {
// 		var $total = navigation.find('li').length;
// 		var $current = index+1;
// 		var $percent = ($current/$total) * 100;
// 		$('#deploywizard').find('.progress-bar').css({width:$percent+'%'});
		
// 		$('#deploywizard > .steps li').each( function (index) {
// 			$(this).removeClass('complete');
// 		  	index += 1;
// 		  	if(index < $current) {
// 		    	$(this).addClass('complete');
// 		  	}
// 		 });
		
// 		if($current >= $total) {
// 			$('#deploywizard').find('.button-next').hide();
// 			$('#deploywizard').find('.button-finish').show();
// 		} else {
// 			$('#deploywizard').find('.button-next').show();
// 			$('#deploywizard').find('.button-finish').hide();
// 		}
// 		var tab = '#tab' + ($current -1) ;
// 		alert(tab);
// 		var inputs = $(tab).find('input');
		
// 		switch($current) {
// 			case 2:
// 				tab2(inputs);
// 				break;
// 			case 3:
// 				tab3(inputs);
// 				break;
// 			case 4:
// 				tab4();
// 				break;
// 			case 5:
// 				tab5();
// 				break;
// 			case 6:
// 				tab6(inputs);
// 				break;
// 			case 7:
// 			 	// document.getElementById('form1').submit();
// 			 	tab7();
// 			 	break;

// 		} 

// 	}});
// }
	
	
	



function tab2(inputs) {
	var arr = new Array();

	//alert(e.target.substr(e.target.indexOf('#')));
	for(i=0;i<inputs.length;i++) {
		var obj = inputs[i];
		
		if(obj.type == 'checkbox' && obj.checked) {
			
			arr.push(obj.value);
		}
	}
	
	var url = "{:U('Admin/Deploy/system','','')}";
	$.post('system',
	  {
	    project_ids:arr
	    
	  },
	  function(data,status){
	    if(status) {
	    	//alert(data);
	    	var p = document.getElementById('tab2');
	    	var html = '<div class="form-group"><div class="col-md-3"></div><div class="col-md-9"><p class="form-control-static">选择要发布的系统及服务器</p><br /></div></div>';
	    	for(i=0;i<data.length;i++) {
	    		html = html + '<div class="form-group"><label class="col-md-3 control-label">' + data[i]['system_name'] + '</label><div class="col-md-9">';
	    		var host = data[i]['host'];
	    		
	    		for(j=0;j<host.length;j++) {
	    			
	    			html = html + '<div class="checkbox-custom"><input type="checkbox" id="' + data[i]['system_name'] + '_' + host[j]['host_id'] + '" name="h_' + host[j]['host_name'] + '" value="' + data[i]['system_id'] + '_' + host[j]['host_id'] + '"><label for="' + data[i]['system_name'] + '_' + host[j]['host_id'] + '"> ' + host[j]['host_name'] + '-' + host[j]['ipaddr'] + '</label></div>';
	    		}
	    		html = html + '</div></div>';
	    	}
	    	p.innerHTML = html;
	    }
	  });
}


function tab3(inputs) {
	var arr = new Array();

	//alert(e.target.substr(e.target.indexOf('#')));
	for(i=0;i<inputs.length;i++) {
		var obj = inputs[i];
		
		if(obj.type == 'checkbox' && obj.checked) {
			
			arr.push(obj.value);
		}
	}


	
	var url = "{:U('Admin/Deploy/host','','')}";
	$.post('host',
	  {
	    ids:arr
	    
	  },
	  function(data,status){
	    if(status) {
	    	//alert(data);
	    	var p = document.getElementById('tab3');
	    	var html = '<div class="form-group"><div class="col-md-3"></div><div class="col-md-9"><p class="form-control-static">输入要部署系统的svn地址或上传程序包</p><br /></div></div>';
	    	for(i=0;i<data.length;i++) {

	    		if(data[i]['deploy_rule']['rule_name'].indexOf('SVN') > 0) {
	    			html = html + '<div class="form-group"><label class="col-md-3 control-label" for="text-input">' + data[i]['system_name'] + ' svn tag</label><div class="col-md-9"><input type="text" id="' +  data[i]['system_id'] + '" name="svn_' +  data[i]['system_name'] + '" class="form-control svn" placeholder="' +  data[i]['system_name'] + '  svn tag"><span class="help-block">输入' +  data[i]['system_name'] + '的svn地址</span><p class="success" id="pkg_' + data[i]['system_id'] + '"></p><input type="button" onclick="code2pkg(\'pkg_' + data[i]['system_id'] + '\')" value="打包"/></div></div>';
	    		}else {
	    			html = html + ' <form  id="pkg_' + data[i]['system_id'] + '" enctype="multipart/form-data" ><div class="form-group"><label class="col-md-3 control-label" for="' + data[i]['system_id'] + '">上传' + data[i]['system_name'] + '已打包的部署文件</label><div class="col-md-9"><input type="file" id="' + data[i]['system_id'] + '" name="pkg_' + data[i]['system_name'] + '" multiple/><p class="success" id="pkg_' + data[i]['system_id'] + '"></p><input type="button" onclick="upload(\'pkg_' + data[i]['system_id'] + '\')" value="上传"/><br /></div></div></form>';
	    		}

	    		// html = html + '<div class="form-group"><label class="col-md-3 control-label">' + data[i]['system_name'] + '</label><div class="col-md-9">';
	    		// var host = data[i]['host'];
	    		
	    		// for(j=0;j<host.length;j++) {
	    			
	    		// 	html = html + '<div class="checkbox-custom"><input type="checkbox" id="' + host[j]['host_name'] + '" name="' + host[j]['host_name'] + '" value="' + host[j]['host_id'] + '"><label for="' + host[j]['host_name'] + '"> ' + host[j]['host_name'] + '-' + host[j]['ipaddr'] + '</label></div>';
	    		// }
	    		// html = html + '</div></div>';
	    	}
	    	
	    	p.innerHTML = html;
	    }
	  });
}

function tab4() {


	var inputs = $('#tab2').find('input');
	var arr = new Array();

	//alert(e.target.substr(e.target.indexOf('#')));
	for(i=0;i<inputs.length;i++) {
		var obj = inputs[i];
		
		if(obj.type == 'checkbox' && obj.checked) {
			
			arr.push(obj.value);
		}
	}

	var url = "{:U('Admin/Deploy/host','','')}";
	$.post('host',
	  {
	    ids:arr
	    
	  },
	  function(data,status){
	    if(status) {
	    	//alert(data);
	    	var p = document.getElementById('tab4');
	    	var html = '<div class="form-group"><div class="col-md-3"></div><div class="col-md-9"><p class="form-control-static">上传额外的部署文件</p><br /></div></div>';
	    	for(i=0;i<data.length;i++) {

	    		
	    			html = html + '<div class="form-group"><label class="col-md-3 control-label" for="text-input">' + data[i]['system_name'] + '额外文件部署路径</label><div class="col-md-9"><input type="text" id="' + data[i]['system_id'] + '" name="ep_' + data[i]['system_name'] + '" class="form-control" placeholder="' + data[i]['system_name'] + '额外文件部署路径"><span class="help-block">输入' + data[i]['system_name'] + '额外文件部署路径</span></div></div>';
		
	    		
	    			html = html + '<form  id="ef_' + data[i]['system_id'] + '" enctype="multipart/form-data" ><div class="form-group"><label class="col-md-3 control-label" for="' + data[i]['system_id'] + '">上传' + data[i]['system_name'] + '已打包的额外文件</label><div class="col-md-9"><input type="file" id="' + data[i]['system_id'] + '" name="ef_' + data[i]['system_name'] + '" multiple /><p id="ef_' + data[i]['system_id'] + '"></p><input type="button" onclick="upload(\'ef_' + data[i]['system_id'] + '\')" value="上传"/><br /></div></div></form>';
	    		

	    		// html = html + '<div class="form-group"><label class="col-md-3 control-label">' + data[i]['system_name'] + '</label><div class="col-md-9">';
	    		// var host = data[i]['host'];
	    		
	    		// for(j=0;j<host.length;j++) {
	    			
	    		// 	html = html + '<div class="checkbox-custom"><input type="checkbox" id="' + host[j]['host_name'] + '" name="' + host[j]['host_name'] + '" value="' + host[j]['host_id'] + '"><label for="' + host[j]['host_name'] + '"> ' + host[j]['host_name'] + '-' + host[j]['ipaddr'] + '</label></div>';
	    		// }
	    		// html = html + '</div></div>';
	    	}
	    	
	    	p.innerHTML = html;
	    }
	  });


}


function tab5() {
	var inputs = $('#tab2').find('input');
	var arr = new Array();

	//alert(e.target.substr(e.target.indexOf('#')));
	for(i=0;i<inputs.length;i++) {
		var obj = inputs[i];
		
		if(obj.type == 'checkbox' && obj.checked) {
			
			arr.push(obj.value);
		}
	}


	
	var url = "{:U('Admin/Deploy/host','','')}";
	
	$.post('host',
	  {
	    ids:arr
	    
	  },
	  function(data,status){
	    if(status) {
	    	//alert(data);
	    	var p = document.getElementById('tab5');
	    	var html = '<div class="form-group"><div class="col-md-3"></div><div class="col-md-9"><p class="form-control-static">设置系统发布顺序</p><br /></div></div>';
	    	for(i=0;i<data.length;i++) {

	    		
	    		html = html + '<div class="form-group"><label class="col-md-3 control-label" for="text-input">' + data[i]['system_name'] + ' 发布顺序</label><div class="col-md-3"><input type="text"  id="' +  data[i]['system_id'] + '" name="ord_' +  data[i]['system_name'] + '" class="form-control" placeholder="" value='+ (i+1) +'><span class="help-block">输入' +  data[i]['system_name'] + '的发布顺序，以数字1 2 3来表示</span><p></p></div></div>';
	    		

	    		// html = html + '<div class="form-group"><label class="col-md-3 control-label">' + data[i]['system_name'] + '</label><div class="col-md-9">';
	    		// var host = data[i]['host'];
	    		
	    		// for(j=0;j<host.length;j++) {
	    			
	    		// 	html = html + '<div class="checkbox-custom"><input type="checkbox" id="' + host[j]['host_name'] + '" name="' + host[j]['host_name'] + '" value="' + host[j]['host_id'] + '"><label for="' + host[j]['host_name'] + '"> ' + host[j]['host_name'] + '-' + host[j]['ipaddr'] + '</label></div>';
	    		// }
	    		// html = html + '</div></div>';
	    	}
	    	p.innerHTML = html;
	    }
	  });
}


function tab6() {

	//$("[name='next']").val('Deploy');
	

	var inputs = $('#tab2').find('input');
	var arr = new Array();

	//alert(e.target.substr(e.target.indexOf('#')));
	for(i=0;i<inputs.length;i++) {
		var obj = inputs[i];
		
		if(obj.type == 'checkbox' && obj.checked) {
			
			arr.push(obj.value);
		}
	}

	var tab3inputs = $('#tab3').find('input');
	var arr2 = new Array();
	var t = 0;
	for(i=0;i<tab3inputs.length;i++) {
		var obj = tab3inputs[i];
		
		if(obj.type == 'file' && obj.value != '') {
			
			//arr2[t] = new Array();
			arr2.push(obj.id);
			arr2.push(obj.value);
			//alert(t);alert(arr2[t]['system_id']);
			
			t++;
		}else if(obj.type == 'text' && obj.value != '') {
			
			
			arr2.push(obj.id);
			arr2.push(obj.value);
			//alert(t);alert(arr2[t]['system_id']);
			//arr2.push(arr2[t]);
			t++;
		}
	}


	var tab4inputs = $('#tab4').find('input');
	var arr3 = new Array();
	t = 0;
	for(i=0;i<tab4inputs.length;i++) {
		var obj = tab4inputs[i];
		
		if(obj.type != 'button' && obj.value != '') {
			
			arr3.push(obj.id);
			arr3.push(obj.value);
			t++;
		}
	}


	var tab5inputs = $('#tab5').find('input');
	var arr4 = new Array();
	t = 0;
	for(i=0;i<tab5inputs.length;i++) {
		var obj = tab5inputs[i];
		
		if(obj.type == 'text' && obj.value != '') {
			
			arr4.push(obj.id);
			arr4.push(obj.value);
		}
	}

	
	

	var url = "{:U('Admin/Deploy/summary','','')}";
	
	$.post('summary',
	  {
	    ids:arr,
	    svn:arr2,
	    extfile:arr3,
	    order:arr4
	  },
	  function(data,status){
	    if(status) {
	    	//alert(data);
	    	//
	    	
	    	//console.log(data);
	    	var p = document.getElementById('tab6');
	    	var html = '<div class="form-group"><div class="col-md-3"></div><div class="col-md-9"><p class="form-control-static"><h4><strong>确认需要部署的内容</strong></h4></p><br /></div></div>';
	    	for(i=0;i<data.length;i++) {

	    		
	    			// html = html + '<div class="form-group"><label class="col-md-3 control-label" for="text-input">' + data[i]['system_name'] + ' 发布顺序</label><div class="col-md-3"><input type="text"  id="order_' +  data[i]['system_id'] + '" name="order_' +  data[i]['system_id'] + '" class="form-control" placeholder="" value='+ (i+1) +'><span class="help-block">输入' +  data[i]['system_name'] + '的发布顺序，以数字1 2 3来表示</span></div></div>';
	    			html = html + '<hr/><ul><li>' + data[i]['system_name'] + '</li>';
	    			html = html + '<ul><li>所属项目：' + data[i]['project']['project_name'] + '</li>';
	    			html = html + '<li>部署规则：' + data[i]['deploy_rule']['rule_name'] + '</li>';
	    			if(data[i]['deploy_rule']['rule_name'].indexOf('SVN') > 0) {
	    				html = html + '<li>svn tag ：' + data[i]['deployinfo']['svn'] + '</li>';
	    			}else{
	    				html = html + '<li>程序包 ：' + data[i]['deployinfo']['pkg'] + '</li>';
	    			}
	    			html = html + '<li>部署路径：' + data[i]['deploy_path'] + '</li>';
	    			html = html + '<li>部署目标：' + data[i]['pkg_name'] + '</li>';
	    			if(data[i]['deployinfo'].hasOwnProperty('extfile')) {
	    				html = html + '<li>额外部署文件：' + data[i]['deployinfo']['extfile'] + '</li>';
	    				html = html + '<li>额外部署文件路径：' + data[i]['deployinfo']['extpath'] + '</li>';
	    			}
	    			
	    			html = html + '<li>备份路径：' + data[i]['backup_path'] + '</li>';
	    			html = html + '<li>依赖服务：' + data[i]['service']['service_name'] + '</li>';
	    			html = html + '<li>发布顺序：' + data[i]['deployinfo']['order'] + '</li>';
	    			html = html + '<li>部署主机：</li>';
	    			html = html + '<ul>';
	    			for(j=0;j<data[i]['host'].length;j++) {
	    				html = html + '<li>' + data[i]['host'][j]['host_name'] + '：' + data[i]['host'][j]['ipaddr'] + '</li>';
	    			}
	    			html = html + '</ul></ul></ul>';
	    		

	    		
	    	}
	    	html = html + 
	'</div><div class="col-md-12"><hr /></div><div class="col-md-3"></div><div class="col-md-9"><div class="form-group"><div class="checkbox-custom checkbox-default bk-margin-bottom-10"><input id="accept" name="accept" type="checkbox"/><label for="accept"> 确认需要部署的内容 <a href="form-wizard.html#">Terms of Service</a></label></div></div></div>'
	    	p.innerHTML = html;
	    }
	  });
	

}

function tab7() {
	
	var inputs = $('#tab2').find('input');
	var arr = new Array();

	//alert(e.target.substr(e.target.indexOf('#')));
	for(i=0;i<inputs.length;i++) {
		var obj = inputs[i];
		
		if(obj.type == 'checkbox' && obj.checked) {
			
			arr.push(obj.value);
		}
	}

	var tab3inputs = $('#tab3').find('input');
	var arr2 = new Array();
	var t = 0;
	for(i=0;i<tab3inputs.length;i++) {
		var obj = tab3inputs[i];
		
		if(obj.type == 'file' && obj.value != '') {
			
			//arr2[t] = new Array();
			arr2.push(obj.id);
			arr2.push(obj.value);
			//alert(t);alert(arr2[t]['system_id']);
			
			t++;
		}else if(obj.type == 'text' && obj.value != '') {
			
			
			arr2.push(obj.id);
			arr2.push(obj.value);
			//alert(t);alert(arr2[t]['system_id']);
			//arr2.push(arr2[t]);
			t++;
		}
	}


	var tab4inputs = $('#tab4').find('input');
	var arr3 = new Array();
	t = 0;
	for(i=0;i<tab4inputs.length;i++) {
		var obj = tab4inputs[i];
		
		if(obj.type != 'button' && obj.value != '') {
			
			arr3.push(obj.id);
			arr3.push(obj.value);
			t++;
		}
	}


	var tab5inputs = $('#tab5').find('input');
	var arr4 = new Array();
	t = 0;
	for(i=0;i<tab5inputs.length;i++) {
		var obj = tab5inputs[i];
		
		if(obj.type == 'text' && obj.value != '') {
			
			arr4.push(obj.id);
			arr4.push(obj.value);
		}
	}

	
	

	var url = "{:U('Admin/Deploy/summary','','')}";
	
	$.post('summary',
	  {
	    ids:arr,
	    svn:arr2,
	    extfile:arr3,
	    order:arr4
	  },
	  function(data,status){
	    if(status) {
	    	var p = document.getElementById('tab7');
	    	var html = '<div class="form-group" id="startdeploy"><div class="col-md-3"></div><div class="col-md-9"><p class="form-control-static"><h4><strong id="start">开始部署</strong></h4></p></div></div>';
	    	p.innerHTML = html;
	    	if(deploy(data)) {

	    		$('strong#start').html('<font color="red">恭喜！系统顺利发布完毕</font>');
	    	}else{
	    		$('strong#start').html('<font color="red">部署出现异常，任务中断，请解决后重新部署！</font>');
	    	}
	    	
	   }
	  });
	    

	
}


function deploy(data) {
	for(i=0;i<data.length;i++) {

	    		
	    			// html = html + '<div class="form-group"><label class="col-md-3 control-label" for="text-input">' + data[i]['system_name'] + ' 发布顺序</label><div class="col-md-3"><input type="text"  id="order_' +  data[i]['system_id'] + '" name="order_' +  data[i]['system_id'] + '" class="form-control" placeholder="" value='+ (i+1) +'><span class="help-block">输入' +  data[i]['system_name'] + '的发布顺序，以数字1 2 3来表示</span></div></div>';
	    			//html = html + '<hr/><ul><li>' + data[i]['system_name'] + '</li><ul>';
	    			$('#startdeploy').after('<hr/><ul><li>' + data[i]['system_name'] + '</li><ul id=' + data[i]['system_name'] + '></ul></ul>');
	    			for(j=0;j<data[i]['host'].length;j++) {
	    				//html = html + '<li>' + data[i]['host'][j]['host_name'] + '：' + data[i]['host'][j]['ipaddr'] + '</li>';
	    				
	    				// $.post('deploy',
	    				// 		{
	    				// 			system:data[i],
	    				// 			host:data[i]['host'][j],
	    				// 		},
	    				// 		function(msg,status) {
	    				// 			if(status) {
	    				// 				if(msg['ret'] == 'success') {
	    				// 					$('li#' + msg['ipaddr']).html(msg['host_name'] + '：' + msg['ipaddr'] + '  <i class="fa fa-check" aria-hidden="true"></i>');
	    				// 				}else if(msg['ret'] == 'sys-failure'){
	    				// 					$('li#' + msg['ipaddr']).html(msg['host_name'] + '：' + msg['ipaddr'] + '<font color="red"> 程序部署失败，详情请查看日志</font>');
	    				// 				}else if(msg['ret'] == 'ef-failure') {
	    				// 					$('li#' + msg['ipaddr']).html(msg['host_name'] + '：' + msg['ipaddr'] + '<font color="red"> 程序部署成功，额外部署文件发布失败，详情请查看日志</font>');
	    				// 				}
	    				// 			}
	    				// 		}
	    				// 	);
	    				// 	
	    				var form = new FormData();
	    				form.append('system_id',data[i]['system_id']);
	    				form.append('current_version',data[i]['current_version']);
	    				form.append('current_release_time',data[i]['current_release_time']);
	    				form.append('previous_version',data[i]['previous_version']);
	    				form.append('previous_release_time',data[i]['previous_release_time']);
	    				form.append('tmp_version',data[i]['tmp_version']);
	    				form.append('system_name',data[i]['system_name']);

	    				form.append('ip',data[i]['host'][j]['ipaddr']);
						form.append('deploy_rule',data[i]['deploy_rule']['rule_name']);
						form.append('service',data[i]['service']['service_name']);
						form.append('service_home',data[i]['service']['service_home']);
						form.append('deploy_path',data[i]['deploy_path']);
						form.append('pkg_name',data[i]['pkg_name']);
						form.append('backup_path',data[i]['backup_path']);
						form.append('tmp_pkg',data[i]['tmp_pkg']);
						if(data[i]['deployinfo'].hasOwnProperty('extfile')) {
							form.append('extfile',data[i]['deployinfo']['extfile']);
							form.append('extpath',data[i]['deployinfo']['extpath']);
							form.append('tmp_ef',data[i]['tmp_ef']);
						}else{
							form.append('extfile','');
							form.append('tmp_ef','');
							form.append('extpath','');
						}
						form.append('system_name',data[i]['system_name']);
						form.append('host_name',data[i]['host'][j]['host_name']);	
						lisel = 'li#' + data[i]['system_name'] + '_' + data[i]['host'][j]['host_name'];
						var result = false;
	    				 $.ajax({
					        url: 'deploy',  //server script to process data
					        type: 'POST',
					        // xhr: function() {  // custom xhr
					        //     myXhr = $.ajaxSettings.xhr();
					        //     if(myXhr.upload){ // check if upload property exists
					        //         myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // for handling the progress of the upload
					        //     }
					        //     return myXhr;
					        // },
					        //Ajax事件
					        beforeSend: function(XMLHttpRequest) { 
					                $('ul#' + data[i]['system_name']).append('<li id="' + data[i]['system_name'] + '_' + data[i]['host'][j]['host_name'] + '">' + data[i]['host'][j]['host_name'] + '：' + data[i]['host'][j]['ipaddr'] + '  正在部署。。。</li>');
					                //Pause(this,100000); 
					            },  
					        success: function(msg) { 


						        	if(msg.ret == 'success') {
	    									$(lisel).html(msg.host_name + '：' + msg.ip + '  <i class="fa fa-check" aria-hidden="true"></i>');
	    									result = true;
	    								}else if(msg.ret == 'sys-failure'){
	    									$(lisel).html(msg.host_name + '：' + msg.ip + '<font color="red"> 程序部署失败，发布终止，详情请查看日志</font>');
	    									
	    									result = false;

	    								}else if(msg.ret == 'ef-failure') {
	    									$(lisel).html(msg.host_name + '：' + msg.ip + '<font color="red"> 程序部署成功，额外部署文件发布失败，发布终止，详情请查看日志</font>');
	    									
	    									result = false;
	    								}else if(msg.ret == 'ansible-failure') {
	    									$(lisel).html('<font color="red"> 未找到ansible-playbook，请检查ansible安装是否正确！</font>');
	    									
	    									result = false;
	    								}
					                
					            },   
					        error: function(msg) { 
					        	$(lisel).html(data[i]['host'][j]['host_name'] + '：' + data[i]['host'][j]['ipaddr'] + '<font color="red"> 部署失败，发布终止，详情请查看日志</font>');
					        	
					        	result = false;
					            },  
					        // Form数据
					        //data: {system:data[i],host:data[i]['host'][j]},
					        //data: JSON.stringify({ip:data[i]['host'][j]['ipaddr'],deploy_rule:data[i]['deploy_rule']['rule_name'],service:data[i]['service']['service_name'],service_home:data[i]['service']['service_home'],deploy_path:data[i]['deploy_path'],pkg_name:data[i]['pkg_name'],backup_path:data[i]['backup_path'],tmp_pkg:data[i]['tmp_pkg'],extfile:data[i]['deployinfo']['extfile'],extpath:data[i]['deployinfo']['extpath'],tmp_ef:data[i]['tmp_ef'],system_name:data[i]['system_name'],host_name:data[i]['host_name']}),
					        data: form,
					        //Options to tell JQuery not to process data or worry about content-type
					        cache: false,
					        contentType: false,
					        processData: false,
					        async:false,
						//dataType: "json"
					    });
	    				if(result == false) {
	    					return false;
	    				}
	    			}
	    			
	    		
	    	}
	    	return true;
	    
}



function upload(id) {
	//alert(id);
	//var fileObj = document.getElementById('pkg_2').files[0]; // 获取文件对象
		                 // 接收上传文件的后台地址 

           
		   // console.log(fileObj);
            // FormData 对象
            var formsel = 'form#' + id;
             var psel = 'p#' + id;
            //console.log($('#formpkg'));
            var form = new FormData($(formsel)[0]);
   //          console.log(form);
           
			// console.log($(psel));
			 $.ajax({
        url: 'upload',  //server script to process data
        type: 'POST',
        // xhr: function() {  // custom xhr
        //     myXhr = $.ajaxSettings.xhr();
        //     if(myXhr.upload){ // check if upload property exists
        //         myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // for handling the progress of the upload
        //     }
        //     return myXhr;
        // },
        //Ajax事件
        beforeSend: function(XMLHttpRequest) { 
                $(psel).text("正在上传..."); 
                //Pause(this,100000); 
            },  
        success: function(msg) { 
	        	if(msg == 'success') {
	                $(psel).html('<i class="fa fa-check" aria-hidden="true"></i>'); 
	        	}else {
	        		$(psel).html('<font color="red">' + msg + '</font>');
	        	}
                
            },   
        error: function(msg) { 
        	$(psel).html('<font color="red">' + msg + '</font>');
            },  
        // Form数据
        data: form,
        //Options to tell JQuery not to process data or worry about content-type
        cache: false,
        contentType: false,
        processData: false
    });


}

function code2pkg(id) {
	
            var psel = 'p#' + id;
            var system_id = id.substr(4);
            var svn = $('input#' + system_id + '.svn').val();
        if(checkURL(svn)) {
        	$(psel).text("正在打包...");	
            $.post(
            	"code2pkg",
            	{
            		system_id:system_id,
            		svn:svn
            	},
            	function(data,status) {
            		if(status) {
            			//console.log(data);
            			 if(data['ret_code'] == 0) {
            			 	 $(psel).html('<i class="fa fa-check" aria-hidden="true"></i>'); 
            			 	}else{
            			 		$(psel).html('<font color="red">' + data['last_line'] + '</font>');
            			 	}
            		}
            	}
            );
        }else {
        	$(psel).html('<font color="red">svn 地址不合法！</font>');
        }
	    

}



// function progressHandlingFunction(e){
//     if(e.lengthComputable){
//         $('progress').attr({value:e.loaded,max:e.total});
//     }
// }


function checkAll(checkid, divsid, check_name, div_name){
    var checklist = document.getElementsByName(check_name);
    var divlist = document.getElementsByName(div_name);
    var divsall = document.getElementById(divsid);
    if(document.getElementById(checkid).checked)
        {
        	divsall.setAttribute("class","checkbox-custom checkbox-danger");
        for(var i=0;i<checklist.length;i++)
        {
          checklist[i].checked = 1;
          divlist[i].setAttribute("class","checkbox-custom checkbox-danger");
          //checklist[i].setAttribute("class","checkbox-danger");
        }
    }else{
    	divsall.setAttribute("class","checkbox-custom checkbox-default");
        for(var j=0;j<checklist.length;j++)
        {
         checklist[j].checked = 0;
         divlist[j].setAttribute("class","checkbox-custom checkbox-default");
        }
    }
}


function checkOne(checkid,divid){
    var check = document.getElementById(checkid);
    var div = document.getElementById(divid);
    if(check.checked)
        {
        div.setAttribute("class","checkbox-custom checkbox-danger");
    }else{
    	div.setAttribute("class","checkbox-custom checkbox-default");
    }
}


function isRepeat(arr) {
    var hash = {};
    for(var i in arr) {
        if(hash[arr[i]] == '1234abc')
        {
            return true;
        }
        // 不存在该元素，则赋值为true，可以赋任意值，相应的修改if判断条件即可
        hash[arr[i]] = '1234abc';
    }
    return false;
}


function checkURL(url){ 
        var str=url; 
        //在JavaScript中，正则表达式只能使用"/"开头和结束，不能使用双引号 
        var Expression=/http(s)?:////([\w-]+\.)+[\w-]+(\/[\w- .\/?%&=]*)?/; 
        var objExp=new RegExp(Expression); 
        if(str.indexOf("localhost")){ 
            str = str.replace("localhost","127.0.0.1"); 
        } 
        if(objExp.test(str)==true){ 
            
            return true; 
        }else{ 
             
            return false; 
        } 
    }

function serviceMgr(btid,host_id,service_id,action,service,service_home,ip){
	if(confirm('确认要将服务' + service + ' '+ action + '？')) {
		var btsel = 'button#' + btid;
		var text = '';
		var cssclass = ''; 
		var click = '';
		if(action == 'stopped') {
			text = '开启';
			cssclass = 'btn btn-danger btn-sm';
			click = 'serviceMgr("' + btid + '","' + host_id + '","' + service_id + '","started","' + service + '","' + service_home + '","' + ip + '")';
		}else{
			text = '关闭';
			cssclass = 'btn btn-success btn-sm';
			click = 'serviceMgr("' + btid + '","' + host_id + '","' + service_id + '","stopped","' + service + '","' + service_home + '","' + ip + '")';
		}
		var oldtext = '';
		if(action == 'stopped') {
			oldtext = '关闭';
		}else{
			oldtext = '开启';
		}
		$(btsel).html('<img  class="bt-sm" src="/Application/Admin/View/Public/assets/img/loading.gif" alt="" />');
		 $.post(
	    	"/Admin/Host/serviceMgr",
	    	{
	    		action:action,
	    		service:service,
	    		service_home:service_home,
	    		ip:ip,
	    		host_id:host_id,
	    		service_id:service_id
	    	},
	    	function(data,status) {
	    		if(status) {
	    			//console.log(data);
	    			if(data['ret'] == 'success') {
	    			 	 $(btsel).html(text);
	    			 	 $(btsel).attr({
	    			 	 	"class":cssclass,
	    			 	 	"onclick":click
	    			 	});
    			 	}else if(data['ret'] == 'failure'){
    			 		alert('服务' + data['action'] + '失败');
    			 		$(btsel).html(oldtext);
    			 	}else if(data['ret'] == 'ansible-failure') {
    			 		alert('未找到ansible-playbook，请确认ansible安装是否正确！');
    			 		$(btsel).html(oldtext);
    			 	}
	    		}else{
	    			alert('执行失败');
    			 	$(btsel).html(oldtext);
	    		}
	    	}
	    );
	}
}
